<?php

namespace App\Providers;

use App\Helpers\AdminRelated\NavigationAccess\ManageSideNavHelper;
use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;

use App\Models\Contact;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        view()->composer('*', function ($view) {
            $url = explode("/", url()->current());
            if (in_array('admin', $url)) {
                if (Auth::guard('admin')->check()) {
                    $navList = ManageSideNavHelper::getNav([
                        [
                            'type' => [Config::get('constants.typeCheck.helperCommon.nav.sn')],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => Config::get('constants.status')['active']
                                ],
                                'orderBy' => [
                                    'position' => 'asc'
                                ]
                            ],
                        ]
                    ])[Config::get('constants.typeCheck.helperCommon.nav.sn')];

                    $getPrivilege = ManagePermissionHelper::getPrivilege([
                        [
                            'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                            'otherDataPasses' => []
                        ]
                    ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

                    View::share('navList', $navList);
                    View::share('permission', $getPrivilege);
                }
            } else {
                $contact = Contact::first();
                View::share('contact', $contact);
            }
        });
    }

    public function boot(): void {}
}
