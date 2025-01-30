<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Banner;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use App\Models\Faq;
use App\Models\ContactUs;
use App\Models\ContactEnquiry;
use App\Models\ReturnRefund;
use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CmsAdminController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'backend';


    /*---- ( Banner ) ----*/
    public function showBanner()
    {
        try {
            return view('admin.cms.banner.banner_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getBanner(Request $request)
    {
        try {
            $for = $request->for;

            $query = "`created_at` is not null";

            if (!empty($for)) {
                $query .= " and `for` = '" . $for . "'";
            }

            $banner = Banner::whereRaw($query)->orderBy('id', 'desc')->select('id', 'image', 'for', 'status')->get();

            return Datatables::of($banner)
                ->addIndexColumn()
                ->addColumn('banner', function ($data) {
                    $banner = '<img src="' . $this->picUrl($data->image, 'bannerPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                    return $banner;
                })
                ->addColumn('for', function ($data) {
                    $for = Str::replace('_', ' ', $data->for);
                    return $for;
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
                        'for' => $data->for,
                        'image' => $this->picUrl($data->image, 'bannerPic', $this->platform),
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.banner') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.banner') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.banner') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($itemPermission['details_item'] == '1') {
                        $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray) . '\' title="Details" class="actionDatatable"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                    } else {
                        $details = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete . ' ' . $details;
                })
                ->rawColumns(['banner', 'for', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveBanner(Request $request)
    {
        try {
            $values = $request->only('for');
            $file = $request->file('file');
            //--Checking The Validation--//

            $validator = $this->isValid($request->all(), 'saveBanner', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                //--Insert Banner--//
                if (!empty($file)) {
                    $image = $this->uploadPicture($file, '', $this->platform, 'bannerPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $image = "NA";
                }

                $banner = new Banner;
                $banner->image = $image;
                $banner->for = $values['for'];

                if ($banner->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Banner", 'msg' => 'Banner Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Banner", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Banner", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateBanner(Request $request)
    {
        $values = $request->only('id', 'for');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateBanner', $id, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $banner = Banner::find($id);

                if (!empty($file)) {
                    $image = $this->uploadPicture($file, $banner->image, $this->platform, 'bannerPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    } else {
                        $banner->image = $image;
                    }
                }

                $banner->for = $values['for'];

                if ($banner->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Banner", 'msg' => 'Banner Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Banner", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Banner", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusBanner($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Banner::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteBanner($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, Banner::class, 'bannerPic');
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Privacy Policy ) ----*/
    public function showPrivacyPolicy()
    {
        try {
            $privacyPolicy = PrivacyPolicy::first();
            $data = array(
                'id' => encrypt($privacyPolicy->id),
                'privacyPolicy' => $privacyPolicy->privacyPolicy
            );
            return view('admin.cms.privacy_policy.privacy_policy_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updatePrivacyPolicy(Request $request)
    {
        $values = $request->only('id', 'privacyPolicy');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {

            $privacyPolicy = PrivacyPolicy::find($id);

            $privacyPolicy->privacyPolicy = $values['privacyPolicy'];

            if ($privacyPolicy->save()) {
                return redirect()->back()->with('success', 'Privacy Policy successfully save.');
            } else {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }


    /*---- ( Terms Condition ) ----*/
    public function showTermsCondition()
    {
        try {
            $termsCondition = TermsCondition::first();
            $data = array(
                'id' => encrypt($termsCondition->id),
                'termsCondition' => $termsCondition->termsCondition
            );
            return view('admin.cms.terms_condition.terms_condition_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateTermsCondition(Request $request)
    {
        $values = $request->only('id', 'termsCondition');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {

            $termsCondition = TermsCondition::find($id);

            $termsCondition->termsCondition = $values['termsCondition'];

            if ($termsCondition->save()) {
                return redirect()->back()->with('success', 'Terms Condition successfully save.');
            } else {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }


    /*---- ( About Us ) ----*/
    public function showAboutUs()
    {
        try {
            $aboutUs = AboutUs::first();
            $data = array(
                'id' => encrypt($aboutUs->id),
                'title' => $aboutUs->title,
                'content' => $aboutUs->content,
                'image' => $this->picUrl($aboutUs->image, 'aboutPic', $this->platform),
            );
            return view('admin.cms.about_us.about_us_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateAboutUs(Request $request)
    {
        $values = $request->only('id', 'title', 'content');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $validator = $this->isValid($request->all(), 'updateAboutUs', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $aboutUs = AboutUs::find($id);

                if (!empty($file)) {
                    $image = $this->uploadPicture($file, $aboutUs->image, $this->platform, 'aboutPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    } else {
                        $aboutUs->image = $image;
                    }
                }

                $aboutUs->title = $values['title'];
                $aboutUs->content = $values['content'];

                if ($aboutUs->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "About Us", 'msg' => 'About Us Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "About Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "About Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Return Refund ) ----*/
    public function showReturnRefund()
    {
        try {
            $returnRefund = ReturnRefund::first();
            $data = array(
                'id' => encrypt($returnRefund->id),
                'return' => $returnRefund->return,
                'refund' => $returnRefund->refund,
            );
            return view('admin.cms.return_refund.return_refund_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateReturnRefund(Request $request)
    {
        $values = $request->only('id', 'return', 'refund');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $validator = $this->isValid($request->all(), 'updateReturnRefund', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $returnRefund = ReturnRefund::find($id);
                $returnRefund->return = $values['return'];
                $returnRefund->refund = $values['refund'];

                if ($returnRefund->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Return & Refund Policy", 'msg' => 'Return & Refund Policy Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Return & Refund Policy", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Return & Refund Policy", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Contact Us ) ----*/
    public function showContactUs()
    {
        try {
            $contactUs = ContactUs::first();
            $data = array(
                'id' => encrypt($contactUs->id),
                'phone' => $contactUs->phone,
                'email' => $contactUs->email,
                'googleMap' => $contactUs->googleMap,
                'address' => $contactUs->address,
                'content' => $contactUs->content,
            );
            return view('admin.cms.contact_us.contact_us_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateContactUs(Request $request)
    {
        $values = $request->only('id', 'phone', 'email', 'googleMap', 'address');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $validator = $this->isValid($request->all(), 'updateContactUs', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $contactUs = ContactUs::find($id);
                $contactUs->phone = $values['phone'];
                $contactUs->email = $values['email'];
                $contactUs->googleMap = $values['googleMap'];
                $contactUs->address = $values['address'];
                $contactUs->content = 'NA';

                if ($contactUs->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Contact Us", 'msg' => 'Contact Us Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Contact Enquiry ) ----*/
    public function showContactEnquiry()
    {
        try {
            return view('admin.cms.contact_enquiry.contact_enquiry_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getContactEnquiry()
    {
        try {

            $contactEnquiry = ContactEnquiry::orderBy('id', 'desc')->get();

            return Datatables::of($contactEnquiry)
                ->addIndexColumn()
                ->addColumn('date', function ($data) {
                    $date = date('d-m-Y h:i s', strtotime($data->created_at));
                    return $date;
                })
                ->addColumn('action', function ($data) {

                    $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'name' => $data->name,
                        'email' => $data->email,
                        'phone' => $data->phone,
                        'content' => $data->content,
                        'date' => date('d-m-Y h:i s', strtotime($data->created_at)),
                    ];


                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.contactEnquiry') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($itemPermission['details_item'] == '1') {
                        $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="actionDatatable"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                    } else {
                        $details = '';
                    }

                    return $delete . ' ' . $details;
                })
                ->rawColumns(['date', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function deleteContactEnquiry($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, ContactEnquiry::class, '');
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( FAQ ) ----*/
    public function showFaq()
    {
        try {
            return view('admin.cms.faq.faq_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getFaq(Request $request)
    {
        try {
            $for = $request->for;

            $query = "`created_at` is not null";

            if (!empty($for)) {
                $query .= " and `for` = '" . $for . "'";
            }

            $faq = Faq::whereRaw($query)->orderBy('id', 'desc')->select('id', 'question', 'answer', 'status');

            return Datatables::of($faq)
                ->addIndexColumn()
                ->addColumn('question', function ($data) {
                    $question = $this->substarString(40, $data->question, '....');
                    return $question;
                })
                ->addColumn('answer', function ($data) {
                    $answer = $this->substarString(40, $data->answer, '....');
                    return $answer;
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
                        'question' => $data->question,
                        'answer' => $data->answer,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.faq') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.faq') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.faq') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($itemPermission['details_item'] == '1') {
                        $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="actionDatatable"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                    } else {
                        $details = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete . ' ' . $details;
                })
                ->rawColumns(['question', 'answer', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveFaq(Request $request)
    {
        try {
            $values = $request->only('question', 'answer');
            //--Checking The Validation--//

            $validator = $this->isValid($request->all(), 'saveFaq', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $faq = new Faq;
                $faq->question = $values['question'];
                $faq->answer = $values['answer'];

                if ($faq->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "FAQ", 'msg' => 'FAQ Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "FAQ", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "FAQ", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateFaq(Request $request)
    {
        $values = $request->only('id', 'question', 'answer');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "FAQ", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateFaq', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $faq = Faq::find($id);

                $faq->question = $values['question'];
                $faq->answer = $values['answer'];

                if ($faq->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "FAQ", 'msg' => 'FAQ Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "FAQ", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "FAQ", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusFaq($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Faq::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteFaq($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, Faq::class, '');
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
