<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Designation;
use Illuminate\Auth\Access\Response;

class DesignationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Designations');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Designation $designation): bool
    {
        return $user->hasPermissionTo('Read-Designations');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Designation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Designation $designation): bool
    {
        return $user->hasPermissionTo('Update-Designation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Designation $designation): bool
    {
        return $user->hasPermissionTo('Delete-Designation');
    }
}
