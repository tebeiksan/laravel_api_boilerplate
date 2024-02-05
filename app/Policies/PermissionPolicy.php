<?php

namespace App\Policies;

use App\Helpers\PermissionHelper;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can(PermissionHelper::PERMISSION_VIEW_ANY)
            ? Response::allow()
            : Response::deny("You are not authorized to view index master permission");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission)
    {
        return $user->can(PermissionHelper::PERMISSION_VIEW)
            ? Response::allow()
            : Response::deny("You are not authorized to view detail master permission");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can(PermissionHelper::PERMISSION_CREATE)
            ? Response::allow()
            : Response::deny("You are not authorized to create master permission");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission)
    {
        return $user->can(PermissionHelper::PERMISSION_UPDATE)
            ? Response::allow()
            : Response::deny("You are not authorized to update master permission");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission)
    {
        return $user->can(PermissionHelper::PERMISSION_DELETE)
            ? Response::allow()
            : Response::deny("You are not authorized to delete master permission");
    }
}
