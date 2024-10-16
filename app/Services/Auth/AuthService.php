<?php

namespace App\Services\Auth;

use App\Repositories\Interfaces\UserRepositoryInterface;

class AuthService
{
    protected $authRepository;

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($request)
    {
        $this->userRepository->create($request->validated());
    }
}
