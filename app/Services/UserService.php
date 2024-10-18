<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function store(UserRequest $request)
    {
        $this->userRepository->store($request->validated());
    }
}
