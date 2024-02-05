<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        \App\Models\Role::create([
            "name" => "ADMINISTRATOR",
            "description" => "Role with full access ability",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        $roleUser = \App\Models\Role::create([
            "name" => "USER",
            "description" => "Role with minimum access ability",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "USER_CREATE",
            "description" => "Ability to input new user",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "USER_UPDATE",
            "description" => "Ability to update existing user",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "USER_VIEW_ANY",
            "description" => "Ability to view list user",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);


        \App\Models\Permission::create([
            "name" => "USER_VIEW",
            "description" => "Ability to view detail user",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);


        \App\Models\Permission::create([
            "name" => "USER_SYNC_ROLE",
            "description" => "Ability to syncronize role of user",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "USER_SYNC_PERMISSION",
            "description" => "Ability to syncronize permission of user",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "ROLE_VIEW_ANY",
            "description" => "Ability to view list role",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "ROLE_VIEW",
            "description" => "Ability to view detail role",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "ROLE_CREATE",
            "description" => "Ability to create new role",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "ROLE_UPDATE",
            "description" => "Ability to update existing role",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "ROLE_DELETE",
            "description" => "Ability to delete role",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "ROLE_SYNC_PERMISSION",
            "description" => "Ability to syncronize permission of role",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "PERMISSION_VIEW_ANY",
            "description" => "Ability to view list permission",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "PERMISSION_VIEW",
            "description" => "Ability to view detail permission",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "PERMISSION_CREATE",
            "description" => "Ability to create new permission",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        \App\Models\Permission::create([
            "name" => "PERMISSION_UPDATE",
            "description" => "Ability to update existing permission",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);


        \App\Models\Permission::create([
            "name" => "PERMISSION_DELETE",
            "description" => "Ability to delete permission",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);

        $admin->syncRoles(["ADMINISTRATOR"]);
        $user->syncRoles(["USER"]);

        $roleUser->syncPermissions([
            "USER_CREATE",
            "USER_UPDATE",
            "USER_VIEW_ANY",
            "USER_VIEW",
            "USER_SYNC_ROLE",
            "USER_SYNC_PERMISSION",
        ]);
        // \App\Models\User::factory(99)->create();
    }
}
