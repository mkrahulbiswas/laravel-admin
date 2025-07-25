<?php

namespace App\Http\Controllers;

use App\Helpers\UsersRelated\ManageUsers\ManageUsersHelper;

use App\Models\AdminRelated\QuickSetting\SiteSetting\Logo;
use App\Models\CustomizeAdmin\CustomizeButton;
use App\Models\CustomizeAdmin\CustomizeTable;
use App\Models\CustomizeAdmin\Loader;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileTrait, CommonTrait;
    public $platform = 'backend';

    public function __construct()
    {
        $url = url()->current();
        $data = explode('/', $url);

        if (in_array("admin", $data)) {
            $customizeButton = array();
            $customizeTable = array();
            $admin = array();

            foreach (CustomizeButton::where('status', '1')->get() as $temp) {
                $customizeButton[] = array(
                    'backColor' => $temp->backColor,
                    'textColor' => $temp->textColor,
                    'backHoverColor' => $temp->backHoverColor,
                    'textHoverColor' => $temp->textHoverColor,
                    'btnIcon' => $temp->btnIcon,
                    'btnFor' => $temp->btnFor
                );
            }

            $customizeTable = CustomizeTable::where('status', '1')->first();
            $customizeTable = array(
                'headBackColor' => $customizeTable->headBackColor,
                'headTextColor' => $customizeTable->headTextColor,
                'headHoverBackColor' => $customizeTable->headHoverBackColor,
                'headHoverTextColor' => $customizeTable->headHoverTextColor,
                'bodyBackColor' => $customizeTable->bodyBackColor,
                'bodyTextColor' => $customizeTable->bodyTextColor,
                'bodyHoverBackColor' => $customizeTable->bodyHoverBackColor,
                'bodyHoverTextColor' => $customizeTable->bodyHoverTextColor,
                'headTableStyle' => json_decode($customizeTable->headTableStyle),
                'bodyTableStyle' => json_decode($customizeTable->bodyTableStyle),
            );


            $pageLoader = Loader::where('pageLoader', '1')->first();
            $pageLoaderData = array(
                'raw' => json_decode($pageLoader->raw),
                'loaderType' => $pageLoader->loaderType,
            );

            $internalLoader = Loader::where('internalLoader', '1')->first();
            $internalLoaderData = array(
                'raw' => json_decode($internalLoader->raw),
                'loaderType' => $internalLoader->loaderType,
            );

            $loader = array(
                'pageLoader' => $pageLoaderData,
                'internalLoader' => $internalLoaderData,
            );

            if (Auth::guard('admin')->check()) {
                $admin = ManageUsersHelper::getDetail([
                    [
                        'getDetail' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                            'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type'),
                        ],
                        'otherDataPasses' => [
                            'id' => encrypt(Auth::guard('admin')->user()->id)
                        ]
                    ],
                ])[Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
            }

            $logo = Logo::where('default', Config::get('constants.status.yes'))->first();

            $data = array(
                'appName' => str_replace('_', ' ', config('app.name')),
                'bigLogo' => FileTrait::getFile([
                    'fileName' => $logo->bigLogo,
                    'storage' => Config::get('constants.storage')['bigLogo']
                ])['public']['fullPath']['asset'],
                'smallLogo' => FileTrait::getFile([
                    'fileName' => $logo->smallLogo,
                    'storage' => Config::get('constants.storage')['smallLogo']
                ])['public']['fullPath']['asset'],
                'favIcon' => FileTrait::getFile([
                    'fileName' => $logo->favicon,
                    'storage' => Config::get('constants.storage')['favicon']
                ])['public']['fullPath']['asset'],
                'customizeButton' => $customizeButton,
                'customizeTable' => $customizeTable,
                'customizeLoader' => $loader,
                'adminInfo' => $admin
            );

            View::share('reqData', $data);
        }
    }
}
