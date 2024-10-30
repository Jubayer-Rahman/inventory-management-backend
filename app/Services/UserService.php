<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Arr;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository, private User $user) {}

    public function store(UserRequest $request)
    {
        $this->userRepository->store(Arr::only($request->validated(), $this->user->getFillable()));
    }

    public function update(UserRequest $request, User $user): User
    {
        return $this->userRepository->update(array_merge(
            Arr::only($request->validated(), $user->getFillable()),
            $request->filled('new_password') ? ['password' => $request->new_password] : []
        ), $user);
    }
}
