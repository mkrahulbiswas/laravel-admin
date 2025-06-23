<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminRelated\NavigationAccess\ArrangeSideNavAdminController;
use App\Http\Controllers\Admin\AdminRelated\NavigationAccess\ManageSideNavAdminController;
use App\Http\Controllers\Admin\AdminRelated\QuickSettings\CustomizedAlertAdminController;
use App\Http\Controllers\Admin\AdminRelated\QuickSettings\SiteSettingAdminController;
use App\Http\Controllers\Admin\AdminRelated\RolePermission\ManageRoleAdminController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DDDAdminController;
use App\Http\Controllers\Admin\Dashboard\DashboardAdminController;
use App\Http\Controllers\Admin\PropertyRelated\ManageBroadAdminController;
use App\Http\Controllers\Admin\PropertyRelated\PropertyAttributeAdminController;
use App\Http\Controllers\Admin\PropertyRelated\PropertyCategoryAdminController;
use App\Http\Controllers\Admin\PropertyRelated\PropertyTypeAdminController;
use App\Http\Controllers\Admin\UsersRelated\ManageUsers\AdminUsersAdminController;
use App\Http\Middleware\CheckAdminMiddleware;
use App\Http\Middleware\CheckPermissionMiddleware;

Route::controller(AuthAdminController::class)->middleware(['logSiteVisitByMiddleware:admin'])->group(function () {
    Route::get('/', 'showLogin')->name('show.login');
    Route::post('check-login',  'checkLogin')->name('check.login');
    Route::post('forgot-Password/otp',  'saveForgotPassword')->name('save.forgotPassword');
    Route::post('reset-Password/reset',  'updateResetPassword')->name('update.resetPassword');
    Route::post('changePassword',  'changePasswordLogin');

    Route::middleware([CheckAdminMiddleware::class, CheckPermissionMiddleware::class])->group(function () {

        Route::post('logout',  'logout')->name('logout');

        Route::group(['prefix' => 'auth-profile'], function () {
            Route::get('/',  'showAuthProfile')->name('admin.show.authProfile');

            Route::get('edit',  'editAuthProfile')->name('admin.edit.authProfile');
            Route::post('edit/update',  'updateAuthProfile')->name('admin.update.authProfile');

            Route::post('change/password',  'changeAuthPassword')->name('admin.change.authPassword');
            Route::post('change/pin',  'changeAuthPin')->name('admin.change.authPin');
            Route::post('change/image',  'changeAuthImage')->name('admin.change.authImage');

            Route::post('change/send',  'changeAuthSend')->name('admin.change.authSend');
            Route::post('change/verify',  'changeAuthVerify')->name('admin.change.authVerify');
            Route::post('change/update',  'changeAuthUpdate')->name('admin.change.authUpdate');

            Route::post('reset/send',  'resetAuthSend')->name('admin.reset.authSend');
            Route::post('reset/verify',  'resetAuthVerify')->name('admin.reset.authVerify');
            Route::post('reset/update',  'resetAuthUpdate')->name('admin.reset.authUpdate');
        });

        /*======== (-- Dashboard Related --) ========*/
        Route::group(['prefix' => 'dashboard-related'], function () {
            Route::group(['prefix' => 'dashboard'], function () {
                Route::controller(DashboardAdminController::class)->group(function () {
                    Route::get('quick-overview', 'showQuickOverview')->name('admin.show.QuickOverview');
                    Route::get('charts-view', 'showChartsView')->name('admin.show.ChartsView');
                });
            });
        });

        /*======== (-- Admin Related --) ========*/
        Route::group(['prefix' => 'admin-related'], function () {
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

            Route::group(['prefix' => 'navigation-access'], function () {
                Route::controller(ManageSideNavAdminController::class)->prefix('manage-side-nav')->group(function () {
                    Route::get('nav-type', 'showNavType')->name('admin.show.navType');
                    Route::get('nav-type/ajaxGetList', 'getNavType')->name('admin.get.navType');
                    Route::post('nav-type/add/save', 'saveNavType')->name('admin.save.navType');
                    Route::post('nav-type/edit/update', 'updateNavType')->name('admin.update.navType');
                    Route::patch('nav-type/status/{id?}', 'statusNavType')->name('admin.status.navType');
                    Route::delete('nav-type/delete/{id?}', 'deleteNavType')->name('admin.delete.navType');

                    Route::get('main-nav', 'showMainNav')->name('admin.show.mainNav');
                    Route::get('main-nav/ajaxGetList', 'getMainNav')->name('admin.get.mainNav');
                    Route::post('main-nav/add/save', 'saveMainNav')->name('admin.save.mainNav');
                    Route::post('main-nav/edit/update', 'updateMainNav')->name('admin.update.mainNav');
                    Route::post('main-nav/edit/access', 'accessMainNav')->name('admin.access.mainNav');
                    Route::patch('main-nav/status/{id?}', 'statusMainNav')->name('admin.status.mainNav');
                    Route::delete('main-nav/delete/{id?}', 'deleteMainNav')->name('admin.delete.mainNav');

                    Route::get('sub-nav', 'showSubNav')->name('admin.show.subNav');
                    Route::get('sub-nav/ajaxGetList', 'getSubNav')->name('admin.get.subNav');
                    Route::post('sub-nav/add/save', 'saveSubNav')->name('admin.save.subNav');
                    Route::post('sub-nav/edit/update', 'updateSubNav')->name('admin.update.subNav');
                    Route::post('sub-nav/edit/access', 'accessSubNav')->name('admin.access.subNav');
                    Route::patch('sub-nav/status/{id?}', 'statusSubNav')->name('admin.status.subNav');
                    Route::delete('sub-nav/delete/{id?}', 'deleteSubNav')->name('admin.delete.subNav');

                    Route::get('nested-nav', 'showNestedNav')->name('admin.show.nestedNav');
                    Route::get('nested-nav/ajaxGetList', 'getNestedNav')->name('admin.get.nestedNav');
                    Route::post('nested-nav/add/save', 'saveNestedNav')->name('admin.save.nestedNav');
                    Route::post('nested-nav/edit/update', 'updateNestedNav')->name('admin.update.nestedNav');
                    Route::post('nested-nav/edit/access', 'accessNestedNav')->name('admin.access.nestedNav');
                    Route::patch('nested-nav/status/{id?}', 'statusNestedNav')->name('admin.status.nestedNav');
                    Route::delete('nested-nav/delete/{id?}', 'deleteNestedNav')->name('admin.delete.nestedNav');
                });

                Route::controller(ArrangeSideNavAdminController::class)->group(function () {
                    Route::get('arrange-side-nav', 'showArrangeSideNav')->name('admin.show.arrangeSideNav');
                    Route::post('arrange-side-nav/edit/update', 'updateArrangeSideNav')->name('admin.update.arrangeSideNav');
                });
            });

            Route::prefix('quick-setting')->group(function () {
                Route::controller(SiteSettingAdminController::class)->prefix('site-setting')->group(function () {
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
                Route::controller(CustomizedAlertAdminController::class)->prefix('customized-alert')->group(function () {
                    Route::get('alert-type', 'showAlertType')->name('admin.show.alertType');
                    Route::get('alert-type/ajaxGetList', 'getAlertType')->name('admin.get.alertType');
                    Route::post('alert-type/add/save', 'saveAlertType')->name('admin.save.alertType');
                    Route::post('alert-type/edit/update', 'updateAlertType')->name('admin.update.alertType');
                    Route::patch('alert-type/status/{id?}', 'statusAlertType')->name('admin.status.alertType');
                    Route::delete('alert-type/delete/{id?}', 'deleteAlertType')->name('admin.delete.alertType');

                    Route::get('alert-for', 'showAlertFor')->name('admin.show.alertFor');
                    Route::get('alert-for/ajaxGetList', 'getAlertFor')->name('admin.get.alertFor');
                    Route::post('alert-for/add/save', 'saveAlertFor')->name('admin.save.alertFor');
                    Route::post('alert-for/edit/update', 'updateAlertFor')->name('admin.update.alertFor');
                    Route::patch('alert-for/status/{id?}', 'statusAlertFor')->name('admin.status.alertFor');
                    Route::delete('alert-for/delete/{id?}', 'deleteAlertFor')->name('admin.delete.alertFor');

                    Route::get('alert-template', 'showAlertTemplate')->name('admin.show.alertTemplate');
                    Route::get('alert-template/ajaxGetList', 'getAlertTemplate')->name('admin.get.alertTemplate');
                    Route::post('alert-template/add/save', 'saveAlertTemplate')->name('admin.save.alertTemplate');
                    Route::post('alert-template/edit/update', 'updateAlertTemplate')->name('admin.update.alertTemplate');
                    Route::patch('alert-template/default/{id?}', 'defaultAlertTemplate')->name('admin.default.alertTemplate');
                    Route::delete('alert-template/delete/{id?}', 'deleteAlertTemplate')->name('admin.delete.alertTemplate');
                });
            });
        });

        /*======== (-- Category & Attributes & Types --) ========*/
        Route::group(['prefix' => 'category-attributes-type'], function () {
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
        });

        /*======== (-- Users Related --) ========*/
        Route::group(['prefix' => 'users-related'], function () {
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
        });

        /*======== (-- DDDAdminController --) ========*/
        Route::controller(DDDAdminController::class)->prefix('ddd')->group(function () {
            Route::get('main-nav/{navTypeId?}', 'getMainNav')->name('admin.get.mainNavDDD');
            Route::get('sub-nav/{mainNavId?}', 'getSubNav')->name('admin.get.subNavDDD');
            Route::get('sub-role/{mainRoleId?}', 'getSubRole')->name('admin.get.subRoleDDD');
            Route::get('assign-broad/{propertyTypeId?}', 'getAssignBroad')->name('admin.get.assignBroadDDD');
            Route::get('manage-category/{mainCategoryId?}', 'getMainCategory')->name('admin.get.mainCategoryDDD');
            Route::get('alert-for/{alertTypeId?}', 'getAlertFor')->name('admin.get.alertForDDD');
        });

        /*======== (-- Error Page --) ========*/
        // Route::get('admin/page/404', 'Admin\CommonController@show404')->name('404');
        // Route::get('admin/page/500', 'Admin\CommonController@show500')->name('500');
    });
});
