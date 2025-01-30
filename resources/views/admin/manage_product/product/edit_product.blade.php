@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="{{ route('admin.show.product') }}" class="btn backBtn waves-effect waves-light"><i class=" ti-arrow-left"></i> Back</a>
        </div>
        <h4 class="page-title">Edit Manage Product</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Package Master</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.show.product')}}">Sub Manage Product</a></li>
            <li class="breadcrumb-item active">Edit Manage Product</li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <!-- <h4 class="header-title m-t-0">Add New Admin</h4> -->
            <p class="text-muted font-14 m-b-20">
                
            </p>
            <form id="updateProductForm" action="{{route('admin.update.product')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="id" value="{{ $data['id'] }}">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Product Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Product Name" class="form-control" value="{{ $data['name'] }}">
                        <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="units">Units<span class="text-danger">*</span></label>
                        <select name="units" id="units" class="advance-select-units">
                            <option value="">Select Units</option>
                            @foreach ($data['units'] as $item)
                            <option value="{{ $item['id'] }}" {{ ($data['unitsId'] == $item['id']) ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                       <span role="alert" id="unitsErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="category">Category<span class="text-danger">*</span></label>
                        <select name="category" id="category" class="advance-select-category">
                            <option value="">Select Units</option>
                            @foreach ($data['category'] as $item)
                            <option value="{{ $item['id'] }}" {{ ($data['categoryId'] == $item['id']) ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                       <span role="alert" id="categoryErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="price">Price<span class="text-danger">*</span></label>
                        <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="{{ $data['price'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="priceErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="discount">Discount<span class="text-danger">*</span></label>
                        <input type="text" name="discount" id="discount" placeholder="Discount" class="form-control" value="{{ $data['discount'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="discountErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="priceAfterDiscount">Price After Discount<span class="text-danger">*</span></label>
                        <input type="text" readonly name="priceAfterDiscount" id="priceAfterDiscount" placeholder="Price After Discount" class="form-control" value="{{ $data['priceAfterDiscount'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="priceAfterDiscountErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="gst">GST<span class="text-danger">*</span></label>
                        <select name="gst" id="gst" class="selectpicker" data-style="btn-success btn-custom">
                            <option value="">Select GST</option>
                            <option value="0" {{ ($data['gst'] == '0') ? 'selected' : '' }}>0</option>
                            <option value="5" {{ ($data['gst'] == '5') ? 'selected' : '' }}>5</option>
                            <option value="12" {{ ($data['gst'] == '12') ? 'selected' : '' }}>12</option>
                            <option value="18" {{ ($data['gst'] == '18') ? 'selected' : '' }}>18</option>
                            <option value="28" {{ ($data['gst'] == '28') ? 'selected' : '' }}>28</option>
                        </select>
                       <span role="alert" id="gstErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="priceAfterGst">Price After GST<span class="text-danger">*</span></label>
                        <input type="text" readonly name="priceAfterGst" id="priceAfterGst" placeholder="Price After GST" class="form-control" value="{{ $data['priceAfterGst'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="priceAfterGstErr" style="color:red;font-size: 12px"></span>
                    </div>
            
                    <div class="form-group col-md-3">
                        <label for="quantity">Quantity<span class="text-danger">*</span></label>
                        <input type="text" name="quantity" id="quantity" placeholder="Quantity" class="form-control" value="{{ $data['quantity'] }}" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="quantityErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="payMode">Pay Mode<span class="text-danger">*</span></label>
                        <select name="payMode" id="payMode" class="selectpicker" data-style="btn-info btn-custom">
                            <option value="">Select Pay Mode</option>
                            <option value="{{ config('constants.payMode')['cod'] }}" {{ ($data['payMode'] == config('constants.payMode')['cod']) ? 'selected' : '' }}>{{ config('constants.payMode')['cod'] }}</option>
                            <option value="{{ config('constants.payMode')['online'] }}" {{ ($data['payMode'] == config('constants.payMode')['online']) ? 'selected' : '' }}>{{ config('constants.payMode')['online'] }}</option>
                        </select>
                       <span role="alert" id="payModeErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="file"><strong>Note:&nbsp;</strong> Image Size should be 1MB to 2MB<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" name="file" id="file" class="dropify">
                                    </div>
                                    <span role="alert" id="fileErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin stretch-card">
                                <img src="{{ $data['image'] }}" class="img-responsive img-thumbnail" style="height: 240px">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="description">Description<span class="text-danger">*</span></label>
                        <textarea name="description" id="description" cols="10" rows="10" parsley-trigger="change" placeholder="Description" class="summernote-product form-control">{{ $data['description'] }}</textarea>
                        <span role="alert" id="descriptionErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>


                <br>
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
                <div class="form-group text-right m-b-0">
                    <button id="updateProductBtn" class="btn updateBtn waves-effect waves-light" type="submit"><i class="ti-save"></i> 
                        <span>Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
