<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Banner;
use App\Models\ContactEnquiry;
use App\Models\Units;
use Exception;

class HomeWebController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'web';

    public function showHome()
    {
        try {
            return view('web.home.home');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveContactUs(Request $request)
    {
        try {
            $values = $request->only('name', 'email', 'phone', 'message');

            $validator = $this->isValid($request->all(), 'saveContactUs', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $contactEnquiry = new ContactEnquiry;
                $contactEnquiry->name = $values['name'];
                $contactEnquiry->email = $values['email'];
                $contactEnquiry->phone = $values['phone'];
                $contactEnquiry->content = $values['message'];

                if ($contactEnquiry->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Contact Us", 'msg' => 'Thank you for contact us, we will reply soon.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}
