<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Units;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserAddress;
use App\Models\UserCart;
use App\Models\Transaction;

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailOrderPlaced;
use Illuminate\Support\Facades\Config;

class ManageOrdersAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*------- ( Product ) -------*/
    public function showOrders()
    {
        try {
            return view('admin.manage_orders.orders.list_orders');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getOrders(Request $request)
    {
        $payMode = $request->payMode;
        $status = $request->status;

        $query = "`created_at` is not null";

        if (!empty($payMode)) {
            $query .= " and `payMode` = '" . $payMode . "'";
        }

        if (!empty($status)) {
            $query .= " and `status` = '" . $status . "'";
        }

        $userOrder = UserOrder::orderBy('id', 'desc')->whereRaw($query)->get();

        return Datatables::of($userOrder)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == config('constants.status')['pending']) {
                    $status = '<span class="label label-pending">Pending</span>';
                } elseif ($data->status == config('constants.status')['placed']) {
                    $status = '<span class="label label-placed">Placed</span>';
                } elseif ($data->status == config('constants.status')['accepted']) {
                    $status = '<span class="label label-accepted">Accepted</span>';
                } elseif ($data->status == config('constants.status')['rejected']) {
                    $status = '<span class="label label-rejected">Rejected</span>';
                } elseif ($data->status == config('constants.status')['canceled']) {
                    $status = '<span class="label label-canceled">Canceled</span>';
                } elseif ($data->status == config('constants.status')['readyForPackaging']) {
                    $status = '<span class="label label-readyForPackaging">Ready For Packaging</span>';
                } elseif ($data->status == config('constants.status')['dispatched']) {
                    $status = '<span class="label label-dispatched">Dispatched</span>';
                } elseif ($data->status == config('constants.status')['delivered']) {
                    $status = '<span class="label label-delivered">Delivered</span>';
                } else {
                    $status = '<span class="label label-success">Active</span>';
                }
                return $status;
            })
            ->addColumn('totalItem', function ($data) {
                $totalItem = sizeof(json_decode($data->product));
                return $totalItem;
            })
            ->addColumn('orderDate', function ($data) {
                $orderDate = date('d, M Y', strtotime($data->created_at));
                return $orderDate;
            })
            ->addColumn('action', function ($data) {

                $itemPermission = $this->itemPermission();

                $dataArray = [
                    'id' => encrypt($data->id),
                    'status' => $data->status,
                    'reason' => $data->reason,
                ];

                if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['delivered'] || $data->status == Config::get('constants.status')['rejected'] || $data->status == Config::get('constants.status')['canceled']) {
                        $status = '';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    }
                } else {
                    $status = '';
                }

                if ($itemPermission['details_item'] == '1') {
                    $detail = '<a href="' .  route('admin.details.orders') . '/' . $dataArray['id'] . '" target="_blank" title="Details"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                } else {
                    $detail = '';
                }

                return $status . ' ' . $detail;
            })
            ->rawColumns(['status', 'orderDate', 'totalItem', 'action'])
            ->make(true);
    }

    public function statusOrders(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('id', 'status', 'reason');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Orders Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            if ($values['status'] == config('constants.status')['rejected'] || $values['status'] == config('constants.status')['canceled']) {
                $validator = $this->isValid($request->all(), 'statusOrders1', $id, $this->platform);
            } else {
                $validator = $this->isValid($request->all(), 'statusOrders2', $id, $this->platform);
            }
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $userOrder = UserOrder::findOrFail($id);
                $user = User::findOrFail($userOrder->userId);

                $userOrder->status = $values['status'];

                if ($values['status'] == config('constants.status')['rejected'] || $values['status'] == config('constants.status')['canceled']) {
                    $userOrder->reason = $values['reason'];
                }

                if ($userOrder->update()) {
                    if ($values['status'] == config('constants.status')['delivered'] && $userOrder->payMode == config('constants.payMode')['cod']) {
                        $transaction = Transaction::where('userOrderId', $id)->first();
                        $transaction->status = Config::get('constants.transactionStatus')['completed'];
                        if ($transaction->update()) {
                            goto a;
                        } else {
                            DB::rollback();
                            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Orders Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                        }
                    } else {
                        goto a;
                    }
                    a:
                    DB::commit();
                    $data = array(
                        'otp' => 'Order ' . $values['status'],
                        'msg' => "Your order " . $values['status'] . " successfully"
                    );
                    Mail::to($user->email)->send(new MailOrderPlaced($data));
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Orders Status", 'msg' => 'Orders status successfully update.'], config('constants.ok'));
                } else {
                    DB::rollback();
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Orders Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Orders Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function detailOrders($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $userOrder = UserOrder::where('id', $id)->first();
            $transaction = Transaction::where('userOrderId', $id)->first();
            $user = User::where('id', $userOrder->userId)->first();

            $product = array();
            foreach (json_decode($userOrder->product) as $temp) {
                $actualProduct = Product::where('id', decrypt($temp->id))->first();
                $product[] = array(
                    'id' => $temp->id,
                    'image' => $this->picUrl($actualProduct->image, 'productPic', $this->platform),
                    'nameShort' => $temp->nameShort,
                    'name' => $temp->name,
                    'price' => $temp->price,
                    'discount' => $temp->discount,
                    'gst' => $temp->gst,
                    'quantity' => $temp->quantity,
                    'description' => $temp->description,
                    'priceAfterDiscount' => $temp->priceAfterDiscount,
                    'priceAfterGst' => $temp->priceAfterGst,
                    'units' => $temp->units,
                    'category' => $temp->category,
                    'payMode' => $temp->payMode,
                );
            }

            if ($userOrder->status == config('constants.status')['pending']) {
                $status = '<span class="label label-pending">Pending</span>';
            } elseif ($userOrder->status == config('constants.status')['placed']) {
                $status = '<span class="label label-placed">Placed</span>';
            } elseif ($userOrder->status == config('constants.status')['accepted']) {
                $status = '<span class="label label-accepted">Accepted</span>';
            } elseif ($userOrder->status == config('constants.status')['rejected']) {
                $status = '<span class="label label-rejected">Rejected</span>';
            } elseif ($userOrder->status == config('constants.status')['canceled']) {
                $status = '<span class="label label-canceled">Canceled</span>';
            } elseif ($userOrder->status == config('constants.status')['readyForPackaging']) {
                $status = '<span class="label label-readyForPackaging">Ready For Packaging</span>';
            } elseif ($userOrder->status == config('constants.status')['dispatched']) {
                $status = '<span class="label label-dispatched">Dispatched</span>';
            } elseif ($userOrder->status == config('constants.status')['delivered']) {
                $status = '<span class="label label-delivered">Delivered</span>';
            } else {
                $status = '<span class="label label-success">Active</span>';
            }

            $data = array(
                'id' => encrypt($userOrder->id),
                'uniqueId' => $userOrder->uniqueId,
                'payMode' => $userOrder->payMode,
                'status' => $status,
                'statusMain' => $userOrder->status,
                'reason' => $userOrder->reason,
                'product' => $product,
                'orderDate' => date('d, M y', strtotime($userOrder->created_at)),
                'deliveredAddress' => json_decode($userOrder->deliveredAddress),
                'transaction' => [
                    'id' => encrypt($transaction->id),
                    'status' => $transaction->status,
                    'amount' => $transaction->amount,
                    'uniqueId' => $transaction->uniqueId,
                ],
                'user' => [
                    'id' => encrypt($user->id),
                    'name' => $user->name,
                    'image' => $this->picUrl($user->image, 'clientPic', $this->platform),
                    'phone' => $user->phone,
                    'email' => $user->email,
                ],
            );
            return view('admin.manage_orders.orders.detail_orders')->with('data', $data);
        } catch (Exception $e) {
            return redirect()->abort();
        }
    }
}
