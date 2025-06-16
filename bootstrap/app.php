<?php

use App\Http\Middleware\AppUserStatus;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\LogSiteVisitMiddleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\VersionControlMiddleware;

use App\Providers\AdminAppServiceProvider;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$isApi = str_starts_with(Request::capture()->path(), 'api/');

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('admin')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('admin', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->alias([
            'checkAdmin' => CheckAdmin::class,
            'setLocale' => SetLocale::class,
            'logSiteVisitBy' => LogSiteVisitMiddleware::class,
            'userStatus' => AppUserStatus::class,
            'checkPermission' => CheckPermission::class,
            'versionControlMiddleware' => VersionControlMiddleware::class,
        ]);
        // $middleware->append(LogSiteVisitMiddleware::class);
    })
    ->withProviders(
        !$isApi ? [AdminAppServiceProvider::class] : [],
    )
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->usePublicPath(base_path('/'));
return $app;
