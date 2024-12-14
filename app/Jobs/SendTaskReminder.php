<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\Task;
use App\Models\TaskMember;
use App\Notifications\TaskReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTaskReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $taskMembers = TaskMember::where('task_id', $this->task->id)->pluck('member_id');
        $members = Member::whereIn('id', $taskMembers)->get();

        foreach ($members as $member) {
            $member->notify(new TaskReminderNotification($this->task));
        }
    }
}