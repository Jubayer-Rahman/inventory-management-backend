<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Arr;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $user)
    {
        $this->user = $user;
    }
    public function create(array $data)
    {
        $this->user->create(Arr::only($data, $this->user->getFillable()));
        return response()->json([
            'message' => "User Created"
        ]);
    }
}
