<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Banner;
use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\TermsCondition;
use App\Models\PrivacyPolicy;
use App\Models\Faq;
use App\Models\ContactEnquiry;
use App\Models\ReturnRefund;
use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;

class CmsWebController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'web';

    public function showPrivacyPolicy()
    {
        try {
            $banner = Banner::where('for', config('constants.bannerFor')['privacyPolicy'])->first();
            $privacyPolicy = PrivacyPolicy::first();

            $data = array(
                'content' => $privacyPolicy->privacyPolicy,
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
            );

            return view('web.cms.privacy_policy', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function showTermsCondition()
    {
        try {
            $banner = Banner::where('for', config('constants.bannerFor')['termsAndCondition'])->first();
            $termsCondition = TermsCondition::first();

            $data = array(
                'content' => $termsCondition->termsCondition,
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
            );

            return view('web.cms.terms_conditions', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function showReturnRefund()
    {
        try {
            $faq = array();
            $banner = Banner::where('for', config('constants.bannerFor')['returnAndRefundPolicy'])->first();
            $returnRefund = ReturnRefund::first();
            foreach (Faq::where('status', config('constants.status')['1'])->get() as $temp) {
                $faq[] = array(
                    'question' => $temp->question,
                    'answer' => $temp->answer,
                );
            }

            $data = array(
                'return' => $returnRefund->return,
                'refund' => $returnRefund->refund,
                'faq' => $faq,
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
            );

            return view('web.cms.return_refund', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function showAboutUs()
    {
        try {
            $banner = Banner::where('for', config('constants.bannerFor')['aboutUs'])->first();
            $aboutUs = AboutUs::first();

            $data = array(
                'content' => $aboutUs->content,
                'title' => $aboutUs->title,
                'image' => $this->picUrl($aboutUs->image, 'aboutPic', $this->platform),
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
            );

            return view('web.cms.abour_us', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function showContactUs()
    {
        try {
            $banner = Banner::where('for', config('constants.bannerFor')['contactUs'])->first();
            $contactUs = ContactUs::first();

            $data = array(
                'content' => $contactUs->content,
                'googleMap' => $contactUs->googleMap,
                'phone' => $contactUs->phone,
                'email' => $contactUs->email,
                'address' => $contactUs->address,
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
            );

            return view('web.cms.contact_us', ['data' => $data]);
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
