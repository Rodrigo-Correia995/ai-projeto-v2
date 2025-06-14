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
        // board são admin
        return $user->type == 'board';
    });

    Gate::define('employee', function (User $user) {
        // board e emplyee são emplyee
        return $user->type == 'board' || $user->type == 'employee';
    });

     Gate::define('other', function (User $user) {
        // other todos menos member
        return $user->type == 'member' || $user->type == 'board' || $user->type == 'pending_member';
    });

    }
}
