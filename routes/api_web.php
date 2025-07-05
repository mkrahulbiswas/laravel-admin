<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AppUserStatusMiddleware;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;
use App\Http\Controllers\Api\Web\AuthWebController;


Route::middleware([
    'logSiteVisitByMiddleware:web',
    SetLocaleMiddleware::class,
    VersionControlMiddleware::class
])->group(function () {
    Route::controller(AuthWebController::class)->prefix('auth')->group(function () {
        Route::post('check', 'checkUser')->name('app.check.user');
        Route::post('verify', 'verifyUser')->name('app.verify.user');
        Route::post('register', 'registerUser')->name('app.register.user');
        Route::post('login', 'loginUser')->name('app.login.user');
        Route::prefix('reset')->group(function () {
            Route::post('send-otp', 'resetSendOtp')->name('app.reset.sendOtp');
            Route::post('verify-otp', 'resetVerifyOtp')->name('app.reset.verifyOtp');
            Route::patch('change-password', 'resetChangePassword')->name('app.reset.changePassword');
        });
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
        Route::controller(AuthWebController::class)->prefix('auth')->group(function () {
            Route::get('logout', 'logoutUser')->name('app.logout.user');
            Route::get('get/profile', 'getProfile')->name('app.get.profile');
            Route::post('change/password', 'changePassword')->name('app.change.password');
            Route::post('update/device-token', 'updateDeviceToken')->name('app.update.deviceToken');
        });
    });
});
