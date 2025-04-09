<?php

use App\Http\Controllers\Web\HomeWebController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\ProductWebController;
use App\Http\Controllers\Web\CmsWebController;
use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\ProcessingWebController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    Route::get('/', [HomeWebController::class, 'showHome'])->name('web.show.home');
    Route::get('privacy-policy', [CmsWebController::class, 'showPrivacyPolicy'])->name('web.show.privacyPolicy');
    Route::get('terms-condition', [CmsWebController::class, 'showTermsCondition'])->name('web.show.termsCondition');
    Route::get('about-us', [CmsWebController::class, 'showAboutUs'])->name('web.show.aboutUs');
    Route::get('return-refund', [CmsWebController::class, 'showReturnRefund'])->name('web.show.returnRefund');
    Route::match(['GET', 'POST'], 'product', [ProductWebController::class, 'showProduct'])->name('web.show.product');
    Route::get('contact-us', [CmsWebController::class, 'showContactUs'])->name('web.show.contactUs');
    Route::post('contact-us/save', [CmsWebController::class, 'saveContactUs'])->name('web.save.contactUs');

    Route::post('auth-login', [AuthWebController::class, 'checkLogin'])->name('web.check.login');
    Route::post('auth-register', [AuthWebController::class, 'saveRegister'])->name('web.save.register');
    Route::post('auth-otp', [AuthWebController::class, 'checkOtp'])->name('web.check.otp');
    Route::post('auth-resend-otp', [AuthWebController::class, 'resendOtp'])->name('web.resend.otp');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('auth-logout', [AuthWebController::class, 'doLogout'])->name('web.do.logout');
        Route::get('dashboard', [DashboardWebController::class, 'showDashboard'])->name('web.show.dashboard');
        Route::post('dashboard/profile/update', [DashboardWebController::class, 'updateProfile'])->name('web.update.profile');
        Route::post('dashboard/address/save', [DashboardWebController::class, 'saveAddress'])->name('web.save.address');
        Route::post('dashboard/address/update', [DashboardWebController::class, 'updateAddress'])->name('web.update.address');
        Route::get('dashboard/address/is-default/{id?}', [DashboardWebController::class, 'isDefaultAddress'])->name('web.isDefault.address');
        Route::get('dashboard/address/delete/{id?}', [DashboardWebController::class, 'deleteAddress'])->name('web.delete.address');
        Route::post('checkout/cart/add/', [ProcessingWebController::class, 'addToCart'])->name('web.add.toCart');
        Route::get('checkout/cart/delete/{id?}', [ProcessingWebController::class, 'deleteToCart'])->name('web.delete.toCart');
        Route::match(['GET', 'POST'], 'checkout', [ProcessingWebController::class, 'showCheckout'])->name('web.show.checkout');
        Route::post('checkout/order/save', [ProcessingWebController::class, 'saveOrder'])->name('web.save.order');
    });
});
