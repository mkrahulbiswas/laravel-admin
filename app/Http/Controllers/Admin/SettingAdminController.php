<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Admin;
use App\Models\SocialLinks;
use App\Models\Logo;
use App\Models\Units;

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SettingAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';

    /*---- ( Email Template ) ----*/
    // public function showEmailTemplate()
    // {
    //     try {
    //         return view('admin.setting.email_template.email_template_list');
    //     } catch (Exception $e) {
    //         abort(500);
    //     }
    // }

    // public function getEmailTemplate(Request $request)
    // {
    //     try {
    //         $emailTemplate = EmailTemplate::orderBy('order', 'asc')->get();

    //         return Datatables::of($emailTemplate)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($data) {

    //                 $itemPermission = $this->itemPermission([
    //                     'rolePermission' => RolePermission::class,
    //                     'subMenu' => SubMenu::class,
    //                 ]);

    //                 $dataArray = [
    //                     'id' => encrypt($data->_id),
    //                     'subject' => $data->subject,
    //                     'content' => $data->content,
    //                     'variable' => $data->variable,
    //                     'isFile' => ($data->file == 'NA') ? 0 : 1,
    //                     'file' => $this->picUrl($data->file, 'mailDoc', $this->platform),
    //                 ];

    //                 if ($itemPermission['edit_item'] == '1') {
    //                     $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
    //                 } else {
    //                     $edit = '';
    //                 }

    //                 if ($itemPermission['details_item'] == '1') {
    //                     $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="actionDatatable"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
    //                 } else {
    //                     $details = '';
    //                 }

    //                 return $edit . ' ' . $details;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     } catch (Exception $e) {
    //         return redirect()->back()->with('error', 'Something went wrong.');
    //     }
    // }

    // public function updateEmailTemplate(Request $request)
    // {
    //     $values = $request->only('id', 'subject', 'content');
    //     $file = $request->file('file');

    //     try {
    //         $id = decrypt($values['id']);
    //     } catch (DecryptException $e) {
    //         return redirect()->back()->with('error', 'Something went wrong.');
    //     }

    //     try {

    //         $validator = $this->isValid($request->all(), 'updateEmailTemplate', 0, $this->platform);
    //         if ($validator->fails()) {
    //             return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
    //         } else {

    //             $emailTemplate = EmailTemplate::where('_id', $id)->first();

    //             if (!empty($file)) {
    //                 $file = $this->uploadPicture($file, $emailTemplate->file, $this->platform, 'mailDoc');
    //                 if ($file === false) {
    //                     return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
    //                 } else {
    //                     $emailTemplate->file = $file;
    //                 }
    //             }

    //             $emailTemplate->subject = $values['subject'];
    //             $emailTemplate->content = $values['content'];
    //             // $siteSetting->email = $values['email'];

    //             if ($emailTemplate->update()) {
    //                 return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Email Template", 'msg' => 'Email Template updated successfully.'], config('constants.ok'));
    //             } else {
    //                 return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Email Template", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
    //             }
    //         }
    //     } catch (Exception $e) {
    //         return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Email Template", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
    //     }
    // }


    /*---- ( Site Setting ) ----*/
    // public function showSiteSetting()
    // {
    //     try {
    //         $siteSetting = SiteSetting::first();

    //         $logo = array(
    //             'bigLogo' => $this->picUrl($siteSetting->bigLogo, 'bigLogoPic', $this->platform),
    //             'smallLogo' => $this->picUrl($siteSetting->smallLogo, 'smallLogoPic', $this->platform),
    //             'favIcon' => $this->picUrl($siteSetting->favIcon, 'favIconPic', $this->platform),
    //         );

    //         $contact = array(
    //             'phone' => $siteSetting->phone,
    //             'email' => $siteSetting->email,
    //         );

    //         $footer = array(
    //             'copyRight' => $siteSetting->copyRight,
    //         );

    //         $metaData = array(
    //             'metaTag' => $siteSetting->metaTag,
    //             'metaTitle' => $siteSetting->metaTitle,
    //             'metaKeyword' => $siteSetting->metaKeyword,
    //             'metaDescription' => $siteSetting->metaDescription,
    //         );

    //         $data = array(
    //             'id' => encrypt($siteSetting->_id),
    //             'logo' => $logo,
    //             'contact' => $contact,
    //             'footer' => $footer,
    //             'metaData' => $metaData,
    //         );

    //         return view('admin.setting.site_setting.site_setting_list', ['data' => $data]);
    //     } catch (Exception $e) {
    //         abort(500);
    //     }
    // }

    // public function updateSiteSetting(Request $request)
    // {
    //     $values = $request->only('id', 'copyRight', 'phone', 'email', 'metaTag', 'metaTitle', 'metaKeyword', 'metaDescription');
    //     $bigLogo = $request->file('bigLogo');
    //     $smallLogo = $request->file('smallLogo');
    //     $favIcon = $request->file('favIcon');

    //     try {
    //         $id = decrypt($values['id']);
    //     } catch (DecryptException $e) {
    //         return redirect()->back()->with('error', 'Something went wrong.');
    //     }

    //     try {

    //         $validator = $this->isValid($request->all(), 'updateSiteSetting', 0, $this->platform);
    //         if ($validator->fails()) {
    //             return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
    //         } else {

    //             $siteSetting = SiteSetting::where('_id', $id)->first();

    //             if (!empty($bigLogo)) {
    //                 $image = $this->uploadPicture($bigLogo, $siteSetting->bigLogo, $this->platform, 'bigLogoPic');
    //                 if ($image === false) {
    //                     return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
    //                 } else {
    //                     $siteSetting->bigLogo = $image;
    //                 }
    //             }

    //             if (!empty($smallLogo)) {
    //                 $image = $this->uploadPicture($smallLogo, $siteSetting->smallLogo, $this->platform, 'smallLogoPic');
    //                 if ($image === false) {
    //                     return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
    //                 } else {
    //                     $siteSetting->smallLogo = $image;
    //                 }
    //             }

    //             if (!empty($favIcon)) {
    //                 $image = $this->uploadPicture($favIcon, $siteSetting->favIcon, $this->platform, 'favIconPic');
    //                 if ($image === false) {
    //                     return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
    //                 } else {
    //                     $siteSetting->favIcon = $image;
    //                 }
    //             }

    //             $siteSetting->copyRight = $values['copyRight'];
    //             $siteSetting->phone = $values['phone'];
    //             $siteSetting->email = $values['email'];
    //             $siteSetting->metaTag = $values['metaTag'];
    //             $siteSetting->metaTitle = $values['metaTitle'];
    //             $siteSetting->metaKeyword = $values['metaKeyword'];
    //             $siteSetting->metaDescription = $values['metaDescription'];

    //             if ($siteSetting->update()) {
    //                 return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Site Setting", 'msg' => 'Site setting updated successfully.'], config('constants.ok'));
    //             } else {
    //                 return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Site Setting", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
    //             }
    //         }
    //     } catch (Exception $e) {
    //         return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Site Setting", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
    //     }
    // }


    /*---- ( Social Links ) ----*/
    public function showSocialLinks()
    {
        try {
            return view('admin.setting.social_links.social_links_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getSocialLinks(Request $request)
    {
        try {
            $for = $request->for;

            $query = "`created_at` is not null";

            if (!empty($for)) {
                $query .= " and `for` = '" . $for . "'";
            }

            $socialLinks = SocialLinks::orderBy('id', 'desc')->get();
            // $banner = Banner::whereRaw($query)->orderBy('id', 'desc')->get();

            return Datatables::of($socialLinks)
                ->addIndexColumn()
                ->addColumn('icon', function ($data) {
                    $banner = '<i class="' . $data->icon . '" style="font-size: 20px;"></i>';
                    return $banner;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        $status = '<span class="label label-danger">Inactive</span>';
                    } else {
                        $status = '<span class="label label-success">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($data) {

                    $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'title' => $data->title,
                        'icon' => $data->icon,
                        'link' => $data->link,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.socialLinks') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.socialLinks') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.socialLinks') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete;
                })
                ->rawColumns(['icon', 'status', 'image', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveSocialLinks(Request $request)
    {
        try {
            $values = $request->only('title', 'icon', 'link');

            $validator = $this->isValid($request->all(), 'saveSocialLinks', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $socialLinks = new SocialLinks;
                $socialLinks->title = $values['title'];
                $socialLinks->icon = $values['icon'];
                $socialLinks->link = $values['link'];
                $socialLinks->status = config('constants.status')['1'];

                if ($socialLinks->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Social Links", 'msg' => 'Social Links Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Social Links", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Social Links", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateSocialLinks(Request $request)
    {
        $values = $request->only('id', 'title', 'icon', 'link');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateSocialLinks', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $socialLinks = SocialLinks::find($id);

                $socialLinks->title = $values['title'];
                $socialLinks->icon = $values['icon'];
                $socialLinks->link = $values['link'];

                if ($socialLinks->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Social Links", 'msg' => 'Social Links Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Social Links", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Social Links", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusSocialLinks($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, SocialLinks::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteSocialLinks($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, SocialLinks::class, '');
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Logo ) ----*/
    public function showLogo()
    {
        try {
            return view('admin.setting.logo.logo_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function ajaxGetLogo()
    {
        try {
            $logo = Logo::orderBy('id', 'desc')->select('id', 'bigLogo', 'smallLogo', 'favIcon', 'status');

            return Datatables::of($logo)
                ->addIndexColumn()
                ->addColumn('bigLogo', function ($data) {
                    $bigLogo = '<img src="' . $this->picUrl($data->bigLogo, 'bigLogoPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                    return $bigLogo;
                })
                ->addColumn('smallLogo', function ($data) {
                    $smallLogo = '<img src="' . $this->picUrl($data->smallLogo, 'smallLogoPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                    return $smallLogo;
                })
                ->addColumn('favIcon', function ($data) {
                    $favIcon = '<img src="' . $this->picUrl($data->favIcon, 'favIconPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                    return $favIcon;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        $status = '<span class="label label-danger">Blocked</span>';
                    } else {
                        $status = '<span class="label label-success">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($data) {

                    $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'bigLogo' => $this->picUrl($data->bigLogo, 'bigLogoPic', $this->platform),
                        'smallLogo' => $this->picUrl($data->smallLogo, 'smallLogoPic', $this->platform),
                        'favIcon' => $this->picUrl($data->favIcon, 'favIconPic', $this->platform)
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.logo') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.logo') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.logo') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete;
                })
                ->rawColumns(['bigLogo', 'smallLogo', 'favIcon', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveLogo(Request $request)
    {
        try {
            $bigLogo = $request->file('bigLogo');
            $smallLogo = $request->file('smallLogo');
            $favIcon = $request->file('favIcon');
            //--Checking The Validation--//

            $validator = $this->isValid($request->all(), 'saveLogo', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'msg' => config('constants.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                //--Insert Banner--//
                if (!empty($bigLogo)) {
                    $bigLogo = $this->uploadPicture($bigLogo, '', $this->platform, 'bigLogoPic');
                    if ($bigLogo === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $bigLogo = "NA";
                }

                if (!empty($smallLogo)) {
                    $smallLogo = $this->uploadPicture($smallLogo, '', $this->platform, 'smallLogoPic');
                    if ($smallLogo === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $smallLogo = "NA";
                }

                if (!empty($favIcon)) {
                    $favIcon = $this->uploadPicture($favIcon, '', $this->platform, 'favIconPic');
                    if ($favIcon === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $favIcon = "NA";
                }

                $logo = new Logo;
                $logo->bigLogo = $bigLogo;
                $logo->smallLogo = $smallLogo;
                $logo->favIcon = $favIcon;

                if ($logo->save()) {
                    return Response()->Json(['status' => 1, 'msg' => 'Logo Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateLogo(Request $request)
    {
        $values = $request->only('id');
        $bigLogo = $request->file('bigLogo');
        $smallLogo = $request->file('smallLogo');
        $favIcon = $request->file('favIcon');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateLogo', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'msg' => config('constants.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $logo = Logo::find($id);

                if (!empty($bigLogo)) {
                    $image = $this->uploadPicture($bigLogo, $logo->bigLogo, $this->platform, 'bigLogoPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    } else {
                        $logo->bigLogo = $image;
                    }
                }

                if (!empty($smallLogo)) {
                    $image = $this->uploadPicture($smallLogo, $logo->smallLogo, $this->platform, 'smallLogoPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    } else {
                        $logo->smallLogo = $image;
                    }
                }

                if (!empty($favIcon)) {
                    $image = $this->uploadPicture($favIcon, $logo->favIcon, $this->platform, 'favIconPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    } else {
                        $logo->favIcon = $image;
                    }
                }

                if ($logo->update()) {
                    return Response()->Json(['status' => 1, 'msg' => 'Logo Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusLogo($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $logo = Logo::find($id);
            if ($logo->status == '1') {
                return Response()->Json(['status' => 0, 'msg' => 'You cant change the status of this active logo'], config('constants.ok'));
            } else {
                foreach (Logo::get() as $temp) {
                    $logo = Logo::find($temp->id);
                    $logo->status = '0';
                    $logo->update();
                }

                $result = $this->changeStatus($id, Logo::class, [], config('constants.statusSingle'));
                if ($result === true) {
                    return response()->Json(['status' => 1, 'msg' => 'Status successfully changed.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteLogo($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $logo = Logo::find($id);
            if ($logo->status == '1') {
                return Response()->Json(['status' => 0, 'msg' => 'You cant delete this active logo'], config('constants.ok'));
            } else {
                if ($logo->bigLogo != 'NA') {
                    unlink(config('constants.bigLogoPic') . $logo->bigLogo);
                }
                if ($logo->smallLogo != 'NA') {
                    unlink(config('constants.smallLogoPic') . $logo->smallLogo);
                }
                if ($logo->favIcon != 'NA') {
                    unlink(config('constants.favIconPic') . $logo->favIcon);
                }
                if ($logo->delete()) {
                    return response()->Json(['status' => 1, 'msg' => 'Successfully logo Deleted.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Units ) ----*/
    public function showUnits()
    {
        try {
            return view('admin.setting.units.units_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getUnits()
    {
        try {
            $units = Units::orderBy('id', 'desc')->select('id', 'name', 'status');

            return Datatables::of($units)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        $status = '<span class="label label-danger">Blocked</span>';
                    } else {
                        $status = '<span class="label label-success">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($data) {

                    $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'name' => $data->name,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.units') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.units') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.units') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete;
                })
                ->rawColumns(['question', 'answer', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveUnits(Request $request)
    {
        try {
            $values = $request->only('name');
            //--Checking The Validation--//

            $validator = $this->isValid($request->all(), 'saveUnits', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $units = new Units;
                $units->name = $values['name'];

                if ($units->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Units", 'msg' => 'Units Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Units", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Units", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateUnits(Request $request)
    {
        $values = $request->only('id', 'name');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Units", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateUnits', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $units = Units::find($id);

                $units->name = $values['name'];

                if ($units->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Units", 'msg' => 'Units Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Units", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Units", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusUnits($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Units::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteUnits($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, Units::class, '');
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}
