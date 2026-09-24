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
        IlluminateSupportFacadesView::composer('*', function ($view) {
            $view->with('settings', AppModelsSetting::allCached());
            try {
                $view->with('pendingCount', AppModelsOrder::where('status', 'pending')->count());
            } catch (Throwable $e) {
                $view->with('pendingCount', 0);
            }
        });
        //
    }
}
