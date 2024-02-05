<?php

namespace App\Policies;

use App\Helpers\PermissionHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can(PermissionHelper::ROLE_VIEW_ANY)
            ? Response::allow()
            : Response::deny("You are not authorized to view index master role");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role)
    {
        return $user->can(PermissionHelper::ROLE_VIEW)
            ? Response::allow()
            : Response::deny("You are not authorized to view detail master role");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can(PermissionHelper::ROLE_CREATE)
            ? Response::allow()
            : Response::deny("You are not authorized to create master role");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role)
    {
        return $user->can(PermissionHelper::ROLE_UPDATE)
            ? Response::allow()
            : Response::deny("You are not authorized to update master role");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role)
    {
        return $user->can(PermissionHelper::ROLE_DELETE)
            ? Response::allow()
            : Response::deny("You are not authorized to delete master role");
    }

    public function syncPermission(User $user)
    {
        return $user->can(PermissionHelper::ROLE_SYNC_PERMISSION)
            ? Response::allow()
            : Response::deny("You are not authorized to syncronize permission master role");
    }
}
