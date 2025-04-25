<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\AdminSetting\Nav\NavMain;

use App\Helpers\GetManageNavHelper;

use Exception;
use Illuminate\Support\Facades\Config;

class DDDAdminController extends Controller
{
    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*------ ( Get Nav Main ) -------*/
    public function getNavMain($navTypeId)
    {
        // try {
        $navMain = GetManageNavHelper::getList([
            [
                'getList' => [
                    'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                    'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                ],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => Config::get('constants.status')['active'],
                        'navTypeId' => $navTypeId,
                    ],
                    'orderBy' => [
                        'id' => 'desc'
                    ]
                ],
            ],
        ]);

        $data = [
            Config::get('constants.typeCheck.manageNav.navMain.type') => $navMain[Config::get('constants.typeCheck.manageNav.navMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
        ];

        if ($data) {
            return Response()->Json(['status' => 1, 'msg' => 'Nav main is found.', 'data' => $data], config('constants.ok'));
        } else {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
        // } catch (Exception $e) {
        //     return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        // }
    }

    /*------ ( Get Nav Sub ) -------*/
    public function getNavSub($navMainId)
    {
        try {
            $navSub = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navMainId' => $navMainId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                Config::get('constants.typeCheck.manageNav.navSub.type') => $navSub[Config::get('constants.typeCheck.manageNav.navSub.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
            ];

            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Nav sub is found.', 'data' => $data], config('constants.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}
