<?php

namespace App\Jobs;

use App\Models\Member;
use App\Notifications\ProjectReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProjectReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project;

    /**
     * Create a new job instance.
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $projectManager = Member::where('id', '=', $this->project->member_id)->first();
        $projectManager->notify(new ProjectReminderNotification($this->project));
    }
}