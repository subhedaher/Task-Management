<?php

namespace App\Http\Controllers\Dashboard\Api\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\ProductivityResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskActivityResource;
use App\Http\Resources\TaskCommentResource;
use App\Http\Resources\TaskResource;
use App\Models\Member;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectReportController extends Controller
{
    public function projects()
    {
        $date = now();
        $projects = Project::all();
        $data = [
            'date' => $date->format('Y-m-d h:i a'),
            'projects' => ProjectResource::collection($projects)
        ];
        return $data;
    }

    public function projectInStatus(Request $request)
    {
        $validator = validator($request->all(), [
            'status' => 'required|string|in:pending,processing,completed,cancled,overdue'
        ]);

        if (!$validator->fails()) {
            $date = now();
            $projects = Project::where('status', '=', $request->input('status'))->get();
            $data = [
                'date' => $date->format('Y-m-d h:i a'),
                'projects' => ProjectResource::collection($projects)
            ];
            return $data;
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function project(Project $project)
    {
        $project->load('tasks.members', 'tasks.comments', 'tasks.activities', 'tasks.attachments', 'tasks.productivities');

        $members = $project->tasks->flatMap->members;
        $comments = $project->tasks->flatMap->comments;
        $activities = $project->tasks->flatMap->activities;
        $attachments = $project->tasks->flatMap->attachments;
        $productivities = $project->tasks->flatMap->productivities;

        $date = now();

        return [
            'date' => $date->format('Y-m-d h:i a'),
            'projects' => new ProjectResource($project),
            'task' => TaskResource::collection($project->tasks),
            'members' => MemberResource::collection($members),
            'comments' => TaskCommentResource::collection($comments),
            'activities' => TaskActivityResource::collection($activities),
            'attachments' => AttachmentResource::collection($attachments),
            'productivities' => ProductivityResource::collection($productivities),
        ];
    }

    public function members(Project $project)
    {
        $tasksId = Task::where('project_id', $project->id)->pluck('id');

        $tasksMembersId = TaskMember::whereIn('task_id', $tasksId)->pluck('member_id');

        $members = Member::with(['productivities' => function ($q) use ($tasksId) {
            $q->whereIn('task_id', $tasksId);
        }])->whereIn('id', $tasksMembersId)->get();

        $productivities = $members->map(function ($member) {
            return ProductivityResource::collection($member->productivities);
        });

        $date = now();

        return [
            'date' => $date->format('Y-m-d h:i a'),
            'members' => MemberResource::collection($members),
            'productivities' => $productivities,
        ];
    }
}