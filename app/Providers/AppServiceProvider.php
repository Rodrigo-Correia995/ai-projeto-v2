<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
       Gate::define('admin', function (User $user) {
        // Somente utilizadores com type 'board' são administradores
        return $user->type == 'board';
    });

    Gate::define('employee', function (User $user) {
        // Somente utilizadores com type 'board' são administradores
        return $user->type == 'board' || $user->type == 'employee';
    });
    }
}
