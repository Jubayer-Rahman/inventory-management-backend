<?php

namespace Database\Seeders;

use Database\Seeders\CustomSeeders\RoleSeeder;
use Database\Seeders\CustomSeeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
