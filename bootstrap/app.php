<?php

use App\Http\Middleware\AppUserStatusMiddleware;
use App\Http\Middleware\CheckAdminMiddleware;
use App\Http\Middleware\CheckPermissionMiddleware;
use App\Http\Middleware\LogSiteVisitMiddleware;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;

use App\Providers\AdminServiceProvider;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$isApi = str_starts_with(Request::capture()->path(), 'api/');
$isAdmin = str_starts_with(Request::capture()->path(), 'admin/');

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api_app.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('admin')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('api')
                ->prefix('api/app')
                ->group(base_path('routes/api_app.php'));

            Route::middleware('api')
                ->prefix('api/web')
                ->group(base_path('routes/api_web.php'));
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
            'checkAdminMiddleware' => CheckAdminMiddleware::class,
            'setLocaleMiddleware' => SetLocaleMiddleware::class,
            'logSiteVisitByMiddleware' => LogSiteVisitMiddleware::class,
            'userStatusMiddleware' => AppUserStatusMiddleware::class,
            'checkPermissionMiddleware' => CheckPermissionMiddleware::class,
            'versionControlMiddleware' => VersionControlMiddleware::class,
        ]);
        // $middleware->append(LogSiteVisitMiddleware::class);
    })
    ->withProviders(
        $isApi ? [] : [],
    )
    ->withProviders(
        $isAdmin ? [AdminServiceProvider::class] : [],
    )
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->usePublicPath(base_path('/'));
return $app;
