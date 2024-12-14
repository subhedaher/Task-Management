<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function calendar(Request $request)
    {
        if ($request->user('admin')) {
            $tasks = Task::select(['name', 'start_date', 'end_date'])->get();
            $projects = Project::select(['name', 'start_date', 'end_date'])->get();
        } else {
            if (user()->hasRole('Project Manager')) {
                $projects = user()->projects()->select(['id', 'name', 'start_date', 'end_date'])
                    ->get();
                $tasks = Task::whereIn('project_id', $projects->pluck('id'))
                    ->select(['name', 'start_date', 'end_date'])->get();
            } else if (user()->hasRole('Member')) {
                $taskIds = user()->tasks()
                    ->pluck('task_id');

                $projectIds = Task::whereIn('id', $taskIds)
                    ->pluck('project_id')
                    ->unique();

                $projects = Project::whereIn('id', $projectIds)->select(['name', 'start_date', 'end_date'])->get();
                $tasks = user()->tasks()
                    ->select(['name', 'start_date', 'end_date'])
                    ->get();
            }
        }
        return view('dashboard.calendar', ['tasks' => $tasks, 'projects' => $projects]);
    }
}