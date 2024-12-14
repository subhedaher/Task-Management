<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Models\Task;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class TaskReportController extends BaseController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('Report-Tasks', user());
        $tasks = Task::select(['id', 'name', 'start_date', 'end_date', 'status', 'priority', 'project_id'])->with('project')->get();
        return view('dashboard.reports.tasks.index', ['tasks' => $tasks]);
    }

    public function task(Task $task)
    {
        $this->authorize('Report-Tasks', user());
        $members = $task->members;
        $attachments = $task->attachments;
        $activities = $task->activities;
        $productivities = $task->productivities;
        return view('dashboard.reports.tasks.show', ['task' => $task, 'members' => $members, 'attachments' => $attachments, 'activities' => $activities, 'productivities' => $productivities]);
    }

    public function downloadPdf(Request $request)
    {
        $this->authorize('Report-Tasks', user());
        $status = $request->query('status', 'all');
        $priority = $request->query('priority', 'all');

        $query = Task::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($priority !== 'all') {
            $query->where('priority', $priority);
        }

        $tasks = $query->get();

        $pdf = PDF::loadView('dashboard.reports.tasks.pdf.task', ['tasks' => $tasks]);

        return $pdf->stream('tasks_report.pdf');
    }

    public function taskpdf($taskId)
    {
        $this->authorize('Report-Tasks', user());
        $task = Task::with(['project', 'members', 'attachments', 'activities'])->findOrFail($taskId);
        $members = $task->members;
        $attachments = $task->attachments;
        $activities = $task->activities;
        $productivities = $task->productivities;

        $pdf = PDF::loadView('dashboard.reports.tasks.pdf.show', ['productivities' => $productivities, 'activities' => $activities, 'task' => $task, 'members' => $members, 'attachments' => $attachments]);
        return $pdf->stream('task_report_' . $task->name . '.pdf');
    }
}
