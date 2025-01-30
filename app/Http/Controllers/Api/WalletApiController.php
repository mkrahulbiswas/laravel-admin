<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;
use App\Traits\RazorpayTrait;

use App\Models\UserAddress;
use App\Models\User;
use App\Models\Transduction;

use App\Models\FoodCuration\Dish;
use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait, RazorpayTrait;
    public $platform = 'app';


    /*------- ( User Wallet ) -------*/
    public function genarateOrderForWallet($amount)
    {
        try {
            $auth = Auth::user();
            $data = array();
            $responce = $this->createOrder([
                'amount' => $amount
            ]);

            $transduction = new Transduction();
            $transduction->userId = $auth->id;
            $transduction->tranNumber = $this->generateCode('', 10, Transduction::class, 'tranNumber');
            $transduction->amount = $amount;
            $transduction->payMode = config('constants.payMode')['razorpay'];
            $transduction->tranType = config('constants.tranType')['deposit'];
            $transduction->payStatus = config('constants.payStatus')['initiate'];
            $transduction->razoppayOrderId = $responce->id;

            if ($transduction->save()) {
                $data = array(
                    'id' => $transduction->id,
                    'orderId' => $responce->id,
                    'amount' => $amount
                );
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function saveAmountToWallet(Request $request)
    {
        try {
            $auth = Auth::user();
            DB::beginTransaction();
            $values = $request->only('id', 'paymentId', 'orderId');

            if (!$this->isValid($request->all(), 'saveAmountToWallet', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $transduction = Transduction::where('razoppayOrderId', $values['orderId'])->first();

            if ($transduction->payStatus == config('constants.payStatus')['paid']) {
                return response()->json(['status' => 0, 'msg' => 'This transiction is already done', 'payload' => (object)[]], config('constants.ok'));
            }

            $transduction->razoppayPaymentId = $values['paymentId'];
            $transduction->payStatus = config('constants.payStatus')['paid'];
            if ($transduction->update()) {
                $responce = $this->checkPaymentStatus(['paymentId' => $values['paymentId']]);
                if (Str::upper($responce->status) == config('constants.payStatus')['captured']) {
                    $user = User::where('id', $auth->id)->first();
                    $user->wallet = $user->wallet + $transduction->amount;
                    if ($user->update()) {
                        DB::commit();
                        return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                    } else {
                        DB::rollback();
                        return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                    }
                } else {
                    DB::rollback();
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
            } else {
                DB::rollback();
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getWalletBallance()
    {
        try {
            $auth = Auth::user();

            $data = array(
                'id' => $auth->id,
                'wallet' => $auth->wallet,
            );

            if (!empty($data)) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function getWalletHistory()
    {
        try {
            $auth = Auth::user();
            $data = array();
            $transduction = Transduction::where([
                ['userId', $auth->id],
                ['payStatus', config('constants.payStatus')['paid']]
            ])->whereIn('tranType', [config('constants.tranType')['withdraw'], config('constants.tranType')['deposit']])->get();

            foreach ($transduction as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'amount' => $temp->amount,
                    'tranNumber' => $temp->tranNumber,
                    'tranType' => $temp->tranType,
                    'payStatus' => $temp->payStatus,
                    'orderId' => $temp->razoppayOrderId,
                    'paymentId' => $temp->razoppayPaymentId,
                    'date' => date('d-m-Y h:i A', strtotime($temp->created_at)),
                );
            }

            if (!empty($data)) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }
}
