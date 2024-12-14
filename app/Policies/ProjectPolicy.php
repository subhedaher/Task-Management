<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Project;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Projects');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Project $project): bool
    {
        if (class_basename($user) === 'Admin') {
            return $user->hasPermissionTo('Read-Projects');
        }

        if ($project->member_id === $user->id) {
            return $user->hasPermissionTo('Read-Projects');
        }

        $projectIds = $user->tasks->pluck('project_id')->unique();

        if ($projectIds->contains($project->id)) {
            return $user->hasPermissionTo('Read-Projects');
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Project');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Project $project): bool
    {
        return $user->hasPermissionTo('Update-Project');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Project $project): bool
    {
        return $user->hasPermissionTo('Delete-Project');
    }
}
