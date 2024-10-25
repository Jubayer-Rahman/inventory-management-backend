<?php

namespace Database\Seeders\CustomSeeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUserWithRole(RoleEnum::OWNER->value, 1);
        $this->createUserWithRole(RoleEnum::ADMIN->value, 1);
        $this->createUserWithRole(RoleEnum::CENTRAL_INVENTORY_MANAGER->value, 2);
    }

    /**
     * Create users with a specific role and dynamic emails.
     *
     * @param string $roleName
     * @param int $count
     * @return void
     */
    private function createUserWithRole(string $roleName, int $count)
    {
        if (!$this->roleExists($roleName)) {
            return;
        }

        $emailPrefix = $this->setEmailPrefix($roleName);

        for ($i = 1; $i <= $count; $i++) {
            // Dynamically generate the email based on the role name and count
            $email = $count > 1 ? "{$emailPrefix}{$i}@example.com" : "{$emailPrefix}@example.com";

            $user = User::factory()->create([
                'email' => $email,
            ]);

            $user->assignRole($roleName);
        }
    }

    /**
     * Setting email prefix by taking only lowercase letters.
     *
     * @param string $prefix
     * @return string
     */
    private function setEmailPrefix(string $prefix): string
    {
        return strtolower(implode('', array_filter(str_split($prefix), 'ctype_alpha')));
    }

    /**
     * Check if the role exists in the database.
     *
     * @param string $roleName
     * @return bool
     */
    private function roleExists(string $roleName): bool
    {
        $roleExists = Role::where('name', $roleName)->exists();

        if (!$roleExists) {
            $this->command->error("Role '{$roleName}' not found.");
        }

        return $roleExists;
    }
}
