<?php

namespace App\Providers;

use App\Helpers\GetManageNavHelper;

use App\Models\Contact;

use Illuminate\Support\Facades\DB;
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
            $url = url()->current();
            $url = explode("/", $url);
            if (in_array('admin', $url)) {
                if (Auth::guard('admin')->check()) {
                    // $role_id = Auth::guard('admin')->user()->role_id;

                    // $navList = $nav1 = $nav2 = $nav3 = [];
                    // $navType = GetManageNavHelper::getList([
                    //     'type' => [Config::get('constants.typeCheck.manageNav.navType.type')],
                    //     'otherDataPasses' => [
                    //         'filterData' => [
                    //             'status' => Config::get('constants.status')['active']
                    //         ],
                    //         'orderBy' => [
                    //             'position' => 'asc'
                    //         ]
                    //     ],
                    // ])['navType']['navType'];
                    // foreach ($navType as $keyOne => $tempOne) {
                    //     $navMain = GetManageNavHelper::getList([
                    //         'type' => [Config::get('constants.typeCheck.manageNav.navMain.type')],
                    //         'otherDataPasses' => [
                    //             'filterData' => [
                    //                 'status' => Config::get('constants.status')['active'],
                    //                 'navTypeId' => $tempOne['id'],
                    //             ],
                    //             'orderBy' => [
                    //                 'position' => 'asc'
                    //             ]
                    //         ],
                    //     ])['navMain']['navMain'];
                    //     if (sizeof($navMain) > 0) {
                    //         foreach ($navMain as $keyTwo => $tempTwo) {
                    //             $navSub = GetManageNavHelper::getList([
                    //                 'type' => [Config::get('constants.typeCheck.manageNav.navSub.type')],
                    //                 'otherDataPasses' => [
                    //                     'filterData' => [
                    //                         'status' => Config::get('constants.status')['active'],
                    //                         'navMainId' => $tempTwo['id'],
                    //                     ],
                    //                     'orderBy' => [
                    //                         'position' => 'asc'
                    //                     ]
                    //                 ],
                    //             ])['navSub']['navSub'];
                    //             if (sizeof($navSub) > 0) {
                    //                 foreach ($navSub as $keyThree => $tempThree) {
                    //                     $navNested = GetManageNavHelper::getList([
                    //                         'type' => [Config::get('constants.typeCheck.manageNav.navNested.type')],
                    //                         'otherDataPasses' => [
                    //                             'filterData' => [
                    //                                 'status' => Config::get('constants.status')['active'],
                    //                                 'navSubId' => $tempThree['id'],
                    //                             ],
                    //                             'orderBy' => [
                    //                                 'position' => 'asc'
                    //                             ]
                    //                         ],
                    //                     ])['navNested']['navNested'];
                    //                     if (sizeof($navNested) > 0) {
                    //                         foreach ($navNested as $keyFour => $tempFour) {
                    //                             $nav3[] = [
                    //                                 'name' => $tempFour['name'],
                    //                                 'icon' => $tempFour['icon'],
                    //                                 'route' => $tempFour['route'],
                    //                                 'uniqueId' => $tempFour['uniqueId']['raw'],
                    //                             ];
                    //                         }
                    //                     } else {
                    //                         $nav3 = [];
                    //                     }
                    //                     $nav2[] = [
                    //                         'name' => $tempThree['name'],
                    //                         'icon' => $tempThree['icon'],
                    //                         'route' => $tempThree['route'],
                    //                         'uniqueId' => $tempThree['uniqueId']['raw'],
                    //                         'navNested' => $nav3,
                    //                     ];
                    //                     $nav3 = [];
                    //                 }
                    //             } else {
                    //                 $nav2 = [];
                    //             }
                    //             $nav1[] = [
                    //                 'name' => $tempTwo['name'],
                    //                 'icon' => $tempTwo['icon'],
                    //                 'route' => $tempTwo['route'],
                    //                 'uniqueId' => $tempTwo['uniqueId']['raw'],
                    //                 'navSub' => $nav2,
                    //             ];
                    //             $nav2 = [];
                    //         }
                    //     } else {
                    //         $nav1 = [];
                    //     }
                    //     $navList[] = [
                    //         'name' => $tempOne['name'],
                    //         'icon' => $tempOne['icon'],
                    //         'uniqueId' => $tempOne['uniqueId']['raw'],
                    //         'navMain' => $nav1
                    //     ];
                    //     $nav1 = [];
                    // }

                    $navList = GetManageNavHelper::getNav([
                        'type' => ['all'],
                        'otherDataPasses' => [
                            'filterData' => [
                                'status' => Config::get('constants.status')['active']
                            ],
                            'orderBy' => [
                                'position' => 'asc'
                            ]
                        ],
                    ])['all'];
                    // dd($navList);










                    // $mainMenu = DB::table('module')
                    //     ->join('role_permission', 'role_permission.module_id', '=', 'module.id')
                    //     ->distinct()
                    //     ->select('module.*')
                    //     ->where('role_permission.role_id', $role_id)
                    //     ->where('role_permission.module_access', 1)
                    //     ->where('module.status', '1')
                    //     ->orderBy('module.orders', 'asc')
                    //     ->get();

                    //print_r($modules); exit();

                    // $subMenu = DB::table('sub_module')
                    //     ->join('role_permission', 'role_permission.sub_module_id', '=', 'sub_module.id')
                    //     ->select('sub_module.*')
                    //     ->where('role_permission.role_id', $role_id)
                    //     ->where('role_permission.sub_module_access', 1)
                    //     ->where('sub_module.status', '1')
                    //     ->orderBy('sub_module.orders', 'asc')
                    //     ->get();

                    // $subModuleGroup = SubMenu::groupBy('module_id')->select(DB::raw('count(name) as count,module_id'))->get();

                    // $adminDetails = DB::table('admins')
                    //     ->join('role', 'role.id', '=', 'admins.role_id')
                    //     ->select('admins.*', 'role.role')
                    //     ->where('admins.id', Auth::guard('admin')->user()->id)
                    //     ->first();


                    // $itemPermission = DB::table('role_permission')
                    //     ->join('sub_module', 'sub_module.id', '=', 'role_permission.sub_module_id')
                    //     ->select('role_permission.*', 'sub_module.last_segment')
                    //     ->where('role_permission.role_id', $role_id)
                    //     ->where('role_permission.sub_module_access', '1')
                    //     ->get();


                    // foreach ($itemPermission as $temp) {
                    //     if (in_array($temp->last_segment, $url)) {
                    //         $permission = array("add_item" => $temp->add_item, "edit_item" => $temp->edit_item, "details_item" => $temp->details_item, "delete_item" => $temp->delete_item, "status_item" => $temp->status_item, "other_item" => $temp->other_item);
                    //         goto a;
                    //     } else {
                    //         $permission = array(
                    //             "add_item" => '0',
                    //             "edit_item" => '0',
                    //             "details_item" => '0',
                    //             "delete_item" => 0,
                    //             "status_item" => 0,
                    //             "other_item" => 0
                    //         );
                    //     }
                    // }

                    a:
                    // $permission = array(
                    //     "add_item" => '1',
                    //     "edit_item" => '1',
                    //     "details_item" => '1',
                    //     "delete_item" => '1',
                    //     "status_item" => '1',
                    //     "other_item" => '1'
                    // );

                    View::share('navList', $navList);
                    // View::share('mainMenu', $mainMenu);
                    // View::share('subMenu', $subMenu);
                    // View::share('subModuleGroup', $subModuleGroup);
                    // View::share('adminDetails', $adminDetails);
                    // View::share('itemPermission', $permission);
                }
            } else {
                $contact = Contact::first();
                View::share('contact', $contact);
            }
        });
    }

    public function boot(): void {}
}
