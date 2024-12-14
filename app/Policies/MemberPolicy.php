<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Member;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('Read-Members');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Member $member): bool
    {
        return $admin->hasPermissionTo('Read-Members');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('Create-Member');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Member $member): bool
    {
        return $admin->hasPermissionTo('Update-Member');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Member $member): bool
    {
        return $admin->hasPermissionTo('Delete-Member');
    }
}
