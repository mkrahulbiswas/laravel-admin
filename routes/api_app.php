<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AppUserStatusMiddleware;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;
use App\Http\Controllers\Api\App\AuthAppController;
use App\Http\Controllers\Api\App\CommonAppController;

Route::middleware([
    'logSiteVisitByMiddleware:app',
    SetLocaleMiddleware::class,
    VersionControlMiddleware::class
])->group(function () {
    Route::controller(CommonAppController::class)->prefix('common')->group(function () {
        Route::get('app-version', 'getAppVersion')->name('app.common.getAppVersion')->withoutMiddleware([VersionControlMiddleware::class]);
    });
    Route::controller(AuthAppController::class)->prefix('auth')->group(function () {
        Route::post('check', 'checkUser')->name('app.check.user');
        Route::post('verify', 'verifyUser')->name('app.verify.user');
        Route::post('register', 'registerUser')->name('app.register.user');
        Route::post('login', 'loginUser')->name('app.login.user');
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
        Route::controller(AuthAppController::class)->prefix('auth')->group(function () {
            Route::get('logout', 'logoutUser')->name('app.logout.user');
            Route::get('get/profile', 'getProfile')->name('app.get.profile');
            Route::post('update/profile-pic', 'updateProfilePic')->name('app.update.profilePic');
            Route::patch('change/password', 'changePassword')->name('app.change.password');
            Route::patch('update/device-token', 'updateDeviceToken')->name('app.update.deviceToken');
        });
    });
});
