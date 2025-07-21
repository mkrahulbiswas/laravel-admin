<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AppUserStatusMiddleware;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Http\Middleware\VersionControlMiddleware;
use App\Http\Controllers\Api\App\AuthAppController;
use App\Http\Controllers\Api\App\CommonAppController;
use App\Http\Controllers\Api\App\PropertyRelated\CreatePostAppController;
use App\Http\Controllers\Api\App\PropertyRelated\PropertyInstanceAppController;

Route::middleware([
    'logSiteVisitByMiddleware:api app',
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
                    'payload' => (object) [],
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
            Route::prefix('change')->group(function () {
                Route::post('send-otp', 'changeSendOtp')->name('app.change.sendOtp');
                Route::post('verify-otp', 'changeVerifyOtp')->name('app.change.verifyOtp');
            });
        });
        Route::prefix('property-related')->group(function () {
            Route::controller(PropertyInstanceAppController::class)->group(function () {
                Route::get('property-type', 'getPropertyType')->name('app.get.propertyType');
                Route::prefix('manage-broad')->group(function () {
                    Route::get('broad-type', 'getBroadType')->name('app.get.broadType');
                    Route::get('assign-broad/{propertyTypeId?}', 'getAssignBroad')->name('app.get.assignBroad');
                });
                Route::prefix('property-category')->group(function () {
                    Route::get('main-category', 'getMainCategory')->name('app.get.mainCategory');
                    Route::get('sub-category/{mainCategoryId?}', 'getSubCategory')->name('app.get.subCategory');
                    Route::get('nested-category/{mainCategoryId?}/{subCategoryId?}', 'getNestedCategory')->name('app.get.nestedCategory');
                    Route::get('all-category', 'getAllCategory')->name('app.get.allCategory');
                    Route::get('assign-category/{propertyTypeId?}/{broadTypeId?}', 'getAssignCategory')->name('app.get.assignCategory');
                });
                Route::get('assign-broad-category/{propertyTypeId?}', 'getAssignBroadCategory')->name('app.get.assignBroadCategory');
            });
            Route::controller(CreatePostAppController::class)->group(function () {
                Route::prefix('manage-post')->group(function () {
                    Route::get('initiate', 'initiatePostDb')->name('app.initiate.postDb');
                    Route::patch('update/basic-details', 'updateBasicDetails')->name('app.update.basicDetails');
                    Route::patch('update/property-located', 'updatePropertyLocated')->name('app.update.propertyLocated');
                });
            });
        });
    });
});
