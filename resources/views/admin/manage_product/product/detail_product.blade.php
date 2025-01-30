@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="#" onClick="javascript:window.close('','_parent','');" class="btn closeBtn waves-effect waves-light m-l-15"><i class="ti-close"></i> Close</a>
        </div>
        <h4 class="page-title">Manage Product Details</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Package Master</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.show.product') }}">Manage Product List</a></li>
            <li class="breadcrumb-item active">Manage Product Details</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            

            <div class="row">
                <div class="col-lg-12 m-b-20">

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#tabOne" data-toggle="tab" aria-expanded="true" class="nav-link active">Product Detail</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabTwo" data-toggle="tab" aria-expanded="false" class="nav-link">Product Images</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabOne">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable class="font-weight-bold">Image: &nbsp;&nbsp;</lable>
                                                <img src="{{ $data['image'] }}" class="img-fluid" height="100px" width="150px">
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Name: &nbsp;&nbsp;</lable>{{ ucwords($data['name']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Category: &nbsp;&nbsp;</lable>{{ $data['category'] }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Units: &nbsp;&nbsp;</lable>{{ $data['units'] }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Quantity: &nbsp;&nbsp;</lable>{{ $data['quantity'] }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Price: &nbsp;&nbsp;</lable>{{ number_format($data['price'], 2) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Discount: &nbsp;&nbsp;</lable>{{ number_format($data['discount'], 2) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Price After Discount: &nbsp;&nbsp;</lable>{{ number_format($data['priceAfterDiscount'], 2) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">GST (%): &nbsp;&nbsp;</lable>{{ $data['gst'] }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Price After GST: &nbsp;&nbsp;</lable>{{ number_format($data['priceAfterGst'], 2) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Pay Mode: &nbsp;&nbsp;</lable>{{ $data['payMode'] }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Status: &nbsp;&nbsp;</lable>{!! $data['status'] !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Featured: &nbsp;&nbsp;</lable>{!! $data['featured'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <lable class="font-weight-bold">Content: &nbsp;&nbsp;</lable>{!! $data['description'] !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="tabTwo">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="button" data-toggle="modal" data-target="#con-add-modal"  class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add New Category</button>
                                </div>
                                <div class="col-md-12"><hr></div>
                                <div class="col-md-12 p-0 m-0">
                                    <table id="manageProduct-productImage-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <td>Image</td>
                                                <td>Status</td>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                        
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-add-modal" data-type="logo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Product Image</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="saveProductImageForm" action="{{ route('admin.saveImage.product') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf
                        <input type="hidden" name="product" value="{{ $data['id'] }}">
                        <div class="modal-body">
                            <div class="row">

                                <div class="form-group col-md-12">
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

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal">Close</button>
                            <button type="submit" id="saveProductImageBtn"  class="btn saveBtn waves-effect waves-light">
                                <i class="ti-save"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
