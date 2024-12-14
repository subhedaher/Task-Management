<?php

namespace App\Observers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentObserver
{
    /**
     * Handle the Attachment "created" event.
     */
    public function created(Attachment $attachment): void
    {
        //
    }

    /**
     * Handle the Attachment "updated" event.
     */
    public function updated(Attachment $attachment): void
    {
        //
    }

    /**
     * Handle the Attachment "deleted" event.
     */
    public function deleted(Attachment $attachment): void
    {
        //
    }

    /**
     * Handle the Attachment "deleteing" event.
     */
    public function deleting(Attachment $attachment): void
    {
        if ($attachment->file_path) {
            Storage::delete($attachment->file_path);
        }
    }
}
