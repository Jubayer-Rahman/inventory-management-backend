<?php

namespace App\Traits\Traits;

use App\Models\Role;

trait HasRolesTrait
{
    /**
     * Assign one or more roles to the user by names.
     *
     * @param string|array $roles
     * @return void
     */
    public function assignRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $roleIds = Role::whereIn('name', $roles)
            ->pluck('id')
            ->toArray();

        if ($roleIds) {
            $this->roles()->attach($roleIds);
        }
    }

    /**
     * Check if the user has a role by name.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Remove one or more roles from the user by names.
     *
     * @param string|array $roles
     * @return void
     */
    public function removeRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $roleIds = Role::whereIn('name', $roles)
            ->pluck('id')
            ->toArray();

        if ($roleIds) {
            $this->roles()->detach($roleIds);
        }
    }

    /**
     * Sync roles for the user by names (assign multiple roles and remove others).
     *
     * @param array $roles
     * @return void
     */
    public function syncRoles(array $roles)
    {
        $roleIds = Role::whereIn('name', $roles)
            ->pluck('id')
            ->toArray();

        $this->roles()->sync($roleIds);
    }
}
