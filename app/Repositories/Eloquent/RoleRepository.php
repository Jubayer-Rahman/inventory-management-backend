<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Role $role) {}

    public function index(Request $request): Collection
    {
        return $this->role->get();
    }
}
