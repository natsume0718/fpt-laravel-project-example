<?php

namespace App\Providers;

use App\Common\Users\Repositories\Interfaces\RoleRepositoryInterface;
use App\Common\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Common\Users\Repositories\RoleRepository;
use App\Common\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }
}
