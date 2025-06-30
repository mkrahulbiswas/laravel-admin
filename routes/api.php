<?php

use App\Http\Controllers\Api\CommonApiController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'logSiteVisitByMiddleware:api',
])->group(function () {
    Route::controller(CommonApiController::class)->prefix('common')->group(function () {
        Route::get('device-type', 'getDeviceType')->name('app.common.getDeviceType');
    });
});
