<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskActivityResource;
use App\Models\Admin;
use App\Models\Task;
use App\Models\TaskActivity;
use Illuminate\Http\Request;

class TaskActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('Read-Activities', $request->user());
        $activities = TaskActivity::orderBy('created_at', 'desc')->get();
        return TaskActivityResource::collection($activities);
    }

    /**
     * Display a item of the resource.
     */
    public function show(Request $request, Task $task)
    {
        $this->authorize('Read-Activities', $request->user());
        $activities = TaskActivity::where('task_id', $task->id)->orderBy('created_at', 'desc')->get();
        return TaskActivityResource::collection($activities);
    }
}
