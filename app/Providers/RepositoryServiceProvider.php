<?php

namespace App\Providers;

use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserInvitationRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\VariationOptionRepository;
use App\Repositories\Eloquent\VariationRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserInvitationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\VariationOptionRepositoryInterface;
use App\Repositories\Interfaces\VariationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UserInvitationRepositoryInterface::class, UserInvitationRepository::class);
        $this->app->bind(VariationOptionRepositoryInterface::class, VariationOptionRepository::class);
        $this->app->bind(VariationRepositoryInterface::class, VariationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
