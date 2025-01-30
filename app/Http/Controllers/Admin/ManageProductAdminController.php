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

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ManageProductAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Category ) ----*/
    public function showCategory()
    {
        try {
            return view('admin.manage_product.category.category_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getCategory()
    {
        try {
            $category = Category::orderBy('id', 'desc')->get();

            return Datatables::of($category)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        $status = '<span class="label label-danger">Blocked</span>';
                    } else {
                        $status = '<span class="label label-success">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('display', function ($data) {
                    if ($data->display == '0') {
                        $display = '<span class="label label-danger">Blocked</span>';
                    } else {
                        $display = '<span class="label label-success">Active</span>';
                    }
                    return $display;
                })
                ->addColumn('action', function ($data) {

                    $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'name' => $data->name,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.category') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.category') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['other_item'] == '1') {
                        if ($data->display == "1") {
                            $display = '<a href="JavaScript:void(0);" data-type="display" data-status="in active" data-action="' . route('admin.display.category') . '/' . $dataArray['id'] . '" class="actionDatatable" title="In Active"><i class="md md-done-all" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $display = '<a href="JavaScript:void(0);" data-type="display" data-status="active" data-action="' . route('admin.display.category') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Active"><i class="md md-done" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $display = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.category') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $status . ' ' . $display . ' ' . $edit . ' ' . $delete;
                })
                ->rawColumns(['display', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveCategory(Request $request)
    {
        try {
            $values = $request->only('name');
            //--Checking The Validation--//

            $validator = $this->isValid($request->all(), 'saveCategory', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $category = new Category;
                $category->name = $values['name'];
                $category->slug = $this->generateSlug($values['name'], 'name', 'category', 'insert', '');

                if ($category->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Category", 'msg' => 'Category Successfully saved.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Category", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Category", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateCategory(Request $request)
    {
        $values = $request->only('id', 'name');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Category", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateCategory', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $category = Category::find($id);

                $category->name = $values['name'];
                $category->slug = $this->generateSlug($values['name'], 'name', 'category', 'update', $id);

                if ($category->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Category", 'msg' => 'Category Successfully updated.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Category", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Category", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function displayCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Category::class, ['display'], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Category::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            if (Product::where('categoryId', $id)->get()->count() > 0) {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => "This category is already using, so you can't delete this"], config('constants.ok'));
            } else {
                $result = $this->deleteItem($id, Category::class, '');
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



    /*------- ( Product ) -------*/
    public function showProduct()
    {
        try {
            return view('admin.manage_product.product.list_product');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();

        return Datatables::of($product)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == '0') {
                    $status = '<span class="label label-danger">Blocked</span>';
                } else {
                    $status = '<span class="label label-success">Active</span>';
                }
                return $status;
            })
            ->addColumn('display', function ($data) {

                if ($data->featured == '0') {
                    $featured = '<span class="label label-danger">In Active</span>';
                } else {
                    $featured = '<span class="label label-success">Active</span>';
                }

                if ($data->topTrending == '0') {
                    $topTrending = '<span class="label label-danger">In Active</span>';
                } else {
                    $topTrending = '<span class="label label-success">Active</span>';
                }

                if ($data->hotDeals == '0') {
                    $hotDeals = '<span class="label label-danger">In Active</span>';
                } else {
                    $hotDeals = '<span class="label label-success">Active</span>';
                }

                $display = '<div class="display">
                <div class="common">
                <span>Featured:</span>' . $featured . '
                </div>
                <div class="common">
                <span>Top Trending:</span>' . $topTrending . '
                </div>
                <div class="common">
                <span>Hot Deals:</span>' . $hotDeals . '
                </div>
                </div>';

                return $display;
            })
            ->addColumn('name', function ($data) {
                $name = $this->substarString(20, $data->name, '....');
                return $name;
            })
            ->addColumn('image', function ($data) {
                $image = '<img src="' . $this->picUrl($data->image, 'productPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                return $image;
            })
            ->addColumn('action', function ($data) {

                $itemPermission = $this->itemPermission();

                $dataArray = [
                    'id' => encrypt($data->id),
                    'featured' => $data->featured,
                    'topTrending' => $data->topTrending,
                    'hotDeals' => $data->hotDeals,
                ];

                if ($itemPermission['status_item'] == '1') {
                    if ($data->status == "0") {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.product') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.product') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    }
                } else {
                    $status = '';
                }

                if ($itemPermission['other_item'] == '1') {
                    $display = '<a href="JavaScript:void(0);" data-type="display" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' class="actionDatatable" title="Display Type"><i class="md md-done-all" style="font-size: 20px; color: #2bbbad;"></i></a>';
                } else {
                    $display = '';
                }

                if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="' . route('admin.edit.product') . '/' . $dataArray['id'] . '" title="Update"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                } else {
                    $edit = '';
                }

                if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.product') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                } else {
                    $delete = '';
                }

                if ($itemPermission['details_item'] == '1') {
                    $detail = '<a href="' .  route('admin.details.product') . '/' . $dataArray['id'] . '" target="_blank" title="Details"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                } else {
                    $detail = '';
                }

                return $status . ' ' . $display . ' ' . $edit . ' ' . $delete . ' ' . $detail;
            })
            ->rawColumns(['image', 'name', 'status', 'display', 'action'])
            ->make(true);
    }

    public function addProduct()
    {
        try {
            $category = $units = array();

            foreach (Units::get()->where('status', config('constants.status')['1']) as $temp) {
                $units[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                );
            }

            foreach (Category::get()->where('status', config('constants.status')['1']) as $temp) {
                $category[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                );
            }

            $data = array(
                'units' => $units,
                'category' => $category,
            );

            return view('admin.manage_product.product.add_product', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveProduct(Request $request)
    {
        try {
            $values = $request->only('name', 'units', 'category', 'price', 'discount', 'priceAfterDiscount', 'gst', 'priceAfterGst', 'quantity', 'payMode', 'description');
            $file = $request->file('file');

            //--Checking The Validation--//
            $validator = $this->isValid($request->all(), 'saveProduct', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                if (!empty($file)) {
                    $image = $this->uploadPicture($file, '', $this->platform, 'productPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $image = "NA";
                }

                $product = new Product();
                $product->categoryId = $values['category'];
                $product->name = $values['name'];
                $product->slug = $this->generateSlug($values['name'], 'name', 'product', 'insert', '');
                $product->description = $values['description'];
                $product->price = $values['price'];
                $product->discount = $values['discount'];
                $product->gst = $values['gst'];
                $product->quantity = $values['quantity'];
                $product->unitsId = $values['units'];
                $product->payMode = $values['payMode'];
                $product->image = $image;

                if ($product->save()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Product", 'msg' => 'Product Successfully saved.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Product", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Product", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function editProduct($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $category = $units = array();

            $product = Product::where('id', $id)->first();

            foreach (Units::get()->where('status', config('constants.status')['1']) as $temp) {
                $units[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                );
            }

            foreach (Category::get()->where('status', config('constants.status')['1']) as $temp) {
                $category[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                );
            }

            $priceAfterDiscount = ($product->price - $product->discount);
            $priceAfterGst = ($priceAfterDiscount + (($priceAfterDiscount * $product->gst) / 100));

            $data = array(
                'id' => encrypt($product->id),
                'name' => $product->name,
                'unitsId' => $product->unitsId,
                'categoryId' => $product->categoryId,
                'price' => $product->price,
                'discount' => $product->discount,
                'gst' => $product->gst,
                'quantity' => $product->quantity,
                'payMode' => $product->payMode,
                'description' => $product->description,
                'priceAfterDiscount' => $priceAfterDiscount,
                'priceAfterGst' => $priceAfterGst,
                'image' => $this->picUrl($product->image, 'productPic', $this->platform),
                'units' => $units,
                'category' => $category,
            );

            return view('admin.manage_product.product.edit_product', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateProduct(Request $request)
    {
        $values = $request->only('id', 'name', 'units', 'category', 'price', 'discount', 'priceAfterDiscount', 'gst', 'priceAfterGst', 'quantity', 'payMode', 'description');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Product", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateProduct', $id, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $product = Product::findOrFail($id);

                if (!empty($file)) {
                    $image = $this->uploadPicture($file, $product->image, $this->platform, 'productPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    } else {
                        $product->image = $image;
                    }
                }

                $product->categoryId = $values['category'];
                $product->name = $values['name'];
                $product->slug = $this->generateSlug($values['name'], 'name', 'product', 'update', $id);
                $product->description = $values['description'];
                $product->price = $values['price'];
                $product->discount = $values['discount'];
                $product->gst = $values['gst'];
                $product->quantity = $values['quantity'];
                $product->unitsId = $values['units'];
                $product->payMode = $values['payMode'];

                if ($product->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Product", 'msg' => 'Product successfully update.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Product", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Product", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function displayProduct(Request $request)
    {
        $values = $request->only('id', 'featured', 'topTrending', 'hotDeals');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Product Display", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'displayProduct', $id, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $product = Product::findOrFail($id);

                $product->featured = $values['featured'];
                $product->topTrending = $values['topTrending'];
                $product->hotDeals = $values['hotDeals'];

                if ($product->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Product Display", 'msg' => 'Product successfully update.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Product Display", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Product Display", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusProduct($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Product::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteProduct($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, Product::class, '');
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function detailProduct($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $product = Product::where('id', $id)->first();

            $productImage = array();
            $priceAfterDiscount = ($product->price - $product->discount);
            $priceAfterGst = ($priceAfterDiscount + (($priceAfterDiscount * $product->gst) / 100));

            if ($product->status == '0') {
                $status = '<span class="label label-danger">Blocked</span>';
            } else {
                $status = '<span class="label label-success">Active</span>';
            }

            if ($product->featured == '0') {
                $featured = '<span class="label label-danger">In Active</span>';
            } else {
                $featured = '<span class="label label-success">Active</span>';
            }

            foreach (ProductImage::where('productId', $product->id)->get() as $temp) {
                $productImage[] = array(
                    'id' => encrypt($temp->id),
                    'image' => $this->picUrl($temp->image, 'productPic', $this->platform),
                );
            }

            $data = array(
                'id' => encrypt($product->id),
                'name' => $product->name,
                'units' => Units::where('id', $product->unitsId)->first()->name,
                'category' => Category::where('id', $product->categoryId)->first()->name,
                'price' => $product->price,
                'discount' => $product->discount,
                'gst' => $product->gst,
                'quantity' => $product->quantity,
                'payMode' => $product->payMode,
                'description' => $product->description,
                'priceAfterDiscount' => $priceAfterDiscount,
                'priceAfterGst' => $priceAfterGst,
                'status' => $status,
                'featured' => $featured,
                'productImage' => $productImage,
                'image' => $this->picUrl($product->image, 'productPic', $this->platform),
            );

            Session::put('productId', encrypt($product->id));

            return view('admin.manage_product.product.detail_product')->with('data', $data);
        } catch (Exception $e) {
            return redirect()->abort();
        }
    }



    public function getProductImage()
    {
        $productImage = ProductImage::orderBy('id', 'desc')->where('productId', decrypt(Session::get('productId')))->get();

        return Datatables::of($productImage)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == '0') {
                    $status = '<span class="label label-danger">Blocked</span>';
                } else {
                    $status = '<span class="label label-success">Active</span>';
                }
                return $status;
            })
            ->addColumn('image', function ($data) {
                $image = '<img src="' . $this->picUrl($data->image, 'productPic', $this->platform) . '" class="img-fluid rounded image" width="100"/>';
                return $image;
            })
            ->addColumn('action', function ($data) {

                $itemPermission = $this->itemPermission();

                $dataArray = [
                    'id' => encrypt($data->id),
                ];

                if ($itemPermission['status_item'] == '1') {
                    if ($data->status == "0") {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.statusImage.product') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.statusImage.product') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    }
                } else {
                    $status = '';
                }

                if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.deleteImage.product') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                } else {
                    $delete = '';
                }

                return $status . ' ' . $delete;
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    public function saveProductImage(Request $request)
    {
        try {
            $values = $request->only('product');
            $file = $request->file('file');

            //--Checking The Validation--//
            $validator = $this->isValid($request->all(), 'saveProductImage', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                if (!empty($file)) {
                    $image = $this->uploadPicture($file, '', $this->platform, 'productPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $image = "NA";
                }

                $productImage = new ProductImage();
                $productImage->productId = decrypt($values['product']);
                $productImage->image = $image;

                if ($productImage->save()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Product Image", 'msg' => 'Product image successfully saved.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Product Image", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Product Image", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusProductImage($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, ProductImage::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteProductImage($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, ProductImage::class, 'productPic');
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
