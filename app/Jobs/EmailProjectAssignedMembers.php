<?php

namespace App\Jobs;

use App\Mail\ProjectAssignedMembers;
use App\Models\Designation;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailProjectAssignedMembers implements ShouldQueue
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
        $designations = Designation::where('department_id', '=', $this->project->department_id)->get(['id']);

        $members = Member::whereIn('designation_id', $designations)->where('id', '!=', $this->project->member_id)->get();

        foreach ($members as $member) {
            Mail::to($member)->send(new ProjectAssignedMembers($member, $this->project, $this->admin));
        }
    }
}
