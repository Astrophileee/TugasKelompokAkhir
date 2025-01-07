<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected function redirectTo($request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->hasRole('owner')) {
            return route('branches.select');
        }

        return route('dashboard');
    }

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
        //
    }


}
