<?php

namespace App\Listeners;

use App\Events\TaskCreatedEvent;
use App\Models\Member;
use App\Models\TaskMember;
use App\Notifications\TaskAssignedMemberNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskCreatedListener
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
    public function handle(TaskCreatedEvent $event): void
    {
        $members =  $event->task->members;
        foreach ($members as $member) {
            $member->notify(new TaskAssignedMemberNotification($event->task));
        }
    }
}
