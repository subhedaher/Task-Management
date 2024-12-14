<?php

namespace App\Http\Controllers\Dashboard\Api\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Http\Resources\ProductivityResource;
use App\Models\Member;
use App\Models\Productivity;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberReportController extends Controller
{
    public function project(Project $project, Member $member)
    {
        $tasksId = Task::where('project_id', $project->id)->pluck('id');

        $tasksMembersId = TaskMember::whereIn('task_id', $tasksId)->where('member_id', $member->id)->pluck('member_id');

        $members = Member::with(['productivities' => function ($q) use ($tasksId) {
            $q->whereIn('task_id', $tasksId);
        }])->whereIn('id', $tasksMembersId)->get();


        $productivities = $members->map(function ($member) {
            return ProductivityResource::collection($member->productivities);
        });

        $date = now();

        return [
            'date' => $date->format('Y-m-d h:i a'),
            'members' => new MemberResource($member),
            'productivities' => $productivities,
        ];
    }

    public function task(Task $task, Member $member)
    {
        $tasksMembersId = TaskMember::where('task_id', $task->id)->pluck('member_id');

        $memberData = Member::with(['productivities' => function ($q) use ($task) {
            $q->where('task_id', $task->id);
        }])->where('id', $member->id)
            ->whereIn('id', $tasksMembersId)
            ->first();

        $productivities = $memberData ? ProductivityResource::collection($memberData->productivities) : [];

        $date = now()->format('Y-m-d h:i a');

        return [
            'date' => $date,
            'members' => $memberData ? new MemberResource($memberData) : null,
            'productivities' => $productivities,
        ];
    }

    public function taskCompletionReport(Request $request, Member $member)
    {
        $validator = validator($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        if (!$validator->fails()) {
            $fromDate = $request->input('from');
            $toDate = $request->input('to');

            $productivities = Productivity::where('member_id', $member->id)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->get();

            $tasksId = $productivities->pluck('task_id');

            $tasks = Task::whereIn('id', $tasksId)->get();



            $totalTasks = $tasks->count();

            $completedTasks = $tasks->where('status', '=', 'completed')->count();


            $completionPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            return [
                'member' => new MemberResource($member),
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'completion_percentage' => round($completionPercentage, 2),
                'productivities' => ProductivityResource::collection($productivities),
            ];
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function taskCompletionReportAll(Request $request)
    {
        $validator = validator($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        if (!$validator->fails()) {
            $fromDate = $request->input('from');
            $toDate = $request->input('to');

            $report = [];

            $members = Member::all();

            foreach ($members as $member) {
                $productivities = Productivity::where('member_id', $member->id)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->get();

                $tasksId = $productivities->pluck('task_id');

                $tasks = Task::whereIn('id', $tasksId)->get();

                $totalTasks = $tasks->count();

                $completedTasks = $tasks->where('status', '=', 'completed')->count();


                $completionPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                $report[] = [
                    'member' => new MemberResource($member),
                    'total_tasks' => $totalTasks,
                    'completed_tasks' => $completedTasks,
                    'completion_percentage' => round($completionPercentage, 2),
                    'productivities' => ProductivityResource::collection($productivities),
                ];
            }

            return $report;
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
