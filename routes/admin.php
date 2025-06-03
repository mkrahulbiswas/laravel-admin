<?php

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
        Route::group(['prefix' => 'manage-panel'], function () {
            Route::controller(QuickSettingsAdminController::class)->prefix('quick-settings')->group(function () {
                Route::get('logo', 'showLogo')->name('admin.show.logo');
                Route::get('logo/ajaxGetList', 'getLogo')->name('admin.get.logo');
                Route::post('logo/add/save', 'saveLogo')->name('admin.save.logo');
                Route::post('logo/edit/update', 'updateLogo')->name('admin.update.logo');
                Route::patch('logo/default/{id?}', 'defaultLogo')->name('admin.default.logo');
                Route::delete('logo/delete/{id?}', 'deleteLogo')->name('admin.delete.logo');

                Route::get('templates', 'showTemplates')->name('admin.show.templates');
                Route::get('templates/ajaxGetList', 'getTemplates')->name('admin.get.templates');
                Route::post('templates/add/save', 'saveTemplates')->name('admin.save.templates');
                Route::post('templates/edit/update', 'updateTemplates')->name('admin.update.templates');
                Route::patch('templates/status/{id?}', 'statusTemplates')->name('admin.status.templates');
                Route::delete('templates/delete/{id?}', 'deleteTemplates')->name('admin.delete.templates');
            });

            Route::controller(ManageAccessAdminController::class)->prefix('mange-access')->group(function () {
                Route::get('role-main', 'showRoleMain')->name('admin.show.roleMain');
                Route::get('role-main/ajaxGetList', 'getRoleMain')->name('admin.get.roleMain');
                Route::post('role-main/add/save', 'saveRoleMain')->name('admin.save.roleMain');
                Route::post('role-main/edit/update', 'updateRoleMain')->name('admin.update.roleMain');
                Route::patch('role-main/permission/{id?}', 'permissionRoleMain')->name('admin.permission.roleMain');
                Route::patch('role-main/status/{id?}', 'statusRoleMain')->name('admin.status.roleMain');
                Route::delete('role-main/delete/{id?}', 'deleteRoleMain')->name('admin.delete.roleMain');
                Route::group(['prefix' => 'role-main'], function () {
                    Route::get('permission/{roleMainId?}', 'showPermissionRoleMain')->name('admin.show.permissionRoleMain');
                    Route::get('permission/role-main/ajaxGetList/{roleMainId?}', 'getPermissionRoleMain')->name('admin.get.permissionRoleMain');
                    Route::post('permission/update', 'updatePermissionRoleMain')->name('admin.update.permissionRoleMain');
                });

                Route::get('role-sub', 'showRoleSub')->name('admin.show.roleSub');
                Route::get('role-sub/ajaxGetList', 'getRoleSub')->name('admin.get.roleSub');
                Route::post('role-sub/add/save', 'saveRoleSub')->name('admin.save.roleSub');
                Route::post('role-sub/edit/update', 'updateRoleSub')->name('admin.update.roleSub');
                Route::patch('role-sub/permission/{id?}', 'permissionRoleSub')->name('admin.permission.roleSub');
                Route::patch('role-sub/status/{id?}', 'statusRoleSub')->name('admin.status.roleSub');
                Route::delete('role-sub/delete/{id?}', 'deleteRoleSub')->name('admin.delete.roleSub');
                Route::group(['prefix' => 'role-sub'], function () {
                    Route::get('permission/{roleSubId?}', 'showPermissionRoleSub')->name('admin.show.permissionRoleSub');
                    Route::get('permission/role-sub/ajaxGetList/{roleSubId?}', 'getPermissionRoleSub')->name('admin.get.permissionRoleSub');
                    Route::post('permission/update', 'updatePermissionRoleSub')->name('admin.update.permissionRoleSub');
                });

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
            Route::get('role-sub/{roleMainId?}', 'getRoleSub')->name('admin.get.roleSubDDD');
        });

        /*======== (-- Error Page --) ========*/
        // Route::get('admin/page/404', 'Admin\CommonController@show404')->name('404');
        // Route::get('admin/page/500', 'Admin\CommonController@show500')->name('500');
    });
});
