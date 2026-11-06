<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\ApplyRedirects::class);

        // guests land on the right login: admin URLs → admin login, everything
        // else (storefront account pages) → the customer login
        $middleware->redirectGuestsTo(
            fn (Illuminate\Http\Request $request) => $request->is('admin') || $request->is('admin/*')
                ? route('admin.login')
                : route('login')
        );

        // logged-in users hitting guest-only pages go back to their own area
        $middleware->redirectUsersTo(
            fn (Illuminate\Http\Request $request) => $request->user()?->isCustomer()
                ? route('account')
                : route('admin.dashboard')
        );

        $middleware->alias([
            'perm' => \App\Http\Middleware\CheckPermission::class,
            'admin.role' => \App\Http\Middleware\EnsureAdminRole::class,
            'customer' => \App\Http\Middleware\EnsureCustomer::class,
        ]);

        // role/permission gates run before route-model binding, so someone
        // without access gets the same 403 whether a record exists or not
        $middleware->prependToPriorityList(
            before: \Illuminate\Routing\Middleware\SubstituteBindings::class,
            prepend: \App\Http\Middleware\EnsureAdminRole::class,
        );
        $middleware->prependToPriorityList(
            before: \Illuminate\Routing\Middleware\SubstituteBindings::class,
            prepend: \App\Http\Middleware\CheckPermission::class,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
