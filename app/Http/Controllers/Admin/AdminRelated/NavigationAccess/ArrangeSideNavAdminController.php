<?php

namespace App\Http\Controllers\Admin\AdminRelated\NavigationAccess;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\NavigationAccess\ManageSideNavHelper;
use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;

use App\Models\AdminRelated\NavigationAccess\ManageSideNav\MainNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NestedNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\SubNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NavType;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class ArrangeSideNavAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Arrange Sub Nav ) ----*/
    public function showArrangeSideNav()
    {
        try {
            $getNav = ManageSideNavHelper::getNav([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.nav.sn')],
                    'otherDataPasses' => [
                        'filterData' => ['status' => Config::get('constants.status')['active']],
                        'orderBy' => ['position' => 'asc']
                    ],
                ]
            ])[Config::get('constants.typeCheck.helperCommon.nav.sn')];

            $data = [
                'navList' => $getNav,
            ];

            return view('admin.admin_related.navigation_access.arrange_side_nav.arrange_side_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateArrangeSideNav(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('navType', 'mainNav', 'subNav', 'nestedNav');

        try {
            foreach ($values['navType'] as $key => $temp) {
                if (NavType::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }
            foreach ($values['mainNav'] as $key => $temp) {
                if (MainNav::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }
            foreach ($values['subNav'] as $key => $temp) {
                if (SubNav::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }
            foreach ($values['nestedNav'] as $key => $temp) {
                if (NestedNav::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }

            next:
            if ($response == true) {
                DB::commit();
                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                DB::roleBack();
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            DB::roleBack();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}
