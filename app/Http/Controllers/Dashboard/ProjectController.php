<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectDepartment;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class ProjectController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user('admin')) {
            $projects = Project::withCount('tasks')
                ->withCount(['tasks as completed_tasks_count' => function ($q) {
                    $q->where('status', 'completed');
                }])
                ->orderBy('created_at', 'desc')->paginate(10);
        } else if ($request->user('member')) {
            if (user()->hasRole('Project Manager')) {
                $projects = Project::where('member_id', '=', user()->id)->withCount('tasks')
                    ->withCount(['tasks as completed_tasks_count' => function ($q) {
                        $q->where('status', 'completed');
                    }])
                    ->orderBy('created_at', 'desc')->paginate(10);
            } else if (user()->hasRole('Member')) {
                $memberTaskIds = TaskMember::where('member_id', user()->id)
                    ->pluck('task_id');

                $projectIds = Task::whereIn('id', $memberTaskIds)
                    ->pluck('project_id')
                    ->unique();

                $projects = Project::whereIn('id', $projectIds)->withCount('tasks')
                    ->withCount(['tasks as completed_tasks_count' => function ($q) {
                        $q->where('status', 'completed');
                    }])
                    ->orderBy('created_at', 'desc')->paginate(10);
            }
        }
        return view('dashboard.projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = ['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancled' => 'Cancled', 'overdue' => 'Overdue'];
        $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
        $departments = Department::where('status', '=', true)->get();
        return view('dashboard.projects.create', ['statuses' => $statuses, 'priorities' => $priorities, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $storeProjectRequest)
    {
        $storeProjectRequest->validated();

        $project = Project::create([
            'member_id' => $storeProjectRequest->input('member_id'),
            'name' => $storeProjectRequest->input('name'),
            'start_date' => $storeProjectRequest->input('start_date'),
            'end_date' => $storeProjectRequest->input('end_date'),
            'priority' => $storeProjectRequest->input('priority'),
            'status' => $storeProjectRequest->input('status'),
            'description' => $storeProjectRequest->input('description'),
            'admin_id' => user()->id,
        ]);

        if ($project) {
            foreach ($storeProjectRequest->input('departments') as $department) {
                ProjectDepartment::create([
                    'project_id' => $project->id,
                    'department_id' => $department,
                ]);
            }
            if ($storeProjectRequest->hasFile('attachments')) {
                foreach ($storeProjectRequest->file('attachments') as $image) {
                    $file_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileType = $image->getClientOriginalExtension();
                    $uploadedByAdmin = $storeProjectRequest->user('admin')->id  ?? null;
                    $uploadedByMember = $storeProjectRequest->user('member')->id  ?? null;
                    $attachment = new Attachment([
                        'file_name' => $file_name,
                        'file_type' => $fileType,
                        'uploaded_by_member' => $uploadedByMember,
                        'uploaded_by_admin' => $uploadedByAdmin,
                    ]);

                    $attachment->file_path = $image->store('attachments/projects', 'public');
                    $project->attachments()->save($attachment);
                }
            }
        }

        return redirect()->back()->with('message', 'Project Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('dashboard.projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $statuses = ['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancled' => 'Cancled', 'overdue' => 'Overdue'];
        $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
        $departments = Department::where('status', '=', true)->get();
        return view('dashboard.projects.edit', ['project' => $project, 'statuses' => $statuses, 'priorities' => $priorities, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $updateProjectRequest, Project $project)
    {
        $updateProjectRequest->validated();

        $updated = $project->update([
            'member_id' => $updateProjectRequest->input('member_id'),
            'name' => $updateProjectRequest->input('name'),
            'start_date' => $updateProjectRequest->input('start_date'),
            'end_date' => $updateProjectRequest->input('end_date'),
            'priority' => $updateProjectRequest->input('priority'),
            'status' => $updateProjectRequest->input('status'),
            'description' => $updateProjectRequest->input('description'),
        ]);

        if ($updated) {
            ProjectDepartment::where('project_id', '=', $project->id)->delete();
            foreach ($updateProjectRequest->input('departments') as $department) {

                ProjectDepartment::create([
                    'project_id' => $project->id,
                    'department_id' => $department,
                ]);
            }
            if ($updateProjectRequest->hasFile('attachments')) {
                foreach ($project->attachments as $attachment) {
                    Storage::delete($attachment->file_path);
                    $attachment->delete();
                }

                foreach ($updateProjectRequest->file('attachments') as $image) {
                    $file_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileType = $image->getClientOriginalExtension();
                    $uploadedByAdmin = $updateProjectRequest->user('admin')->id ?? null;
                    $uploadedByMember = $updateProjectRequest->user('member')->id ?? null;

                    $attachment = new Attachment([
                        'file_name' => $file_name,
                        'file_type' => $fileType,
                        'uploaded_by_member' => $uploadedByMember,
                        'uploaded_by_admin' => $uploadedByAdmin,
                    ]);

                    $attachment->file_path = $image->store('attachments/projects', 'public');

                    $project->attachments()->save($attachment);
                }
            }
        }

        return redirect()->route('dashboard.projects.index')->with('message', 'Project Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('message', 'Project Deleted Successfully');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->query('search');

        if ($searchTerm) {

            $projects = Project::where('name', 'LIKE', '%' . $searchTerm . '%')->get();
        } else {
            $projects = Project::withCount('tasks')
                ->withCount(['tasks as completed_tasks_count' => function ($q) {
                    $q->where('status', 'completed');
                }])
                ->orderBy('created_at', 'desc')->paginate(10);
        }


        return response()->json($projects);
    }
}
