<?php

namespace App\Http\Controllers;

use App\Exceptions\UserCreateFailedException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserSyncPermissionRequest;
use App\Http\Requests\UserSyncRoleRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Google\Service\Analytics\UserRef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware("searching")->only("index");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = User::when($request->filled("search"), function ($query) use ($request) {
                $query->where("name", "like", "%$request->search%")
                    ->orWhere("email", "like", "%$request->search%");
            })
                ->orderBy("created_at", "desc")
                ->paginate($request->per_page);

            return new UserCollection($users);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        DB::beginTransaction();
        try {

            $authUser = Auth::user();

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "created_by" => $authUser->id,
                "updated_by" => $authUser->id,
            ]);

            if (!$user) {
                throw new UserCreateFailedException();
            }

            DB::commit();

            $user->refresh();

            return new UserResource($user, "Create user success");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {

            $user = User::with([
                'masterRole',
                'masterPermission',
            ])->where("id", $request->user)->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            return new UserResource($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = User::with([
                'masterRole',
                'masterPermission',
            ])->where("id", $request->user)->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            $authUser = Auth::user();

            $user->email = $request->email;
            $user->name = $request->name;
            $user->is_active = $request->is_active;
            $user->updated_by = $authUser->id;
            $user->save();

            DB::commit();

            return new UserResource($user, "Update user success");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function syncRoles(UserSyncRoleRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = User::with([
                'masterRole',
                'masterPermission',
            ])->where("id", $request->user_id)->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            $user->syncRoles($request->roles);

            DB::commit();

            $user->refresh();

            return new UserResource($user, "Syncronize user roles success");
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
        DB::rollBack();
    }

    /**
     * Add direct permission to users
     * So if role has permission and assigned to user and user has direct permission also,
     * all permissions from role and direct permissions will combined
     */
    public function syncPermissions(UserSyncPermissionRequest $request)
    {
        DB::beginTransaction();
        try {

            $this->authorize("syncPermission", User::class);

            $user = User::with([
                'masterRole',
                'masterPermission',
            ])->where("id", $request->user_id)->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            $user->syncPermissions($request->permissions);

            DB::commit();

            $user->refresh();

            return new UserResource($user, "Syncronize user permissions success");
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
        DB::rollBack();
    }
}
