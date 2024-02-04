<?php

namespace App\Http\Controllers;

use App\Exceptions\PermissionCreateFailedException;
use App\Exceptions\PermissionNotFoundException;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionController extends Controller
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

            $permissions = Permission::when($request->filled("search"), function ($query) use ($request) {
                $query->where("name", "like", "%$request->search%")
                    ->orWhere("description", "like", "%$request->search%");
            })
                ->orderBy("name")
                ->paginate($request->per_page);

            return new PermissionCollection($permissions);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionCreateRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = Auth::user();

            $name = Str::replace(' ', '_', Str::upper($request->name));

            $permission = Permission::create([
                "name" => $name,
                "description" => $request->description,
                "created_by" => $user->id,
                "updated_by" => $user->id,
            ]);

            DB::commit();

            if (!$permission) {
                throw new PermissionCreateFailedException();
            }

            return new PermissionResource($permission, "Create permission success");
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

            $permission = Permission::where("id", $request->permission)->first();

            if (!$permission) {
                throw new PermissionNotFoundException();
            }

            return new PermissionResource($permission);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            $permission = Permission::where("id", $request->permission)->first();

            if (!$permission) {
                throw new PermissionNotFoundException();
            }

            $permission->description = $request->description;
            $permission->updated_by = $user->id;
            $permission->save();

            return new PermissionResource($permission, "Update permission success");
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
            $permission = Permission::where("id", $request->permission)->first();

            if (!$permission) {
                throw new PermissionNotFoundException();
            }

            $permission->delete();

            DB::commit();

            return new BaseResource([], "Delete permission success");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        } finally {
            DB::rollBack();
        }
    }
}
