<?php

namespace App\Http\Controllers\Dashboard\Api\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\ProductivityResource;
use App\Http\Resources\TaskActivityResource;
use App\Http\Resources\TaskCommentResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskReportController extends Controller
{
    public function taskInStatus(Request $request)
    {
        $validator = validator($request->all(), [
            'status' => 'required|string|in:pending,processing,completed,cancled,overdue'
        ]);

        if (!$validator->fails()) {
            $date = now();
            $tasks = Task::where('status', '=', $request->input('status'))->get();
            $data = [
                'date' => $date->format('Y-m-d h:i a'),
                'tasks' => TaskResource::collection($tasks)
            ];
            return $data;
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function taskInPriority(Request $request)
    {
        $validator = validator($request->all(), [
            'priority' => 'required|string|in:low,medium,high'
        ]);

        if (!$validator->fails()) {
            $date = now();
            $tasks = Task::where('priority', '=', $request->input('priority'))->get();
            $data = [
                'date' => $date->format('Y-m-d h:i a'),
                'tasks' => TaskResource::collection($tasks)
            ];
            return $data;
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function taskActivities(Task $task)
    {
        $date = now();
        $data = [
            'date' => $date->format('Y-m-d h:i a'),
            'task' => new TaskResource($task),
            'activities' => TaskActivityResource::collection($task->activities)
        ];

        return $data;
    }

    public function task(Task $task)
    {
        $date = now();

        return [
            'date' => $date->format('Y-m-d h:i a'),
            'task' => new TaskResource($task),
            'members' => MemberResource::collection($task->members),
            'comments' => TaskCommentResource::collection($task->comments),
            'activities' => TaskActivityResource::collection($task->activities),
            'attachments' => AttachmentResource::collection($task->attachments),
            'productivities' => ProductivityResource::collection($task->productivities),
        ];
    }

    public function taskProductivities(Task $task)
    {
        $date = now();
        $data = [
            'date' => $date->format('Y-m-d h:i a'),
            'task' => new TaskResource($task),
            'productivities' => ProductivityResource::collection($task->productivities)
        ];

        return $data;
    }
}
