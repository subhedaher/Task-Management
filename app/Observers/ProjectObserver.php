<?php

namespace App\Observers;

use App\Jobs\EmailProjectAssigned;
use App\Jobs\EmailProjectAssignedMembers;
use App\Models\Admin;
use App\Models\Attachment;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $admin = Admin::find($project->admin_id);
        EmailProjectAssigned::dispatch($admin, $project);
        EmailProjectAssignedMembers::dispatch($admin, $project);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    public function deleting(Project $project)
    {
        foreach ($project->attachments as $attachment) {
            Storage::delete($attachment->file_path);
        }

        $project->attachments()->delete();
    }
}
