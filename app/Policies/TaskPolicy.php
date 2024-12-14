<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Tasks');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Task $task): bool
    {
        if (class_basename($user) === 'Admin') {
            return $user->hasPermissionTo('Read-Tasks');
        }

        if ($task->project->member_id === user()->id) {
            return $user->hasPermissionTo('Read-Tasks');
        }
        $isTaskMember = TaskMember::where('task_id', $task->id)
            ->where('member_id', $user->id)
            ->exists();

        if ($isTaskMember) {
            return $user->hasPermissionTo('Read-Tasks');
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Task');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Task $task): bool
    {
        return $user->hasPermissionTo('Update-Task');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Task $task): bool
    {
        return $user->hasPermissionTo('Delete-Task');
    }
}
