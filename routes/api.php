<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;


Route::controller(AuthApiController::class)->middleware(['logSiteVisitByMiddleware', SetLocaleMiddleware::class, VersionControlMiddleware::class])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('check', 'checkUser')->name('app.auth.checkUser');
    });

    Route::post('auth/signup', [AuthApiController::class, 'register']);
    Route::post('auth/login', [AuthApiController::class, 'login']);
    Route::post('sendRegOtp', [AuthApiController::class, 'sendRegOtp']);
    Route::post('forgotPassword', [AuthApiController::class, 'forgotPassword']);
    Route::post('resetPassword', [AuthApiController::class, 'resetPassword']);
    Route::post('sendOtp', [AuthApiController::class, 'sendOtp']);
    Route::get('getAppVersion', [AuthApiController::class, 'getAppVersion']);
    Route::group(['middleware' => ['auth:sanctum', 'userStatus']], function () {

        /*======== (-- AuthController --) ========*/
        Route::post('auth/logout', [AuthApiController::class, 'logout']);
        Route::post('updateDeviceToken', [AuthApiController::class, 'updateDeviceToken']);
        Route::get('getProfile', [AuthApiController::class, 'getProfile']);
        Route::post('updateProfile', [AuthApiController::class, 'updateProfile']);
        Route::post('uploadProfilePic', [AuthApiController::class, 'uploadProfilePic']);
        Route::post('changePassword', [AuthApiController::class, 'changePassword']);
        Route::post('updateProfile', [AuthApiController::class, 'updateProfile']);
    });
});
