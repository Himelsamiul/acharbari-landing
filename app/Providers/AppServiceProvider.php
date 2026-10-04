<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // super_admin (platform owner) keeps 100% of the panel — every Gate
        // check passes for them; plain admins go through the permission matrix
        \Illuminate\Support\Facades\Gate::before(function ($user) {
            return $user->isSuperAdmin() ? true : null;
        });

        // share site settings + pending order count with every view
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('settings', \App\Models\Setting::allCached());
            try {
                $view->with('pendingCount', \App\Models\Order::where('status', 'pending')->count());
            } catch (Throwable $e) {
                $view->with('pendingCount', 0);
            }
        });
        //
    }
}
