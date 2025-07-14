<?php

use App\Http\Controllers\Api\CommonApiController;
use App\Http\Controllers\Api\TestCaseApiController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'logSiteVisitByMiddleware:api',
])->group(function () {
    Route::controller(CommonApiController::class)->prefix('common')->group(function () {
        Route::get('device-type', 'getDeviceType')->name('app.common.getDeviceType');
    });
    Route::controller(TestCaseApiController::class)->prefix('test-case')->group(function () {
        Route::post('upload-file', 'uploadFileTest')->name('app.testCase.uploadFile');
    });
});
