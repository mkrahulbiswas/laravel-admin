<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['logSiteVisitByMiddleware:web'])->group(function () {});
