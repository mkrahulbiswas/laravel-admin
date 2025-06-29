<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AppUserStatusMiddleware;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;
use App\Http\Controllers\Api\App\AuthApiAppController;


Route::middleware([
    'logSiteVisitByMiddleware:app',
    SetLocaleMiddleware::class,
    VersionControlMiddleware::class
])->group(function () {
    Route::controller(AuthApiAppController::class)->prefix('auth')->group(function () {
        Route::post('check', 'checkUser')->name('app.auth.checkUser');
        Route::post('verify', 'verifyUser')->name('app.auth.verifyUser');
        Route::post('register', 'registerUser')->name('app.auth.registerUser');
        Route::post('login', 'loginUser')->name('app.auth.loginUser');
        Route::get(
            '/un-authenticated',
            function () {
                return [
                    'status' => 0,
                    'type' => "warning",
                    'title' => "Un-Authenticated",
                    'msg' => __('messages.unauthenticatedMsg'),
                    'payload' => (object)[],
                ];
            }
        )->name('login');
    });
    Route::middleware([
        'auth:sanctum',
        AppUserStatusMiddleware::class,
    ])->group(function () {
        Route::controller(AuthApiAppController::class)->prefix('auth')->group(function () {
            Route::get('logout', 'logoutUser')->name('app.auth.logoutUser');
            Route::get('profile', 'profileUser')->name('app.auth.profileUser');
        });
    });
});
