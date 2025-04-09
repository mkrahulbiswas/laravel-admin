@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="{{ route('admin.show.product') }}" class="btn backBtn waves-effect waves-light"><i class=" ti-arrow-left"></i> Back</a>
        </div>
        <h4 class="page-title">Add New Manage Product</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Package Master</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.show.product')}}">Manage Product List</a></li>
            <li class="breadcrumb-item active">Add New Manage Product</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <!-- <h4 class="header-title m-t-0">Add New Admin</h4> -->
            <p class="text-muted font-14 m-b-20">
                
            </p>
            <form id="saveProductForm" action="{{route('admin.save.product')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Product Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Product Name" class="form-control" value="">
                        <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="units">Units<span class="text-danger">*</span></label>
                        <select name="units" id="units" class="advance-select-units">
                            <option value="">Select Units</option>
                            @foreach ($data['units'] as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                       <span role="alert" id="unitsErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="category">Category<span class="text-danger">*</span></label>
                        <select name="category" id="category" class="advance-select-category">
                            <option value="">Select Units</option>
                            @foreach ($data['category'] as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                       <span role="alert" id="categoryErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="price">Price<span class="text-danger">*</span></label>
                        <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="priceErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="discount">Discount<span class="text-danger">*</span></label>
                        <input type="text" name="discount" id="discount" placeholder="Discount" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="discountErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="priceAfterDiscount">Price After Discount<span class="text-danger">*</span></label>
                        <input type="text" readonly name="priceAfterDiscount" id="priceAfterDiscount" placeholder="Price After Discount" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="priceAfterDiscountErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="gst">GST<span class="text-danger">*</span></label>
                        <select name="gst" id="gst" class="selectpicker" data-style="btn-success btn-custom">
                            <option value="">Select GST</option>
                            <option value="0">0</option>
                            <option value="5">5</option>
                            <option value="12">12</option>
                            <option value="18">18</option>
                            <option value="28">28</option>
                        </select>
                       <span role="alert" id="gstErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="priceAfterGst">Price After GST<span class="text-danger">*</span></label>
                        <input type="text" readonly name="priceAfterGst" id="priceAfterGst" placeholder="Price After GST" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="priceAfterGstErr" style="color:red;font-size: 12px"></span>
                    </div>
            
                    <div class="form-group col-md-3">
                        <label for="quantity">Quantity<span class="text-danger">*</span></label>
                        <input type="text" name="quantity" id="quantity" placeholder="Quantity" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                       <span role="alert" id="quantityErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="payMode">Pay Mode<span class="text-danger">*</span></label>
                        <select name="payMode" id="payMode" class="selectpicker" data-style="btn-info btn-custom">
                            <option value="">Select Pay Mode</option>
                            <option value="{{ config('constants.payMode')['cod'] }}">{{ config('constants.payMode')['cod'] }}</option>
                            <option value="{{ config('constants.payMode')['online'] }}">{{ config('constants.payMode')['online'] }}</option>
                        </select>
                       <span role="alert" id="payModeErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="file"><strong>Note:&nbsp;</strong> Image Size should be 1MB to 2MB<span class="text-danger"></span></label>
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" name="file" id="file" class="dropify">
                                    </div>
                                    <span role="alert" id="fileErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-8">
                        <label for="description">Description<span class="text-danger">*</span></label>
                        <textarea name="description" id="description" cols="10" rows="10" parsley-trigger="change" placeholder="Description" class="summernote-product form-control"></textarea>
                        <span role="alert" id="descriptionErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>


                <br>
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
                <div class="form-group text-right m-b-0">
                    <button id="saveProductBtn" class="btn saveBtn waves-effect waves-light" type="submit"><i class="ti-save"></i> 
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div> <!-- end card-box -->
    </div>
</div>

@endsection