<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Attachment;
use Illuminate\Auth\Access\Response;

class AttachmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Attachments');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Attachment $attachment): bool
    {
        return $user->hasPermissionTo('Read-Attachments');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Attachment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Attachment $attachment): bool
    {
        return $user->hasPermissionTo('Delete-Attachment');
    }
}