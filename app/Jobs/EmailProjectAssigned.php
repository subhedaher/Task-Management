<?php

namespace App\Jobs;

use App\Mail\ProjectAssigned;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailProjectAssigned implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $admin, $project;

    /**
     * Create a new job instance.
     */
    public function __construct($admin, $project)
    {
        $this->admin = $admin;
        $this->project = $project;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $manager = Member::find($this->project->member_id);

        Mail::to($manager)->send(new ProjectAssigned($manager, $this->project, $this->admin));
    }
}
