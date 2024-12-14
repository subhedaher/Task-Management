<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): bool
    {
        return $user->hasPermissionTo('Read-Admins');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, Admin $admin): bool
    {
        return $user->hasPermissionTo('Read-Admins');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): bool
    {
        return $user->hasPermissionTo('Create-Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, Admin $admin): bool
    {
        return $user->hasPermissionTo('Update-Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, Admin $admin): bool
    {
        return $user->hasPermissionTo('Delete-Admin');
    }
}
