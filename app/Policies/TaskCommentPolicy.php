<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TaskComment;
use Illuminate\Auth\Access\Response;

class TaskCommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Comments');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, TaskComment $comment): bool
    {
        return $user->hasPermissionTo('Read-Comments');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Comment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, TaskComment $comment): bool
    {
        return $user->hasPermissionTo('Update-Comment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, TaskComment $comment): bool
    {
        return $user->hasPermissionTo('Delete-Comment');
    }
}
