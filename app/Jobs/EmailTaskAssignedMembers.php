<?php

namespace App\Jobs;

use App\Mail\TaskAssignedMembers;
use App\Models\Member;
use App\Models\TaskMember;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailTaskAssignedMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;
    /**
     * Create a new job instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $members = Member::whereHas('tasks', function ($query) {
            $query->where('task_id', '=', $this->task->id);
        })->get();

        foreach ($members as $member) {
            Mail::to($member)->send(new TaskAssignedMembers($member, $this->task));
        }
    }
}
