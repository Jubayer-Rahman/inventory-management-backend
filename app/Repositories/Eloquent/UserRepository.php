<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $user) {}

    public function store(array $data)
    {
        User::create($data);
    }

    public function update(array $data, User $user): User
    {
        $user->update($data);
        return $user;
    }
}
