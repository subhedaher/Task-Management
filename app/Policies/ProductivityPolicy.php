<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Productivity;
use Illuminate\Auth\Access\Response;

class ProductivityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Productivities');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Productivity $productivity): bool
    {
        return $user->hasPermissionTo('Read-Productivities');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Productivity');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Productivity $productivity): bool
    {
        return $user->hasPermissionTo('Update-Productivity');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Productivity $productivity): bool
    {
        return $user->hasPermissionTo('Delete-Productivity');
    }
}
