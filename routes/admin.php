<?php

use App\Http\Controllers\Admin\AdminRelated\RolePermission\ManageRoleAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DDDAdminController;
use App\Http\Controllers\Admin\Dashboard\DashboardAdminController;
use App\Http\Controllers\Admin\ManagePanel\ManageAccessAdminController;
use App\Http\Controllers\Admin\ManagePanel\ManageNavAdminController;
use App\Http\Controllers\Admin\ManagePanel\QuickSettingsAdminController;
use App\Http\Controllers\Admin\ManageUsers\AdminUsersAdminController;
use App\Http\Controllers\Admin\PropertyRelated\ManageBroadAdminController;
use App\Http\Controllers\Admin\PropertyRelated\PropertyAttributeAdminController;
use App\Http\Controllers\Admin\PropertyRelated\PropertyCategoryAdminController;
use App\Http\Controllers\Admin\PropertyRelated\PropertyTypeAdminController;
use App\Http\Middleware\CheckPermission;

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
        Route::group(['prefix' => 'dashboard'], function () {
            Route::controller(DashboardAdminController::class)->group(function () {
                Route::get('quick-overview', 'showAdminQuickOverview')->name('admin.show.QuickOverview');
                Route::get('charts-view', 'showAdminChartsView')->name('admin.show.ChartsView');
            });
        });

        /*======== (-- Admin Related --) ========*/
        Route::group(['prefix' => 'role-permission'], function () {
            Route::controller(ManageRoleAdminController::class)->prefix('manage-role')->group(function () {
                Route::get('main-role', 'showMainRole')->name('admin.show.mainRole');
                Route::get('main-role/ajaxGetList', 'getMainRole')->name('admin.get.mainRole');
                Route::post('main-role/add/save', 'saveMainRole')->name('admin.save.mainRole');
                Route::post('main-role/edit/update', 'updateMainRole')->name('admin.update.mainRole');
                Route::patch('main-role/permission/{id?}', 'permissionMainRole')->name('admin.permission.mainRole');
                Route::patch('main-role/status/{id?}', 'statusMainRole')->name('admin.status.mainRole');
                Route::delete('main-role/delete/{id?}', 'deleteMainRole')->name('admin.delete.mainRole');
                Route::group(['prefix' => 'main-role'], function () {
                    Route::get('permission/{MainRoleId?}', 'showPermissionMainRole')->name('admin.show.permissionMainRole');
                    Route::get('permission/main-role/ajaxGetList/{MainRoleId?}', 'getPermissionMainRole')->name('admin.get.permissionMainRole');
                    Route::post('permission/update', 'updatePermissionMainRole')->name('admin.update.permissionMainRole');
                });

                Route::get('sub-role', 'showSubRole')->name('admin.show.subRole');
                Route::get('sub-role/ajaxGetList', 'getSubRole')->name('admin.get.subRole');
                Route::post('sub-role/add/save', 'saveSubRole')->name('admin.save.subRole');
                Route::post('sub-role/edit/update', 'updateSubRole')->name('admin.update.subRole');
                Route::patch('sub-role/permission/{id?}', 'permissionSubRole')->name('admin.permission.subRole');
                Route::patch('sub-role/status/{id?}', 'statusSubRole')->name('admin.status.subRole');
                Route::delete('sub-role/delete/{id?}', 'deleteSubRole')->name('admin.delete.subRole');
                Route::group(['prefix' => 'sub-role'], function () {
                    Route::get('permission/{SubRoleId?}', 'showPermissionSubRole')->name('admin.show.permissionSubRole');
                    Route::get('permission/sub-role/ajaxGetList/{SubRoleId?}', 'getPermissionSubRole')->name('admin.get.permissionSubRole');
                    Route::post('permission/update', 'updatePermissionSubRole')->name('admin.update.permissionSubRole');
                });

                Route::get('permissions', 'showPermissions')->name('admin.show.permissions');
                Route::get('permissions/ajaxGetList', 'getPermissions')->name('admin.get.permissions');
                Route::post('permissions/edit/update', 'updatePermissions')->name('admin.update.permissions');
            });
        });

        Route::group(['prefix' => 'manage-panel'], function () {
            Route::controller(QuickSettingsAdminController::class)->prefix('quick-settings')->group(function () {
                Route::get('logo', 'showLogo')->name('admin.show.logo');
                Route::get('logo/ajaxGetList', 'getLogo')->name('admin.get.logo');
                Route::post('logo/add/save', 'saveLogo')->name('admin.save.logo');
                Route::post('logo/edit/update', 'updateLogo')->name('admin.update.logo');
                Route::patch('logo/default/{id?}', 'defaultLogo')->name('admin.default.logo');
                Route::delete('logo/delete/{id?}', 'deleteLogo')->name('admin.delete.logo');

                Route::get('templates', 'showTemplates')->name('admin.show.templates');
                Route::get('templates/email/ajaxGetList', 'getEmailTemplates')->name('admin.get.emailTemplates');
                Route::get('templates/phone/ajaxGetList', 'getPhoneTemplates')->name('admin.get.phoneTemplates');
                Route::post('templates/add/save', 'saveTemplates')->name('admin.save.templates');
                Route::post('templates/edit/update', 'updateTemplates')->name('admin.update.templates');
                Route::patch('templates/status/{id?}', 'statusTemplates')->name('admin.status.templates');
                Route::delete('templates/delete/{id?}', 'deleteTemplates')->name('admin.delete.templates');
            });

            Route::controller(ManageNavAdminController::class)->prefix('manage-nav')->group(function () {
                // Route::prefix('prepare-nav')->group(function () {
                //     Route::get('nav-type', 'showNavType')->name('admin.show.navType');
                //     Route::get('nav-type/ajaxGetList', 'getNavType')->name('admin.get.navType');
                //     Route::post('nav-type/add/save', 'saveNavType')->name('admin.save.navType');
                //     Route::post('nav-type/edit/update', 'updateNavType')->name('admin.update.navType');
                //     Route::patch('nav-type/status/{id?}', 'statusNavType')->name('admin.status.navType');
                //     Route::delete('nav-type/delete/{id?}', 'deleteNavType')->name('admin.delete.navType');

                //     Route::get('nav-main', 'showNavMain')->name('admin.show.navMain');
                //     Route::get('nav-main/ajaxGetList', 'getNavMain')->name('admin.get.navMain');
                //     Route::post('nav-main/add/save', 'saveNavMain')->name('admin.save.navMain');
                //     Route::post('nav-main/edit/update', 'updateNavMain')->name('admin.update.navMain');
                //     Route::post('nav-main/edit/access', 'accessNavMain')->name('admin.access.navMain');
                //     Route::patch('nav-main/status/{id?}', 'statusNavMain')->name('admin.status.navMain');
                //     Route::delete('nav-main/delete/{id?}', 'deleteNavMain')->name('admin.delete.navMain');

                //     Route::get('nav-sub', 'showNavSub')->name('admin.show.navSub');
                //     Route::get('nav-sub/ajaxGetList', 'getNavSub')->name('admin.get.navSub');
                //     Route::post('nav-sub/add/save', 'saveNavSub')->name('admin.save.navSub');
                //     Route::post('nav-sub/edit/update', 'updateNavSub')->name('admin.update.navSub');
                //     Route::post('nav-sub/edit/access', 'accessNavSub')->name('admin.access.navSub');
                //     Route::patch('nav-sub/status/{id?}', 'statusNavSub')->name('admin.status.navSub');
                //     Route::delete('nav-sub/delete/{id?}', 'deleteNavSub')->name('admin.delete.navSub');

                //     Route::get('nav-nested', 'showNavNested')->name('admin.show.navNested');
                //     Route::get('nav-nested/ajaxGetList', 'getNavNested')->name('admin.get.navNested');
                //     Route::post('nav-nested/add/save', 'saveNavNested')->name('admin.save.navNested');
                //     Route::post('nav-nested/edit/update', 'updateNavNested')->name('admin.update.navNested');
                //     Route::post('nav-nested/edit/access', 'accessNavNested')->name('admin.access.navNested');
                //     Route::patch('nav-nested/status/{id?}', 'statusNavNested')->name('admin.status.navNested');
                //     Route::delete('nav-nested/delete/{id?}', 'deleteNavNested')->name('admin.delete.navNested');
                // });

                Route::get('nav-type', 'showNavType')->name('admin.show.navType');
                Route::get('nav-type/ajaxGetList', 'getNavType')->name('admin.get.navType');
                Route::post('nav-type/add/save', 'saveNavType')->name('admin.save.navType');
                Route::post('nav-type/edit/update', 'updateNavType')->name('admin.update.navType');
                Route::patch('nav-type/status/{id?}', 'statusNavType')->name('admin.status.navType');
                Route::delete('nav-type/delete/{id?}', 'deleteNavType')->name('admin.delete.navType');

                Route::get('nav-main', 'showNavMain')->name('admin.show.navMain');
                Route::get('nav-main/ajaxGetList', 'getNavMain')->name('admin.get.navMain');
                Route::post('nav-main/add/save', 'saveNavMain')->name('admin.save.navMain');
                Route::post('nav-main/edit/update', 'updateNavMain')->name('admin.update.navMain');
                Route::post('nav-main/edit/access', 'accessNavMain')->name('admin.access.navMain');
                Route::patch('nav-main/status/{id?}', 'statusNavMain')->name('admin.status.navMain');
                Route::delete('nav-main/delete/{id?}', 'deleteNavMain')->name('admin.delete.navMain');

                Route::get('nav-sub', 'showNavSub')->name('admin.show.navSub');
                Route::get('nav-sub/ajaxGetList', 'getNavSub')->name('admin.get.navSub');
                Route::post('nav-sub/add/save', 'saveNavSub')->name('admin.save.navSub');
                Route::post('nav-sub/edit/update', 'updateNavSub')->name('admin.update.navSub');
                Route::post('nav-sub/edit/access', 'accessNavSub')->name('admin.access.navSub');
                Route::patch('nav-sub/status/{id?}', 'statusNavSub')->name('admin.status.navSub');
                Route::delete('nav-sub/delete/{id?}', 'deleteNavSub')->name('admin.delete.navSub');

                Route::get('nav-nested', 'showNavNested')->name('admin.show.navNested');
                Route::get('nav-nested/ajaxGetList', 'getNavNested')->name('admin.get.navNested');
                Route::post('nav-nested/add/save', 'saveNavNested')->name('admin.save.navNested');
                Route::post('nav-nested/edit/update', 'updateNavNested')->name('admin.update.navNested');
                Route::post('nav-nested/edit/access', 'accessNavNested')->name('admin.access.navNested');
                Route::patch('nav-nested/status/{id?}', 'statusNavNested')->name('admin.status.navNested');
                Route::delete('nav-nested/delete/{id?}', 'deleteNavNested')->name('admin.delete.navNested');

                Route::get('arrange-nav', 'showArrangeNav')->name('admin.show.arrangeNav');
                Route::post('arrange-nav/edit/update', 'updateArrangeNav')->name('admin.update.arrangeNav');
            });
        });

        /*======== (-- Category & Attributes & Types --) ========*/
        Route::group(['prefix' => 'property-related'], function () {
            Route::controller(PropertyAttributeAdminController::class)->group(function () {
                Route::get('property-attribute', 'showPropertyAttribute')->name('admin.show.propertyAttribute');
                Route::get('property-attribute/ajaxGetList', 'getPropertyAttribute')->name('admin.get.propertyAttribute');
                Route::post('property-attribute/add/save', 'savePropertyAttribute')->name('admin.save.propertyAttribute');
                Route::post('property-attribute/edit/update', 'updatePropertyAttribute')->name('admin.update.propertyAttribute');
                Route::patch('property-attribute/default/{id?}', 'defaultPropertyAttribute')->name('admin.default.propertyAttribute');
                Route::patch('property-attribute/status/{id?}', 'statusPropertyAttribute')->name('admin.status.propertyAttribute');
                Route::delete('property-attribute/delete/{id?}', 'deletePropertyAttribute')->name('admin.delete.propertyAttribute');
            });

            Route::controller(PropertyTypeAdminController::class)->group(function () {
                Route::get('property-type', 'showPropertyType')->name('admin.show.propertyType');
                Route::get('property-type/ajaxGetList', 'getPropertyType')->name('admin.get.propertyType');
                Route::post('property-type/add/save', 'savePropertyType')->name('admin.save.propertyType');
                Route::post('property-type/edit/update', 'updatePropertyType')->name('admin.update.propertyType');
                Route::patch('property-type/default/{id?}', 'defaultPropertyType')->name('admin.default.propertyType');
                Route::patch('property-type/status/{id?}', 'statusPropertyType')->name('admin.status.propertyType');
                Route::delete('property-type/delete/{id?}', 'deletePropertyType')->name('admin.delete.propertyType');
            });

            Route::controller(ManageBroadAdminController::class)->prefix('manage-broad')->group(function () {
                Route::get('broad-type', 'showBroadType')->name('admin.show.broadType');
                Route::get('broad-type/ajaxGetList', 'getBroadType')->name('admin.get.broadType');
                Route::post('broad-type/add/save', 'saveBroadType')->name('admin.save.broadType');
                Route::post('broad-type/edit/update', 'updateBroadType')->name('admin.update.broadType');
                Route::patch('broad-type/status/{id?}', 'statusBroadType')->name('admin.status.broadType');
                Route::delete('broad-type/delete/{id?}', 'deleteBroadType')->name('admin.delete.broadType');

                Route::get('assign-broad', 'showAssignBroad')->name('admin.show.assignBroad');
                Route::get('assign-broad/ajaxGetList', 'getAssignBroad')->name('admin.get.assignBroad');
                Route::post('assign-broad/add/save', 'saveAssignBroad')->name('admin.save.assignBroad');
                Route::post('assign-broad/edit/update', 'updateAssignBroad')->name('admin.update.assignBroad');
                Route::patch('assign-broad/default/{id?}', 'defaultAssignBroad')->name('admin.default.assignBroad');
                Route::patch('assign-broad/status/{id?}', 'statusAssignBroad')->name('admin.status.assignBroad');
                Route::delete('assign-broad/delete/{id?}', 'deleteAssignBroad')->name('admin.delete.assignBroad');
            });

            Route::controller(PropertyCategoryAdminController::class)->prefix('property-category')->group(function () {
                Route::get('manage-category', 'showManageCategory')->name('admin.show.manageCategory');
                Route::get('manage-category/ajaxGetList/{type?}', 'getManageCategory')->name('admin.get.manageCategory');
                Route::post('manage-category/add/save', 'saveManageCategory')->name('admin.save.manageCategory');
                Route::post('manage-category/edit/update', 'updateManageCategory')->name('admin.update.manageCategory');
                Route::patch('manage-category/status/{id?}', 'statusManageCategory')->name('admin.status.manageCategory');
                Route::delete('manage-category/delete/{id?}', 'deleteManageCategory')->name('admin.delete.manageCategory');

                Route::get('assign-category', 'showAssignCategory')->name('admin.show.assignCategory');
                Route::get('assign-category/ajaxGetList', 'getAssignCategory')->name('admin.get.assignCategory');
                Route::post('assign-category/add/save', 'saveAssignCategory')->name('admin.save.assignCategory');
                Route::post('assign-category/edit/update', 'updateAssignCategory')->name('admin.update.assignCategory');
                Route::patch('assign-category/default/{id?}', 'defaultAssignCategory')->name('admin.default.assignCategory');
                Route::patch('assign-category/status/{id?}', 'statusAssignCategory')->name('admin.status.assignCategory');
                Route::delete('assign-category/delete/{id?}', 'deleteAssignCategory')->name('admin.delete.assignCategory');
            });
        });

        /*======== (-- Users Related --) ========*/
        Route::group(['prefix' => 'manage-users'], function () {
            Route::controller(AdminUsersAdminController::class)->group(function () {
                Route::get('admin-users', 'showAdminUsers')->name('admin.show.adminUsers');
                Route::get('admin-users/ajaxGetList', 'getAdminUsers')->name('admin.get.adminUsers');
                Route::get('admin-users/add', 'addAdminUsers')->name('admin.add.adminUsers');
                Route::post('admin-users/add/save', 'saveAdminUsers')->name('admin.save.adminUsers');
                Route::get('admin-users/edit/{id?}', 'editAdminUsers')->name('admin.edit.adminUsers');
                Route::post('admin-users/edit/update', 'updateAdminUsers')->name('admin.update.adminUsers');
                // Route::post('admin-users/edit/update', 'updateAdminUsers')->name('admin.update.adminUsers');
                Route::patch('admin-users/status/{id?}', 'statusAdminUsers')->name('admin.status.adminUsers');
                Route::delete('admin-users/delete/{id?}', 'deleteAdminUsers')->name('admin.delete.adminUsers');
            });
        });

        /*======== (-- DDDAdminController --) ========*/
        Route::controller(DDDAdminController::class)->prefix('ddd')->group(function () {
            Route::get('nav-main/{navTypeId?}', 'getNavMain')->name('admin.get.navMainDDD');
            Route::get('nav-sub/{navMainId?}', 'getNavSub')->name('admin.get.navSubDDD');
            Route::get('role-sub/{mainRoleId?}', 'getRoleSub')->name('admin.get.roleSubDDD');
            Route::get('assign-broad/{propertyTypeId?}', 'getAssignBroad')->name('admin.get.assignBroadDDD');
            Route::get('manage-category/{mainCategoryId?}', 'getMainCategory')->name('admin.get.mainCategoryDDD');
        });

        /*======== (-- Error Page --) ========*/
        // Route::get('admin/page/404', 'Admin\CommonController@show404')->name('404');
        // Route::get('admin/page/500', 'Admin\CommonController@show500')->name('500');
    });
});
