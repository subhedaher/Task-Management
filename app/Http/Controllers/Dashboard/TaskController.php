<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\TaskCreatedEvent;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectDepartment;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class TaskController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user('admin')) {
            $tasksAll = Task::all();
            $tasks = Task::orderBy('created_at', 'desc')->get();
        } else if ($request->user('member')) {
            if (user()->hasRole('Project Manager')) {
                $projects = user()->projects;
                $tasksAll = Task::whereIn('project_id', $projects->pluck('id'))->get();
                $tasks = Task::whereIn('project_id', $projects->pluck('id'))
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            } else if (user()->hasRole('Member')) {
                $tasksAll = user()->tasks;
                $tasks = user()->tasks()
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        }

        $statuses = ['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancled' => 'Cancled', 'overdue' => 'Overdue'];
        return view('dashboard.tasks.index2', ['tasksAll' => $tasksAll, 'tasks' => $tasks, 'statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user('admin')) {
            $departments = Department::where('status', '=', true)->get();
        } elseif ($request->user('member')) {
            $designation = Designation::where('id', '=', user()->designation_id)->first();
            $departments = Department::where('id', '=', $designation->department_id)->where('status', '=', true)->get();
        }
        $statuses = ['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancled' => 'Cancled', 'overdue' => 'Overdue'];
        $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
        return view('dashboard.tasks.create', ['departments' => $departments, 'statuses' => $statuses, 'priorities' => $priorities]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $storeTaskRequest)
    {
        $storeTaskRequest->validated();

        $task = Task::create([
            'project_id' => $storeTaskRequest->input('project_id'),
            'member_id' => $storeTaskRequest->input('member_id'),
            'name' => $storeTaskRequest->input('name'),
            'start_date' => $storeTaskRequest->input('start_date'),
            'end_date' => $storeTaskRequest->input('end_date'),
            'priority' => $storeTaskRequest->input('priority'),
            'status' => $storeTaskRequest->input('status'),
            'description' => $storeTaskRequest->input('description'),
        ]);

        if ($task) {
            foreach ($storeTaskRequest['members'] as $member) {
                TaskMember::create([
                    'member_id' => $member,
                    'task_id' => $task->id
                ]);
            }

            event(new TaskCreatedEvent($task));

            if ($storeTaskRequest->hasFile('attachments')) {
                foreach ($storeTaskRequest->file('attachments') as $image) {
                    $file_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileType = $image->getClientOriginalExtension();
                    $uploadedByAdmin = $storeTaskRequest->user('admin')->id ?? null;
                    $uploadedByMember = $storeTaskRequest->user('member')->id ?? null;
                    $attachment = new Attachment([
                        'file_name' => $file_name,
                        'file_type' => $fileType,
                        'uploaded_by_member' => $uploadedByMember,
                        'uploaded_by_admin' => $uploadedByAdmin,
                    ]);

                    $attachment->file_path = $image->store('attachments/tasks', 'public');
                    $task->attachments()->save($attachment);
                }
            }
        }

        return redirect()->back()->with('message', 'Task Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $user = auth(session('guard'))->user();
        $notification = $user->unreadNotifications()->where('data->id', $task->id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return view('dashboard.tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $statuses = ['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancled' => 'Cancled', 'overdue' => 'Overdue'];
        $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
        $departments = Department::where('status', '=', true)->get();
        $projectsId = ProjectDepartment::whereIn('department_id', $task->project->departments->pluck('id'))->pluck('project_id');
        $projects = Project::whereIn('id', $projectsId)->get(['id', 'name']);
        $designationsId = Designation::whereIn('department_id', $task->project->departments->pluck('id'))->pluck('id');
        $members = Member::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })->whereIn('designation_id', $designationsId)->get();
        return view('dashboard.tasks.edit', ['projects' => $projects, 'members' => $members, 'task' => $task, 'statuses' => $statuses, 'priorities' => $priorities, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $updateTaskRequest, Task $task)
    {
        $updateTaskRequest->validated();

        $updated = $task->update([
            'project_id' => $updateTaskRequest->input('project_id'),
            'member_id' => $updateTaskRequest->input('member_id'),
            'name' => $updateTaskRequest->input('name'),
            'start_date' => $updateTaskRequest->input('start_date'),
            'end_date' => $updateTaskRequest->input('end_date'),
            'priority' => $updateTaskRequest->input('priority'),
            'status' => $updateTaskRequest->input('status'),
            'description' => $updateTaskRequest->input('description'),
        ]);

        if ($updated) {
            $existingMembers = TaskMember::where('task_id', '=', $task->id)->pluck('member_id')->toArray();
            $newMembers = $updateTaskRequest['members'];
            $membersToAdd = array_diff($newMembers, $existingMembers);
            $membersToRemove = array_diff($existingMembers, $newMembers);
            TaskMember::where('task_id', '=', $task->id)
                ->whereIn('member_id', $membersToRemove)
                ->delete();
            foreach ($membersToAdd as $member) {
                TaskMember::create([
                    'member_id' => $member,
                    'task_id' => $task->id
                ]);
            }

            if ($updateTaskRequest->hasFile('attachments')) {
                foreach ($task->attachments as $attachment) {
                    Storage::delete($attachment->file_path);
                    $attachment->delete();
                }

                foreach ($updateTaskRequest->file('attachments') as $image) {
                    $file_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileType = $image->getClientOriginalExtension();
                    $uploadedByAdmin = $updateTaskRequest->user('admin')->id ?? null;
                    $uploadedByMember = $updateTaskRequest->user('member')->id ?? null;

                    $attachment = new Attachment([
                        'file_name' => $file_name,
                        'file_type' => $fileType,
                        'uploaded_by_member' => $uploadedByMember,
                        'uploaded_by_admin' => $uploadedByAdmin,
                    ]);

                    $attachment->file_path = $image->store('attachments/projects', 'public');

                    $task->attachments()->save($attachment);
                }
            }
        }

        return redirect()->route('dashboard.tasks.index')->with('message', 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('message', 'Task Deleted Successfully');
    }

    public function projectFilterCreate($id)
    {
        $department = Department::find($id);
        return response()->json($department->projects);
    }

    public function membersFilterCreate($id)
    {
        $designationsId = Designation::where('department_id', '=', $id)->pluck('id');

        $members = Member::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })->whereIn('designation_id', $designationsId)->get();

        return response()->json($members);
    }

    public function projectFilterEdit($taskId, $id)
    {
        $projects = Project::where('department_id', $id)->get(['id', 'name']);
        return response()->json($projects);
    }

    public function membersFilterEdit($taskId, $id)
    {
        $designationsId = Designation::where('department_id', $id)->pluck('id');

        $members = Member::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })->whereIn('designation_id', $designationsId)->get();

        return response()->json($members);
    }
}
