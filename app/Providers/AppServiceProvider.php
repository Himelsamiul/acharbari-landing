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
