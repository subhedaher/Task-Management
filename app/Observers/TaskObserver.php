<?php

namespace App\Observers;

use App\Jobs\EmailTaskAssignedMembers;
use App\Models\Member;
use App\Models\Task;
use App\Models\TaskActivity;
use App\Models\TaskMember;
use App\Notifications\TaskAssignedMemberNotification;
use Illuminate\Support\Facades\Storage;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        EmailTaskAssignedMembers::dispatch($task);
        TaskActivity::create([
            'task_id' => $task->id,
            'member_id' => guard() === 'member' ? user()->id : null,
            'admin_id' => guard() === 'admin' ? user()->id : null,
            'type' => 'created',
            'description' => "Task {$task->name} has been created by" . user()->name . "in project {$task->project->name}."
        ]);
    }


    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        TaskActivity::create([
            'task_id' => $task->id,
            'member_id' => guard() === 'member' ? user()->id : null,
            'admin_id' => guard() === 'admin' ? user()->id : null,
            'type' => 'updated',
            'description' => "Task {$task->name} has been updated by" . user()->name . "in project {$task->project->name}."
        ]);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleting" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleting(Task $task)
    {
        foreach ($task->attachments as $attachment) {
            Storage::delete($attachment->file_path);
        }
        $task->attachments()->delete();
    }
}
