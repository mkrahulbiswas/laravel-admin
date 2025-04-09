<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Units;
use App\Models\UserCart;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserOrder;
use App\Models\Transaction;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardWebController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'web';

    public function showDashboard()
    {
        try {
            $category = $userAddress = $userOrders = $product = array();
            $banner = Banner::where('for', config('constants.bannerFor')['dashboard'])->first();
            $user = User::where('id', Auth::user()->id)->first();

            foreach (Category::where('status', config('constants.status')['1'])->get() as $temp) {
                $category[] = array(
                    'id' => encrypt($temp->id),
                    'name' => $temp->name,
                    'slug' => $temp->slug,
                );
            }

            foreach (UserAddress::where('userId', Auth::user()->id)->get() as $temp) {
                $userAddress[] = array(
                    'id' => encrypt($temp->id),
                    'address' => $temp->address,
                    'landmark' => $temp->landmark,
                    'city' => $temp->city,
                    'state' => $temp->state,
                    'country' => $temp->country,
                    'pinCode' => $temp->pinCode,
                    'contactNumber' => $temp->contactNumber,
                    'isDefault' => $temp->isDefault,
                );
            }

            foreach (UserOrder::where('userId', Auth::user()->id)->get() as $tempOne) {
                foreach (json_decode($tempOne->product) as $tempTwo) {
                    $actualProduct = Product::where('id', decrypt($tempTwo->id))->first();
                    $product[] = array(
                        'id' => $tempTwo->id,
                        'image' => $this->picUrl($actualProduct->image, 'productPic', $this->platform),
                        'nameShort' => $tempTwo->nameShort,
                        'name' => $tempTwo->name,
                        'price' => $tempTwo->price,
                        'discount' => $tempTwo->discount,
                        'gst' => $tempTwo->gst,
                        'quantity' => $tempTwo->quantity,
                        'description' => $tempTwo->description,
                        'priceAfterDiscount' => $tempTwo->priceAfterDiscount,
                        'priceAfterGst' => $tempTwo->priceAfterGst,
                        'units' => $tempTwo->units,
                        'category' => $tempTwo->category,
                        'payMode' => $tempTwo->payMode,
                    );
                }
                $userOrders[] = array(
                    'id' => encrypt($tempOne->id),
                    'uniqueId' => $tempOne->uniqueId,
                    'product' => $product,
                    'status' => $tempOne->status,
                    'reason' => $tempOne->reason,
                    'product' => $product,
                    'orderDate' => date('d, M y', strtotime($tempOne->created_at)),
                    'deliveredAddress' => json_decode($tempOne->deliveredAddress),
                );
                $product = array();
            }

            $data = array(
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
                'category' => $category,
                'userAddress' => $userAddress,
                'userOrders' => $userOrders,
                'user' => [
                    'image' => $this->picUrl($user->image, 'clientPic', $this->platform),
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'id' => encrypt($user->id),
                ],
            );

            // dd($data);

            return view('web.dashboard.dashboard', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateProfile(Request $request)
    {
        $values = $request->only('id', 'name', 'phone', 'isPassChange', 'oldPassword', 'newPassword', 'confirmPassword');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            if (isset($values['isPassChange'])) {
                $validator = $this->isValid($request->all(), 'updateProfile1', 0, $this->platform);
            } else {
                $validator = $this->isValid($request->all(), 'updateProfile2', 0, $this->platform);
            }

            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $user = User::find($id);

                $user->name = $values['name'];
                $user->phone = $values['phone'];

                if (isset($values['isPassChange'])) {
                    if (Hash::check($values['oldPassword'], Auth::user()->password)) {
                        $user->password = Hash::make($values['newPassword']);
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Profile", 'msg' => __('messages.oldPassNotMatchErr')], config('constants.ok'));
                    }
                }

                if (!empty($file)) {
                    $image = $this->uploadPicture($file, $user->image, $this->platform, 'clientPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    } else {
                        $user->image = $image;
                    }
                }

                if ($user->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Profile", 'msg' => 'Profile Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function saveAddress(Request $request)
    {
        $values = $request->only('address', 'landmark', 'city', 'state', 'country', 'pinCode', 'contactNumber');

        try {
            $validator = $this->isValid($request->all(), 'saveAddress', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $userAddress = new UserAddress();

                $userAddress->userId = Auth::user()->id;
                $userAddress->address = $values['address'];
                $userAddress->landmark = $values['landmark'];
                $userAddress->city = $values['city'];
                $userAddress->state = $values['state'];
                $userAddress->country = $values['country'];
                $userAddress->pinCode = $values['pinCode'];
                $userAddress->contactNumber = $values['contactNumber'];

                if (UserAddress::where([
                    ['userId', Auth::user()->id],
                    ['isDefault', '1']
                ])->get()->count() > 0) {
                    $userAddress->isDefault = '0';
                } else {
                    $userAddress->isDefault = '1';
                }


                if ($userAddress->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Address", 'msg' => 'Address Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Address", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateAddress(Request $request)
    {
        $values = $request->only('id', 'address', 'landmark', 'city', 'state', 'country', 'pinCode', 'contactNumber');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateAddress', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $userAddress = UserAddress::find($id);

                $userAddress->address = $values['address'];
                $userAddress->landmark = $values['landmark'];
                $userAddress->city = $values['city'];
                $userAddress->state = $values['state'];
                $userAddress->country = $values['country'];
                $userAddress->pinCode = $values['pinCode'];
                $userAddress->contactNumber = $values['contactNumber'];


                if ($userAddress->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Address", 'msg' => 'Address Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Address", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Contact Us", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function isDefaultAddress($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            UserAddress::where('userId', Auth::user()->id)->update(['isDefault' => '0']);
            $result = $this->changeStatus($id, UserAddress::class, ['isDefault'], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteAddress($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            if (UserAddress::where('id', $id)->first()->isDefault == '1') {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => 'You can not delete any default set address.'], config('constants.ok'));
            } else {
                $result = $this->deleteItem($id, UserAddress::class, '');
                if ($result === true) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully changed.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}
