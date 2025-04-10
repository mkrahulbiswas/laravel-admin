<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\CmsAdminController;
use App\Http\Controllers\Admin\SetupAdmin\RolePermissionController;
use App\Http\Controllers\Admin\SetupAdmin\SideNavBarController;
use App\Http\Controllers\Admin\DDDAdminController;
use App\Http\Controllers\Admin\ManageProductAdminController;
use App\Http\Controllers\Admin\ManageOrdersAdminController;
use App\Http\Controllers\Admin\ManagePanel\ManageAccessAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Middleware\CheckPermission;

use App\Http\Controllers\Admin\ManagePanel\ManageNavAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great! a
|
*/

Route::get('/', [AuthAdminController::class, 'showLogin'])->name('show.login');
Route::post('check-login',  [AuthAdminController::class, 'checkLogin'])->name('check.login');
Route::post('forgot-Password/otp',  [AuthAdminController::class, 'saveForgotPassword'])->name('save.forgotPassword');
Route::post('reset-Password/reset',  [AuthAdminController::class, 'updateResetPassword'])->name('update.resetPassword');
Route::post('changePassword',  [AuthAdminController::class, 'changePasswordLogin']);

Route::middleware(['checkAdmin', CheckPermission::class])->group(function () {

    Route::post('logout',  [AuthAdminController::class, 'logout'])->name('logout');
    Route::get('profile/',  [AuthAdminController::class, 'showProfile'])->name('profile.show');
    Route::post('profile/update',  [AuthAdminController::class, 'updateProfile'])->name('profile.update');
    Route::get('change-password/',  [AuthAdminController::class, 'showChangePassword'])->name('password.show');
    Route::post('change-password/update',  [AuthAdminController::class, 'updatePassword'])->name('password.update');

    /*======== (-- DashboardAdminController --) ========*/
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboard.show');
    Route::post('dashboard/details/product-info', [DashboardAdminController::class, 'detailProductInfo'])->name('admin.detail.productInfo');

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

        Route::get('roles', [RolePermissionController::class, 'showRole'])->name('admin.show.roles');
        Route::get('roles/ajaxGetList', [RolePermissionController::class, 'getRole']);
        Route::post('roles/add/save', [RolePermissionController::class, 'saveRole'])->name('admin.save.roles');
        Route::post('roles/add/update', [RolePermissionController::class, 'updateRole'])->name('admin.update.roles');
        Route::get('roles/status/{id?}', [RolePermissionController::class, 'statusRole'])->name('admin.status.roles');
        Route::get('roles/delete/{id?}', [RolePermissionController::class, 'deleteRole'])->name('admin.delete.roles');
        Route::get('permissions/edit/ajaxGetList', [RolePermissionController::class, 'getPermissions']);
        Route::get('permissions/edit/{id?}', [RolePermissionController::class, 'editPermission'])->name('admin.edit.permissions');
        Route::post('permissions/edit/update', [RolePermissionController::class, 'updatePermission'])->name('admin.update.permissions');

        Route::group(['prefix' => 'mange-access'], function () {
            Route::get('role-main', [ManageAccessAdminController::class, 'showRoleMain'])->name('admin.show.roleMain');
            Route::get('role-main/ajaxGetList', [ManageAccessAdminController::class, 'getRoleMain'])->name('admin.get.roleMain');
            Route::post('role-main/add/save', [ManageAccessAdminController::class, 'saveRoleMain'])->name('admin.save.roleMain');
            Route::post('role-main/edit/update', [ManageAccessAdminController::class, 'updateRoleMain'])->name('admin.update.roleMain');
            Route::get('role-main/change-status/{id?}', [ManageAccessAdminController::class, 'statusRoleMain'])->name('admin.status.roleMain');
            Route::get('role-main/delete/{id?}', [ManageAccessAdminController::class, 'deleteRoleMain'])->name('admin.delete.roleMain');

            Route::get('role-sub', [ManageAccessAdminController::class, 'showRoleSub'])->name('admin.show.roleSub');
            Route::get('role-sub/ajaxGetList', [ManageAccessAdminController::class, 'getRoleSub'])->name('admin.get.roleSub');
            Route::post('role-sub/add/save', [ManageAccessAdminController::class, 'saveRoleSub'])->name('admin.save.roleSub');
            Route::post('role-sub/edit/update', [ManageAccessAdminController::class, 'updateRoleSub'])->name('admin.update.roleSub');
            Route::get('role-sub/change-status/{id?}', [ManageAccessAdminController::class, 'statusRoleSub'])->name('admin.status.roleSub');
            Route::get('role-sub/delete/{id?}', [ManageAccessAdminController::class, 'deleteRoleSub'])->name('admin.delete.roleSub');
        });

        Route::group(['prefix' => 'manage-nav'], function () {
            Route::get('nav-type', [ManageNavAdminController::class, 'showNavType'])->name('admin.show.navType');
            Route::get('nav-type/ajaxGetList', [ManageNavAdminController::class, 'getNavType'])->name('admin.get.navType');
            Route::post('nav-type/add/save', [ManageNavAdminController::class, 'saveNavType'])->name('admin.save.navType');
            Route::post('nav-type/edit/update', [ManageNavAdminController::class, 'updateNavType'])->name('admin.update.navType');
            Route::get('nav-type/change-status/{id?}', [ManageNavAdminController::class, 'statusNavType'])->name('admin.status.navType');
            Route::get('nav-type/delete/{id?}', [ManageNavAdminController::class, 'deleteNavType'])->name('admin.delete.navType');

            Route::get('nav-main', [ManageNavAdminController::class, 'showNavMain'])->name('admin.show.navMain');
            Route::get('nav-main/ajaxGetList', [ManageNavAdminController::class, 'getNavMain'])->name('admin.get.navMain');
            Route::post('nav-main/add/save', [ManageNavAdminController::class, 'saveNavMain'])->name('admin.save.navMain');
            Route::post('nav-main/edit/update', [ManageNavAdminController::class, 'updateNavMain'])->name('admin.update.navMain');
            Route::get('nav-main/change-status/{id?}', [ManageNavAdminController::class, 'statusNavMain'])->name('admin.status.navMain');
            Route::get('nav-main/delete/{id?}', [ManageNavAdminController::class, 'deleteNavMain'])->name('admin.delete.navMain');

            Route::get('nav-sub', [ManageNavAdminController::class, 'showNavSub'])->name('admin.show.navSub');
            Route::get('nav-sub/ajaxGetList', [ManageNavAdminController::class, 'getNavSub'])->name('admin.get.navSub');
            Route::post('nav-sub/add/save', [ManageNavAdminController::class, 'saveNavSub'])->name('admin.save.navSub');
            Route::post('nav-sub/edit/update', [ManageNavAdminController::class, 'updateNavSub'])->name('admin.update.navSub');
            Route::get('nav-sub/change-status/{id?}', [ManageNavAdminController::class, 'statusNavSub'])->name('admin.status.navSub');
            Route::get('nav-sub/delete/{id?}', [ManageNavAdminController::class, 'deleteNavSub'])->name('admin.delete.navSub');

            Route::get('nav-nested', [ManageNavAdminController::class, 'showNavNested'])->name('admin.show.navNested');
            Route::get('nav-nested/ajaxGetList', [ManageNavAdminController::class, 'getNavNested'])->name('admin.get.navNested');
            Route::post('nav-nested/add/save', [ManageNavAdminController::class, 'saveNavNested'])->name('admin.save.navNested');
            Route::post('nav-nested/edit/update', [ManageNavAdminController::class, 'updateNavNested'])->name('admin.update.navNested');
            Route::get('nav-nested/change-status/{id?}', [ManageNavAdminController::class, 'statusNavNested'])->name('admin.status.navNested');
            Route::get('nav-nested/delete/{id?}', [ManageNavAdminController::class, 'deleteNavNested'])->name('admin.delete.navNested');

            Route::get('arrange-nav', [ManageNavAdminController::class, 'showArrangeNav'])->name('admin.show.arrangeNav');
            Route::post('arrange-nav/edit/update', [ManageNavAdminController::class, 'updateArrangeNav'])->name('admin.update.arrangeNav');
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
    Route::group(['prefix' => 'ddd'], function () {
        Route::get('nav-main/{navTypeId?}', [DDDAdminController::class, 'getNavMain'])->name('admin.get.navMainDDD');
        Route::get('nav-sub/{navMainId?}', [DDDAdminController::class, 'getNavSub'])->name('admin.get.navSubDDD');
    });

    /*======== (-- Error Page --) ========*/
    // Route::get('admin/page/404', 'Admin\CommonController@show404')->name('404');
    // Route::get('admin/page/500', 'Admin\CommonController@show500')->name('500');
});
