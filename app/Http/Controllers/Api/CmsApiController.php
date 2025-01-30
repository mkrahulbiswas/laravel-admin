<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\User;
use App\Models\Banner;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use App\Models\Faq;
use App\Models\Feedback;

use Illuminate\Support\Carbon;
use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CmsApiController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'app';


    public function getBanner($for)
    {
        try {
            $data = array();
            $banner = Banner::where([
                ['status', '1'],
                ['for', Str::upper($for)]
            ])->get();
            foreach ($banner as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'image' => $this->picUrl($temp->image, 'bannerPic', $this->platform),
                );
            }
            if ($data) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), "payload" => ['banner' => $data, 'count' => sizeof($data)]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['banner' => $data, 'count' => sizeof($data)]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getPrivacyPolicy()
    {
        try {
            $privacyPolicy = PrivacyPolicy::first();
            $data = array(
                'id' => $privacyPolicy->id,
                'privacyPolicy' => $privacyPolicy->privacyPolicy
            );
            return response()->json(['status' => 1, 'msg' => config('constants.successMsg'), "payload" => ['data' => $data]], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getTermsCondition()
    {
        try {
            $termsCondition = TermsCondition::first();
            $data = array(
                'id' => $termsCondition->id,
                'termsCondition' => $termsCondition->termsCondition
            );
            return response()->json(['status' => 1, 'msg' => config('constants.successMsg'), "payload" => ['data' => $data]], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getFaq()
    {
        try {
            $data = array();
            $faq = Faq::where('status', config('constants.status')['1'])->get();
            foreach ($faq as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'question' => $temp->question,
                    'answer' => $temp->answer
                );
            }
            if ($data) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), "payload" => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function saveFeedback(Request $request)
    {
        try {
            $auth = Auth::user();
            $values = $request->only('type', 'message');

            if (!$this->isValid($request->all(), 'saveFeedback', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            } else {

                $feedback = new Feedback();
                $feedback->userId = $auth->id;
                $feedback->type = Str::upper($values['type']);
                $feedback->message = $values['message'];

                if ($feedback->save()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }








    /*------ (Test) ------*/
    public function saveDesignation(Request $request)
    {
        try {
            $values = $request->only('name');

            // if (!$this->isValid($request->all(), 'saveUserData', 0, 'backend')) {
            //     $vErrors = $this->getVErrorMessages($this->vErrors);
            //     return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            // } else {
            if (DB::table('designation')->insert([
                'name' => $values['name'],
            ])) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
            // }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function saveUserData(Request $request)
    {
        try {
            $values = $request->only('name', 'phone', 'email', 'password', 'designation');

            // if (!$this->isValid($request->all(), 'saveUserData', 0, 'backend')) {
            //     $vErrors = $this->getVErrorMessages($this->vErrors);
            //     return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            // } else {
            if (DB::table('user_data')->insert([
                'name' => $values['name'],
                'phone' => $values['phone'],
                'email' => $values['email'],
                'designation' => $values['designation'],
                'password' => Hash::make($values['password']),
                'passwordInText' => encrypt($values['password']),
            ])) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
            // }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function updateUserData(Request $request)
    {
        try {
            $values = $request->only('id', 'name', 'phone', 'email', 'password', 'designation');

            // if (!$this->isValid($request->all(), 'saveUserData', 0, 'backend')) {
            //     $vErrors = $this->getVErrorMessages($this->vErrors);
            //     return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            // } else {
            if (DB::table('user_data')->where('id', $values['id'])->update([
                'name' => $values['name'],
                'phone' => $values['phone'],
                'email' => $values['email'],
                'designation' => $values['designation'],
                'password' => Hash::make($values['password']),
                'passwordInText' => encrypt($values['password']),
            ])) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
            // }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function statusUserData($id)
    {
        try {
            if (DB::table('user_data')->where('id', $id)->value('status') == 1) {
                $status = '0';
            } else {
                $status = '1';
            }
            if (DB::table('user_data')->where('id', $id)->update([
                'status' => $status,
            ])) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function deleteUserData($id)
    {
        try {
            if (DB::table('user_data')->where('id', $id)->delete()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getUserData()
    {
        try {
            $data = array();
            foreach (DB::table('user_data')->get() as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                    'phone' => $temp->phone,
                    'email' => $temp->email,
                    'status' => $temp->status,
                    'password' => decrypt($temp->passwordInText),
                    'designationId' => $temp->designation,
                    'designation' => DB::table('designation')->where('id', $temp->designation)->value('name')
                );
            }
            if ($data) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), "payload" => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getDesignation()
    {
        try {
            $data = array();
            foreach (DB::table('designation')->get() as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                    'status' => $temp->status,
                );
            }
            if ($data) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), "payload" => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function statusDesignation($id)
    {
        try {
            if (DB::table('designation')->where('id', $id)->value('status') == 1) {
                $status = '0';
            } else {
                $status = '1';
            }
            if (DB::table('designation')->where('id', $id)->update([
                'status' => $status,
            ])) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function deleteDesignation($id)
    {
        try {
            if (DB::table('designation')->where('id', $id)->delete()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function updateDesignation(Request $request)
    {
        try {
            $values = $request->only('id', 'name', 'phone', 'email', 'password', 'designation');

            // if (!$this->isValid($request->all(), 'saveUserData', 0, 'backend')) {
            //     $vErrors = $this->getVErrorMessages($this->vErrors);
            //     return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            // } else {
            if (DB::table('designation')->where('id', $values['id'])->update([
                'name' => $values['name'],
            ])) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
            // }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }
}
