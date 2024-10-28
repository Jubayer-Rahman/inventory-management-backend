<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        return apiSuccessResponse('Login successful', $this->authService->login($request->authenticate()));
    }

    public function logout()
    {
        $this->authService->logout();

        return apiSuccessResponse('User logged out');
    }
}
