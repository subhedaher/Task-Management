<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProjectReportController extends BaseController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('Report-Projects' , user());
        $projects = Project::select(['id', 'name', 'start_date', 'end_date', 'status', 'priority'])->get();
        return view('dashboard.reports.projects.index', ['projects' => $projects]);
    }

    public function project(Project $project)
    {
        $this->authorize('Report-Projects' , user());
        $project->load('tasks.members', 'tasks.attachments');

        $members = $project->tasks->flatMap->members->unique('id');
        $attachments = $project->attachments;
        $tasks = $project->tasks;

        return view('dashboard.reports.projects.show', [
            'project' => $project,
            'members' => $members,
            'attachments' => $attachments,
            'tasks' => $tasks,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $this->authorize('Report-Projects' , user());
        $status = $request->query('status', 'all');
        $priority = $request->query('priority', 'all');

        $query = Project::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($priority !== 'all') {
            $query->where('priority', $priority);
        }

        $projects = $query->get();

        $pdf = PDF::loadView('dashboard.reports.projects.pdf.project', ['projects' => $projects]);

        return $pdf->stream('projects_report.pdf');
    }

    public function projectpdf($projectId)
    {
        $this->authorize('Report-Projects' , user());
        $project = Project::with(['departments', 'member', 'tasks', 'attachments'])->findOrFail($projectId);
        $members = $project->tasks->flatMap->members->unique('id');
        $attachments = $project->attachments;
        $tasks = $project->tasks;

        $pdf = PDF::loadView('dashboard.reports.projects.pdf.show', ['project' => $project, 'tasks' => $tasks, 'members' => $members, 'attachments' => $attachments]);
        return $pdf->stream('project_report_' . $project->name . '.pdf');
    }
}
