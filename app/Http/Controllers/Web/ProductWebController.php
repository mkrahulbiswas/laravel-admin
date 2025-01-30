<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Units;
use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;

class ProductWebController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'web';

    public function showProduct(Request $request)
    {
        try {
            $category = $product = array();
            $values = $request->only('text', 'id');
            $query = "`status` = '" . config('constants.status')['1'] . "'";
            $banner = Banner::where('for', config('constants.bannerFor')['product'])->first();

            if ($request->isMethod('post')) {
                if ($values['id'] != '') {
                    $query .= " and `categoryId` = '" . decrypt($values['id']) . "'";
                }
                if ($values['text'] != '') {
                    $query .= " and `name` LIKE '%" . $values['text'] . "%'";
                }
            } else {
            }

            foreach (Product::whereRaw($query)->get() as $temp) {

                $priceAfterDiscount = ($temp->price - $temp->discount);
                $priceAfterGst = ($priceAfterDiscount + (($priceAfterDiscount * $temp->gst) / 100));

                $product[] = array(
                    'image' => $this->picUrl($temp->image, 'productPic', $this->platform),
                    'id' => encrypt($temp->id),
                    'name' => $temp->name,
                    'nameShort' => $this->substarString(15, $temp->name, '....'),
                    'units' => Units::where('id', $temp->unitsId)->first()->name,
                    'category' => Category::where('id', $temp->categoryId)->first()->name,
                    'price' => $temp->price,
                    'discount' => $temp->discount,
                    'gst' => $temp->gst,
                    'quantity' => $temp->quantity,
                    'payMode' => $temp->payMode,
                    'description' => $temp->description,
                    'priceAfterDiscount' => $priceAfterDiscount,
                    'priceAfterGst' => $priceAfterGst,
                );
            }

            foreach (Category::where('status', config('constants.status')['1'])->get() as $temp) {
                $category[] = array(
                    'id' => encrypt($temp->id),
                    'name' => $temp->name,
                    'slug' => $temp->slug,
                );
            }

            $data = array(
                'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
                'category' => $category,
                'product' => $product,
            );

            if ($request->isMethod('post')) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Product Image", 'msg' => 'Product image successfully saved.', 'data' => $data], config('constants.ok'));
            } else {
                return view('web.product.product', ['data' => $data]);
            }
        } catch (Exception $e) {
            abort(500);
        }
    }
}
