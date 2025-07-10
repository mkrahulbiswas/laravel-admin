<?php

use App\Http\Controllers\Web\HomeWebController;
use Illuminate\Support\Facades\Route;


Route::get('home', [HomeWebController::class, 'showHome'])->name('web.show.home');
Route::post('home/upload-file', [HomeWebController::class, 'uploadFileWeb'])->name('web.uploadFileWeb');
