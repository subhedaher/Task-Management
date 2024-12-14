<?php

namespace App\Observers;

use App\Models\TaskActivity;
use App\Models\TaskComment;

class TaskCommentObserver
{
    /**
     * Handle the TaskComment "created" event.
     */
    public function created(TaskComment $taskComment): void
    {
        TaskActivity::create([
            'task_id' => $taskComment->task_id,
            'member_id' => $taskComment->member_id,
            'type' => 'commented',
            'description' => "A comment has been added to task {$taskComment->task->name} by {$taskComment->member->name} in project {$taskComment->task->project->name}."
        ]);
    }
}
