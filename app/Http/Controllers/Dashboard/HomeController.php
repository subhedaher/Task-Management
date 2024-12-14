<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Member;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $members = Member::all();
        if (user()->hasRole('Super Admin')) {
            $projects = Project::withCount(['tasks as completed_tasks_count' => function ($q) {
                $q->where('status', 'completed');
            }])->orderBy('created_at', 'desc')->get();
            $tasks = Task::orderBy('created_at', 'desc')->get();
        } else {
            if (user()->hasRole('Project Manager')) {
                $projects = user()->projects()->withCount(['tasks as completed_tasks_count' => function ($q) {
                    $q->where('status', 'completed');
                }])->orderBy('created_at', 'desc')->get();
                $tasks = Task::whereIn('project_id', $projects->pluck('id'))->orderBy('created_at', 'desc')->get();
            } elseif (user()->hasRole('Member')) {
                $taskIds = user()->tasks()
                    ->pluck('task_id');
                $projectIds = Task::whereIn('id', $taskIds)
                    ->pluck('project_id')
                    ->unique();
                $projects = Project::whereIn('id', $projectIds)->withCount(['tasks as completed_tasks_count' => function ($q) {
                    $q->where('status', 'completed');
                }])->orderBy('created_at', 'desc')->get();
                $tasks = user()->tasks()->orderBy('created_at', 'desc')->get();
            }
        }
        return view('dashboard.index', [
            'departments' => $departments,
            'members' => $members,
            'projects' => $projects,
            'tasks' => $tasks,
        ]);
    }
}
