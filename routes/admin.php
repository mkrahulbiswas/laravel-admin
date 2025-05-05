<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\CmsAdminController;
use App\Http\Controllers\Admin\DDDAdminController;
use App\Http\Controllers\Admin\ManagePanel\ManageAccessAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\Admin\ManagePanel\ManageNavAdminController;

Route::controller(AuthAdminController::class)->group(function () {
    Route::get('/', 'showLogin')->name('show.login');
    Route::post('check-login',  'checkLogin')->name('check.login');
    Route::post('forgot-Password/otp',  'saveForgotPassword')->name('save.forgotPassword');
    Route::post('reset-Password/reset',  'updateResetPassword')->name('update.resetPassword');
    Route::post('changePassword',  'changePasswordLogin');

    Route::middleware(['checkAdmin', CheckPermission::class])->group(function () {

        Route::post('logout',  'logout')->name('logout');
        Route::get('profile/',  'showProfile')->name('profile.show');
        Route::post('profile/update',  'updateProfile')->name('profile.update');
        Route::get('change-password/',  'showChangePassword')->name('password.show');
        Route::post('change-password/update',  'updatePassword')->name('password.update');

        /*======== (-- DashboardAdminController --) ========*/
        Route::controller(DashboardAdminController::class)->group(function () {
            Route::get('dashboard', 'index')->name('dashboard.show');
            Route::post('dashboard/details/product-info', 'detailProductInfo')->name('admin.detail.productInfo');
        });

        /*======== (-- UserAdminController --) ========*/
        Route::group(['prefix' => 'user-management'], function () {
            Route::get('sub-admins', [UserAdminController::class, 'showSubAdmins'])->name('admin.show.usersAdmin');
            Route::get('sub-admins/ajaxGetList', [UserAdminController::class, 'getSubAdmins']);
            Route::get('sub-admins/add', [UserAdminController::class, 'addSubAdmin'])->name('admin.add.usersAdmin');
            Route::post('sub-admins/add/save', [UserAdminController::class, 'saveSubAdmin'])->name('admin.save.usersAdmin');
            Route::get('sub-admins/edit/{id?}', [UserAdminController::class, 'editSubAdmin'])->name('admin.edit.usersAdmin');
            Route::post('sub-admins/edit/update', [UserAdminController::class, 'updateSubAdmin'])->name('admin.update.usersAdmin');
            Route::get('sub-admins/status/{id?}', [UserAdminController::class, 'statusSubAdmin'])->name('admin.status.usersAdmin');
            Route::get('sub-admins/delete/{id?}', [UserAdminController::class, 'deleteSubAdmin'])->name('admin.delete.usersAdmin');
            Route::get('sub-admins/details/{id?}', [UserAdminController::class, 'detailSubAdmin'])->name('admin.details.usersAdmin');

            Route::get('client', [UserAdminController::class, 'showClient'])->name('admin.show.client');
            Route::get('client/ajaxGetList', [UserAdminController::class, 'getClient']);
            Route::get('client/add', [UserAdminController::class, 'addClient'])->name('admin.add.client');
            Route::post('client/add/save', [UserAdminController::class, 'saveClient'])->name('admin.save.client');
            Route::get('client/edit/{id?}', [UserAdminController::class, 'editClient'])->name('admin.edit.client');
            Route::post('client/edit/update', [UserAdminController::class, 'updateClient'])->name('admin.update.client');
            Route::get('client/status/{id?}', [UserAdminController::class, 'statusClient'])->name('admin.status.client');
            Route::get('client/details/{id?}', [UserAdminController::class, 'detailClient'])->name('admin.details.client');
        });


        /*======== (-- SetupAdmin --) ========*/
        Route::group(['prefix' => 'manage-panel'], function () {
            Route::controller(ManageAccessAdminController::class)->prefix('mange-access')->group(function () {
                Route::get('role-main', 'showRoleMain')->name('admin.show.roleMain');
                Route::get('role-main/ajaxGetList', 'getRoleMain')->name('admin.get.roleMain');
                Route::post('role-main/add/save', 'saveRoleMain')->name('admin.save.roleMain');
                Route::post('role-main/edit/update', 'updateRoleMain')->name('admin.update.roleMain');
                Route::get('role-main/status/{id?}', 'statusRoleMain')->name('admin.status.roleMain');
                Route::get('role-main/delete/{id?}', 'deleteRoleMain')->name('admin.delete.roleMain');

                Route::get('role-sub', 'showRoleSub')->name('admin.show.roleSub');
                Route::get('role-sub/ajaxGetList', 'getRoleSub')->name('admin.get.roleSub');
                Route::post('role-sub/add/save', 'saveRoleSub')->name('admin.save.roleSub');
                Route::post('role-sub/edit/update', 'updateRoleSub')->name('admin.update.roleSub');
                Route::get('role-sub/status/{id?}', 'statusRoleSub')->name('admin.status.roleSub');
                Route::get('role-sub/delete/{id?}', 'deleteRoleSub')->name('admin.delete.roleSub');

                Route::get('permissions', 'showPermissions')->name('admin.show.permissions');
                Route::get('permissions/ajaxGetList', 'getPermissions')->name('admin.get.permissions');
                Route::post('permissions/edit/update', 'updatePermissions')->name('admin.update.permissions');
            });

            Route::controller(ManageNavAdminController::class)->prefix('manage-nav')->group(function () {
                // Route::prefix('prepare-nav')->group(function () {
                //     Route::get('nav-type', 'showNavType')->name('admin.show.navType');
                //     Route::get('nav-type/ajaxGetList', 'getNavType')->name('admin.get.navType');
                //     Route::post('nav-type/add/save', 'saveNavType')->name('admin.save.navType');
                //     Route::post('nav-type/edit/update', 'updateNavType')->name('admin.update.navType');
                //     Route::get('nav-type/status/{id?}', 'statusNavType')->name('admin.status.navType');
                //     Route::get('nav-type/delete/{id?}', 'deleteNavType')->name('admin.delete.navType');

                //     Route::get('nav-main', 'showNavMain')->name('admin.show.navMain');
                //     Route::get('nav-main/ajaxGetList', 'getNavMain')->name('admin.get.navMain');
                //     Route::post('nav-main/add/save', 'saveNavMain')->name('admin.save.navMain');
                //     Route::post('nav-main/edit/update', 'updateNavMain')->name('admin.update.navMain');
                //     Route::post('nav-main/edit/access', 'accessNavMain')->name('admin.access.navMain');
                //     Route::get('nav-main/status/{id?}', 'statusNavMain')->name('admin.status.navMain');
                //     Route::get('nav-main/delete/{id?}', 'deleteNavMain')->name('admin.delete.navMain');

                //     Route::get('nav-sub', 'showNavSub')->name('admin.show.navSub');
                //     Route::get('nav-sub/ajaxGetList', 'getNavSub')->name('admin.get.navSub');
                //     Route::post('nav-sub/add/save', 'saveNavSub')->name('admin.save.navSub');
                //     Route::post('nav-sub/edit/update', 'updateNavSub')->name('admin.update.navSub');
                //     Route::post('nav-sub/edit/access', 'accessNavSub')->name('admin.access.navSub');
                //     Route::get('nav-sub/status/{id?}', 'statusNavSub')->name('admin.status.navSub');
                //     Route::get('nav-sub/delete/{id?}', 'deleteNavSub')->name('admin.delete.navSub');

                //     Route::get('nav-nested', 'showNavNested')->name('admin.show.navNested');
                //     Route::get('nav-nested/ajaxGetList', 'getNavNested')->name('admin.get.navNested');
                //     Route::post('nav-nested/add/save', 'saveNavNested')->name('admin.save.navNested');
                //     Route::post('nav-nested/edit/update', 'updateNavNested')->name('admin.update.navNested');
                //     Route::post('nav-nested/edit/access', 'accessNavNested')->name('admin.access.navNested');
                //     Route::get('nav-nested/status/{id?}', 'statusNavNested')->name('admin.status.navNested');
                //     Route::get('nav-nested/delete/{id?}', 'deleteNavNested')->name('admin.delete.navNested');
                // });

                Route::get('nav-type', 'showNavType')->name('admin.show.navType');
                Route::get('nav-type/ajaxGetList', 'getNavType')->name('admin.get.navType');
                Route::post('nav-type/add/save', 'saveNavType')->name('admin.save.navType');
                Route::post('nav-type/edit/update', 'updateNavType')->name('admin.update.navType');
                Route::get('nav-type/status/{id?}', 'statusNavType')->name('admin.status.navType');
                Route::get('nav-type/delete/{id?}', 'deleteNavType')->name('admin.delete.navType');

                Route::get('nav-main', 'showNavMain')->name('admin.show.navMain');
                Route::get('nav-main/ajaxGetList', 'getNavMain')->name('admin.get.navMain');
                Route::post('nav-main/add/save', 'saveNavMain')->name('admin.save.navMain');
                Route::post('nav-main/edit/update', 'updateNavMain')->name('admin.update.navMain');
                Route::post('nav-main/edit/access', 'accessNavMain')->name('admin.access.navMain');
                Route::get('nav-main/status/{id?}', 'statusNavMain')->name('admin.status.navMain');
                Route::get('nav-main/delete/{id?}', 'deleteNavMain')->name('admin.delete.navMain');

                Route::get('nav-sub', 'showNavSub')->name('admin.show.navSub');
                Route::get('nav-sub/ajaxGetList', 'getNavSub')->name('admin.get.navSub');
                Route::post('nav-sub/add/save', 'saveNavSub')->name('admin.save.navSub');
                Route::post('nav-sub/edit/update', 'updateNavSub')->name('admin.update.navSub');
                Route::post('nav-sub/edit/access', 'accessNavSub')->name('admin.access.navSub');
                Route::get('nav-sub/status/{id?}', 'statusNavSub')->name('admin.status.navSub');
                Route::get('nav-sub/delete/{id?}', 'deleteNavSub')->name('admin.delete.navSub');

                Route::get('nav-nested', 'showNavNested')->name('admin.show.navNested');
                Route::get('nav-nested/ajaxGetList', 'getNavNested')->name('admin.get.navNested');
                Route::post('nav-nested/add/save', 'saveNavNested')->name('admin.save.navNested');
                Route::post('nav-nested/edit/update', 'updateNavNested')->name('admin.update.navNested');
                Route::post('nav-nested/edit/access', 'accessNavNested')->name('admin.access.navNested');
                Route::get('nav-nested/status/{id?}', 'statusNavNested')->name('admin.status.navNested');
                Route::get('nav-nested/delete/{id?}', 'deleteNavNested')->name('admin.delete.navNested');

                Route::get('arrange-nav', 'showArrangeNav')->name('admin.show.arrangeNav');
                Route::post('arrange-nav/edit/update', 'updateArrangeNav')->name('admin.update.arrangeNav');
            });
        });


        /*======== (-- SettingAdminController --) ========*/
        Route::group(['prefix' => 'setting'], function () {
            Route::get('site-setting', [SettingAdminController::class, 'showSiteSetting'])->name('admin.show.siteSetting');
            Route::post('site-setting/edit/update', [SettingAdminController::class, 'updateSiteSetting'])->name('admin.update.siteSetting');

            Route::get('social-links', [SettingAdminController::class, 'showSocialLinks'])->name('admin.show.socialLinks');
            Route::get('social-links/ajaxGetList', [SettingAdminController::class, 'getSocialLinks'])->name('admin.get.socialLinks');
            Route::post('social-links/add/save', [SettingAdminController::class, 'saveSocialLinks'])->name('admin.save.socialLinks');
            Route::post('social-links/edit/update', [SettingAdminController::class, 'updateSocialLinks'])->name('admin.update.socialLinks');
            Route::get('social-links/change-status/{id?}', [SettingAdminController::class, 'statusSocialLinks'])->name('admin.status.socialLinks');
            Route::get('social-links/delete/{id?}', [SettingAdminController::class, 'deleteSocialLinks'])->name('admin.delete.socialLinks');

            Route::get('email-template', [SettingAdminController::class, 'showEmailTemplate'])->name('admin.show.emailTemplate');
            Route::get('email-template/ajaxGetList', [SettingAdminController::class, 'getEmailTemplate'])->name('admin.get.emailTemplate');
            Route::post('email-template/edit/update', [SettingAdminController::class, 'updateEmailTemplate'])->name('admin.update.emailTemplate');

            Route::get('logo', [SettingAdminController::class, 'showLogo'])->name('admin.show.logo');
            Route::get('logo/ajaxGetList', [SettingAdminController::class, 'ajaxGetLogo']);
            Route::post('logo/add/save', [SettingAdminController::class, 'saveLogo'])->name('admin.save.logo');
            Route::post('logo/edit/update', [SettingAdminController::class, 'updateLogo'])->name('admin.update.logo');
            Route::get('logo/status/{id?}', [SettingAdminController::class, 'statusLogo'])->name('admin.status.logo');
            Route::get('logo/delete/{id?}', [SettingAdminController::class, 'deleteLogo'])->name('admin.delete.logo');

            Route::get('units', [SettingAdminController::class, 'showUnits'])->name('admin.show.units');
            Route::get('units/ajaxGetList', [SettingAdminController::class, 'getUnits'])->name('admin.get.units');
            Route::post('units/add/save', [SettingAdminController::class, 'saveUnits'])->name('admin.save.units');
            Route::post('units/edit/update', [SettingAdminController::class, 'updateUnits'])->name('admin.update.units');
            Route::get('units/status/{id?}', [SettingAdminController::class, 'statusUnits'])->name('admin.status.units');
            Route::get('units/delete/{id?}', [SettingAdminController::class, 'deleteUnits'])->name('admin.delete.units');
        });


        /*======== (-- CmsAdminController --) ========*/
        Route::group(['prefix' => 'cms'], function () {
            Route::get('banner', [CmsAdminController::class, 'showBanner'])->name('admin.show.banner');
            Route::get('banner/ajaxGetList', [CmsAdminController::class, 'getBanner'])->name('admin.get.banner');
            Route::post('banner/add/save', [CmsAdminController::class, 'saveBanner'])->name('admin.save.banner');
            Route::post('banner/edit/update', [CmsAdminController::class, 'updateBanner'])->name('admin.update.banner');
            Route::get('banner/status/{id?}', [CmsAdminController::class, 'statusBanner'])->name('admin.status.banner');
            Route::get('banner/delete/{id?}', [CmsAdminController::class, 'deleteBanner'])->name('admin.delete.banner');

            Route::get('privacy-policy', [CmsAdminController::class, 'showPrivacyPolicy'])->name('admin.show.privacyPolicy');
            Route::post('privacy-policy/edit/update', [CmsAdminController::class, 'updatePrivacyPolicy'])->name('admin.update.privacyPolicy');

            Route::get('terms-condition', [CmsAdminController::class, 'showTermsCondition'])->name('admin.show.termsCondition');
            Route::post('terms-condition/edit/update', [CmsAdminController::class, 'updateTermsCondition'])->name('admin.update.termsCondition');

            Route::get('about-us', [CmsAdminController::class, 'showAboutUs'])->name('admin.show.aboutUs');
            Route::post('about-us/edit/update', [CmsAdminController::class, 'updateAboutUs'])->name('admin.update.aboutUs');

            Route::get('contact-us', [CmsAdminController::class, 'showContactUs'])->name('admin.show.contactUs');
            Route::post('contact-us/edit/update', [CmsAdminController::class, 'updateContactUs'])->name('admin.update.contactUs');

            Route::get('return-refund', [CmsAdminController::class, 'showReturnRefund'])->name('admin.show.returnRefund');
            Route::post('return-refund/edit/update', [CmsAdminController::class, 'updateReturnRefund'])->name('admin.update.returnRefund');

            Route::get('contact-enquiry', [CmsAdminController::class, 'showContactEnquiry'])->name('admin.show.contactEnquiry');
            Route::get('contact-enquiry/ajaxGetList', [CmsAdminController::class, 'getContactEnquiry'])->name('admin.get.contactEnquiry');
            Route::get('contact-enquiry/delete/{id?}', [CmsAdminController::class, 'deleteContactEnquiry'])->name('admin.delete.contactEnquiry');

            Route::get('faq', [CmsAdminController::class, 'showFaq'])->name('admin.show.faq');
            Route::get('faq/ajaxGetList', [CmsAdminController::class, 'getFaq'])->name('admin.get.faq');
            Route::post('faq/add/save', [CmsAdminController::class, 'saveFaq'])->name('admin.save.faq');
            Route::post('faq/edit/update', [CmsAdminController::class, 'updateFaq'])->name('admin.update.faq');
            Route::get('faq/status/{id?}', [CmsAdminController::class, 'statusFaq'])->name('admin.status.faq');
            Route::get('faq/delete/{id?}', [CmsAdminController::class, 'deleteFaq'])->name('admin.delete.faq');
        });


        /*======== (-- DDDAdminController --) ========*/
        Route::controller(DDDAdminController::class)->prefix('ddd')->group(function () {
            Route::get('nav-main/{navTypeId?}', 'getNavMain')->name('admin.get.navMainDDD');
            Route::get('nav-sub/{navMainId?}', 'getNavSub')->name('admin.get.navSubDDD');
        });

        /*======== (-- Error Page --) ========*/
        // Route::get('admin/page/404', 'Admin\CommonController@show404')->name('404');
        // Route::get('admin/page/500', 'Admin\CommonController@show500')->name('500');
    });
});
