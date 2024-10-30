<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function store(array $data);

    public function update(array $data, User $user);
}
