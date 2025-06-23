<?php

use App\Http\Controllers\Api\App\AuthApiAppController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;


Route::controller(AuthApiAppController::class)->middleware([
    'logSiteVisitByMiddleware:app',
    SetLocaleMiddleware::class,
    VersionControlMiddleware::class
])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('check', 'checkUser')->name('app.auth.checkUser');
    });

    Route::post('auth/signup', [AuthApiAppController::class, 'register']);
    Route::post('auth/login', [AuthApiAppController::class, 'login']);
    Route::post('sendRegOtp', [AuthApiAppController::class, 'sendRegOtp']);
    Route::post('forgotPassword', [AuthApiAppController::class, 'forgotPassword']);
    Route::post('resetPassword', [AuthApiAppController::class, 'resetPassword']);
    Route::post('sendOtp', [AuthApiAppController::class, 'sendOtp']);
    Route::get('getAppVersion', [AuthApiAppController::class, 'getAppVersion']);
    Route::group(['middleware' => ['auth:sanctum', 'userStatus']], function () {

        /*======== (-- AuthController --) ========*/
        Route::post('auth/logout', [AuthApiAppController::class, 'logout']);
        Route::post('updateDeviceToken', [AuthApiAppController::class, 'updateDeviceToken']);
        Route::get('getProfile', [AuthApiAppController::class, 'getProfile']);
        Route::post('updateProfile', [AuthApiAppController::class, 'updateProfile']);
        Route::post('uploadProfilePic', [AuthApiAppController::class, 'uploadProfilePic']);
        Route::post('changePassword', [AuthApiAppController::class, 'changePassword']);
        Route::post('updateProfile', [AuthApiAppController::class, 'updateProfile']);
    });
});
