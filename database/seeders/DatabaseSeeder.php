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
        $user = \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'test@example.com',
        ]);

        \App\Models\Role::create([
            "name" => "ADMINISTRATOR",
            "description" => "Role with full access ability",
            "guard_name" => "api",
            "created_at" => Carbon::now(),
            "updated_by" => 1,
        ]);


        $user->syncRoles(["ADMINISTRATOR"]);
        // \App\Models\User::factory(99)->create();
    }
}
