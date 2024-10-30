<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct() {}

    public function login(User $user): array
    {
        $user->tokens()->delete();

        $token = $user->createToken(
            name: 'access-token',
            expiresAt: now()->addMinutes(config('sanctum.expiration', null))
        );

        return [
            'user' => $user,
            'access_token' => [
                'token' => $token->plainTextToken,
                'expires_at' => $token->accessToken->expires_at,
            ],
        ];

    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
    }
}
