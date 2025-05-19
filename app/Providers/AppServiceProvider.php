<?php

namespace App\Providers;

use App\Helpers\GetManageAccessHelper;
use App\Helpers\GetManageNavHelper;

use App\Models\Contact;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            $url = explode("/", url()->current());
            if (in_array('admin', $url)) {
                if (Auth::guard('admin')->check()) {
                    $navList = GetManageNavHelper::getNav([
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

                    $getPrivilege = GetManageAccessHelper::getPrivilege([
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
