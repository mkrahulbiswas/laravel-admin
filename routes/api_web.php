<?php

use App\Http\Controllers\Api\Web\AuthApiWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;


Route::controller(AuthApiWebController::class)->middleware([
    'logSiteVisitByMiddleware:web',
    SetLocaleMiddleware::class,
    VersionControlMiddleware::class
])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('check', 'checkUser')->name('web.auth.checkUser');
    });

    Route::post('auth/signup', [AuthApiWebController::class, 'register']);
    Route::post('auth/login', [AuthApiWebController::class, 'login']);
    Route::post('sendRegOtp', [AuthApiWebController::class, 'sendRegOtp']);
    Route::post('forgotPassword', [AuthApiWebController::class, 'forgotPassword']);
    Route::post('resetPassword', [AuthApiWebController::class, 'resetPassword']);
    Route::post('sendOtp', [AuthApiWebController::class, 'sendOtp']);
    Route::get('getAppVersion', [AuthApiWebController::class, 'getAppVersion']);
    Route::group(['middleware' => ['auth:sanctum', 'userStatus']], function () {

        /*======== (-- AuthController --) ========*/
        Route::post('auth/logout', [AuthApiWebController::class, 'logout']);
        Route::post('updateDeviceToken', [AuthApiWebController::class, 'updateDeviceToken']);
        Route::get('getProfile', [AuthApiWebController::class, 'getProfile']);
        Route::post('updateProfile', [AuthApiWebController::class, 'updateProfile']);
        Route::post('uploadProfilePic', [AuthApiWebController::class, 'uploadProfilePic']);
        Route::post('changePassword', [AuthApiWebController::class, 'changePassword']);
        Route::post('updateProfile', [AuthApiWebController::class, 'updateProfile']);
    });
});
