<?php

namespace App\Http\Controllers;

use App\Exceptions\RoleCreateFailedException;
use App\Exceptions\RoleNotFoundException;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleSyncPermissionRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleController extends Controller
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

            $this->authorize("viewAny", Role::class);

            $roles = Role::when($request->filled("search"), function ($query) use ($request) {
                $query->where("name", "like", "%$request->search%")
                    ->orWhere("description", "like", "%$request->search%");
            })
                ->orderBy("name")
                ->paginate($request->per_page);

            return new RoleCollection($roles);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleCreateRequest $request)
    {
        DB::beginTransaction();
        try {

            $this->authorize("create", Role::class);

            $user = Auth::user();

            $name = Str::replace(' ', '_', Str::upper($request->name));

            $role = Role::create([
                "name" => $name,
                "description" => $request->description,
                "created_by" => $user->id,
                "updated_by" => $user->id,
            ]);

            DB::commit();

            if (!$role) {
                throw new RoleCreateFailedException();
            }

            return new RoleResource($role, "Create role success");
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

            $role = Role::with("permissions")->where("id", $request->role)->first();

            if (!$role) {
                throw new RoleNotFoundException();
            }

            $this->authorize("view", $role);

            return new RoleResource($role);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            $role = Role::with("permissions")->where("id", $request->role)->first();

            if (!$role) {
                throw new RoleNotFoundException();
            }

            $this->authorize("update", $role);

            $role->description = $request->description;
            $role->updated_by = $user->id;
            $role->save();

            return new RoleResource($role, "Update role success");
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
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::where("id", $request->role)->first();

            if (!$role) {
                throw new RoleNotFoundException();
            }

            $this->authorize("delete", $role);

            $role->delete();

            DB::commit();

            return new BaseResource([], "Delete role success");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::rollBack();
        }
    }

    public function syncPermissions(RoleSyncPermissionRequest $request)
    {
        DB::beginTransaction();
        try {

            $this->authorize("syncPermission", Role::class);

            $role = Role::findByName($request->role_name);

            $role->syncPermissions($request->permissions);

            $role->load('permissions');

            DB::commit();

            return new RoleResource($role, "Syncronize permissions success");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::rollBack();
        }
    }
}
