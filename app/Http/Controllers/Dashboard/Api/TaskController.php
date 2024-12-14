<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Events\TaskChangeStatusEvent;
use App\Events\TaskCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Member;
use App\Models\Task;
use App\Models\TaskActivity;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->paginate(10);
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'project_id' => 'required|numeric|exists:projects,id',
            'name' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today',
            'description' => 'required|string',
            'members' => 'required|array',
            'members.*' => 'required|numeric|exists:members,id',
        ], [
            'project_id.required' => 'The project field is required.',
        ]);

        if (!$validator->fails()) {
            $task = Task::create($request->all());
            if ($task) {
                foreach ($request['members'] as $member) {
                    TaskMember::create([
                        'member_id' => $member,
                        'task_id' => $task->id
                    ]);
                }
            }

            event(new TaskCreatedEvent($task));

            return response()->json([
                'status' => $task ? true : false,
                'message' => $task ? 'Task Created Successfully' : 'Task Created Failed!',
            ], $task ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json([
            'status' => true,
            'data' => new TaskResource($task),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validator = validator($request->all(), [
            'project_id' => 'required|numeric|exists:projects,id',
            'name' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today',
            'description' => 'required|string',
            'members' => 'required|array',
            'members.*' => 'required|numeric|exists:members,id',
        ], [
            'project_id.required' => 'The project field is required.',
        ]);

        if (!$validator->fails()) {
            $updated = $task->update($request->all());
            if ($updated) {
                $existingMembers = TaskMember::where('task_id', '=', $task->id)->pluck('member_id')->toArray();
                $newMembers = $request['members'];
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
            }

            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Task Updated Successfully' : 'Task Updated Failed!',
            ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $deleted = $task->delete();
        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Task Deleted Successfully' : 'Task Deleted Failed!',
        ], Response::HTTP_OK);
    }

    public function change_status(Request $request, Task $task)
    {
        $this->authorize('Change-Status-Task', $request->user());
        $validator = validator($request->all(), [
            'status' => 'required|string|in:pending,processing,completed,cancled,overdue'
        ]);

        if (!$validator->fails()) {
            $previousStatus = $task->status;
            $task->status = $request->input('status');
            $updated = $task->save();
            if ($updated) {
                TaskActivity::create([
                    'task_id' => $task->id,
                    'member_id' => $request->user()->id,
                    'type' => 'status changed',
                    'description' => "Task {$task->name} status has been changed from {$previousStatus} to {$task->status} by {$request->user()->name}."
                ]);

                event(new TaskChangeStatusEvent($task));
            }
            return response()->json([
                'status' => $updated ? true : false,
                'message' => $updated ? 'Status Updated Successfully' : 'Status Updated Failed!',
            ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_OK);
        }
    }
}
