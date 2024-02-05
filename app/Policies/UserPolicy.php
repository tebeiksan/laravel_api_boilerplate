<?php

namespace App\Policies;

use App\Helpers\PermissionHelper;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can(PermissionHelper::USER_VIEW_ANY)
            ? Response::allow()
            : Response::deny("You are not authorized to view list user");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model)
    {
        return $user->can(PermissionHelper::USER_VIEW)
            ? Response::allow()
            : Response::deny("You are not authorized to view detail user");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can(PermissionHelper::USER_CREATE)
            ? Response::allow()
            : Response::deny("You are not authorized to create user");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model)
    {
        return $user->can(PermissionHelper::USER_UPDATE)
            ? Response::allow()
            : Response::deny("You are not authorized to update user");
    }

    public function syncRole(User $user)
    {
        return $user->can(PermissionHelper::USER_SYNC_ROLE)
            ? Response::allow()
            : Response::deny("You are not authorized to syncronize role user");
    }

    public function syncPermission(User $user)
    {
        return $user->can(PermissionHelper::USER_SYNC_PERMISSION)
            ? Response::allow()
            : Response::deny("You are not authorized to syncronize permission user");
    }
}
