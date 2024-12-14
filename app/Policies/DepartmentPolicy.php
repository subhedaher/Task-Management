<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Departments');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Department $department): bool
    {
        return $user->hasPermissionTo('Read-Departments');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Department');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Department $department): bool
    {
        return $user->hasPermissionTo('Update-Department');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Department $department): bool
    {
        return $user->hasPermissionTo('Delete-Department');
    }
}
