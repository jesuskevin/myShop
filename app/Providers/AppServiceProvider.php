<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('admin', function () {
            return auth()->user()->role == User::ROLE_ADMIN;
        });

        Blade::if('member', function () {
            return auth()->user()->role == User::ROLE_MEMBER;
        });

        Paginator::useBootstrapFive();
    }
}
