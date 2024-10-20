<?php

namespace Database\Seeders\CustomSeeders;

use App\Enums\RoleEnum;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RoleEnum::all();
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
