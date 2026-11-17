<?php

use HLW\Http\Middleware\PublicPersonalData;
use HLW\Http\Middleware\VerifyAdmins;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // the routes still use 'Controller@method' strings relative to this namespace
        using: function () {
            Route::middleware('web')
                ->namespace('HLW\Http\Controllers')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // users need the role admin or super_admin
            'isAdmin' => VerifyAdmins::class,
            // hides public pages with personal data, see config/hlw.php
            'publicPersonalData' => PublicPersonalData::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);

        // logged in admins who open the login form go to the dashboard
        $middleware->redirectUsersTo(fn () => route('admin'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
