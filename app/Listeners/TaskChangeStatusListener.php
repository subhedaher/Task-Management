<?php

namespace App\Listeners;

use App\Events\TaskChangeStatusEvent;
use App\Models\Member;
use App\Models\TaskMember;
use App\Notifications\TaskChangeStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskChangeStatusListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskChangeStatusEvent $event): void
    {
        $id = $event->task->id;
        $taskMembers = TaskMember::where('task_id', '=', $id)->pluck('member_id');
        $members = Member::whereIn('id', $taskMembers)->get();
        foreach ($members as $member) {
            $member->notify(new TaskChangeStatusNotification($event->task));
        }
    }
}
