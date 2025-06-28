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
            '/some_url',
            function () {
                return "Token is wrong";
            }
        )->name('login');
    });

    // Route::post('sendRegOtp', [AuthApiAppController::class, 'sendRegOtp']);
    // Route::post('forgotPassword', [AuthApiAppController::class, 'forgotPassword']);
    // Route::post('resetPassword', [AuthApiAppController::class, 'resetPassword']);
    // Route::post('sendOtp', [AuthApiAppController::class, 'sendOtp']);
    // Route::get('getAppVersion', [AuthApiAppController::class, 'getAppVersion']);

    Route::middleware([
        'auth:sanctum',
        AppUserStatusMiddleware::class,
    ])->group(function () {

        Route::controller(AuthApiAppController::class)->prefix('auth')->group(function () {
            Route::post('logout', 'logoutUser')->name('app.auth.logoutUser');
            Route::get('profile', 'profileUser')->name('app.auth.profileUser');
        });

        // Route::post('updateDeviceToken', [AuthApiAppController::class, 'updateDeviceToken']);
        // Route::get('getProfile', [AuthApiAppController::class, 'getProfile']);
        // Route::post('updateProfile', [AuthApiAppController::class, 'updateProfile']);
        // Route::post('uploadProfilePic', [AuthApiAppController::class, 'uploadProfilePic']);
        // Route::post('changePassword', [AuthApiAppController::class, 'changePassword']);
        // Route::post('updateProfile', [AuthApiAppController::class, 'updateProfile']);
    });
});
