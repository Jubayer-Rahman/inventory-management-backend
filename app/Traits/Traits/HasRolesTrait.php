<?php

namespace App\Traits\Traits;

use App\Models\Role;

trait HasRolesTrait
{
    /**
     * Assign one or more roles to the user by names or IDs.
     *
     * @param string|int|array $roles
     * @return void
     */
    public function assignRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $roleIds = Role::whereIn('id', $this->extractIds($roles))
            ->orWhereIn('name', $this->extractNames($roles))
            ->pluck('id')
            ->toArray();

        if ($roleIds) {
            $this->roles()->attach($roleIds);
        }
    }

    /**
     * Remove one or more roles from the user by names or IDs.
     *
     * @param string|int|array $roles
     * @return void
     */
    public function removeRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $roleIds = Role::whereIn('id', $this->extractIds($roles))
            ->orWhereIn('name', $this->extractNames($roles))
            ->pluck('id')
            ->toArray();

        if ($roleIds) {
            $this->roles()->detach($roleIds);
        }
    }

    /**
     * Sync roles for the user by names or IDs (assign multiple roles and remove others).
     *
     * @param array $roles
     * @return void
     */
    public function syncRoles(array $roles)
    {
        $roleIds = Role::whereIn('id', $this->extractIds($roles))
            ->orWhereIn('name', $this->extractNames($roles))
            ->pluck('id')
            ->toArray();

        $this->roles()->sync($roleIds);
    }

    /**
     * Extract IDs from a mixed array of role names and IDs.
     *
     * @param array $roles
     * @return array
     */
    private function extractIds(array $roles)
    {
        return array_filter($roles, 'is_numeric');
    }

    /**
     * Extract names from a mixed array of role names and IDs.
     *
     * @param array $roles
     * @return array
     */
    private function extractNames(array $roles)
    {
        return array_filter($roles, 'is_string');
    }
}
