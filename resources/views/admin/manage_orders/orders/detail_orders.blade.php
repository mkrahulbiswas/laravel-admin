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
                            <a href="#tabOne" data-toggle="tab" aria-expanded="true" class="nav-link active">Order Details</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabTwo" data-toggle="tab" aria-expanded="false" class="nav-link">Order Items</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabOne">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card" style="height: 100%;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <img src="{{ $data['user']['image'] }}" class="img-fluid" height="100px" width="150px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Client: &nbsp;&nbsp;</lable>
                                                                <a href="{{ route('admin.details.client', $data['user']['id']) }}" target="_blank">{{ $data['user']['name'] }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Phone: &nbsp;&nbsp;</lable>
                                                                <a href="tel:{{ $data['user']['phone'] }}">{{ $data['user']['phone'] }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Email: &nbsp;&nbsp;</lable>
                                                                <a href="mailto:{{ $data['user']['email'] }}">{{ $data['user']['email'] }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card" style="height: 100%;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Order ID: &nbsp;&nbsp;</lable>{{ $data['uniqueId'] }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Order Date: &nbsp;&nbsp;</lable>{{ $data['orderDate'] }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Order Status: &nbsp;&nbsp;</lable>{!! $data['status'] !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Order Pay Mode: &nbsp;&nbsp;</lable>{!! $data['payMode'] !!}
                                                            </div>
                                                        </div>
                                                        @if ($data['statusMain'] == config('constants.status')['rejected'] || $data['statusMain'] == config('constants.status')['canceled'])
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                @if ($data['statusMain'] == config('constants.status')['rejected'])
                                                                <lable class="font-weight-bold">Rjection Reason: &nbsp;&nbsp;</lable>{{  $data['reason']  }}
                                                                @else
                                                                <lable class="font-weight-bold">Cancelation Reason: &nbsp;&nbsp;</lable>{{  $data['reason']  }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Transaction ID: &nbsp;&nbsp;</lable>{{  $data['transaction']['uniqueId']  }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Tran Status: &nbsp;&nbsp;</lable>{{  $data['transaction']['status']  }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Total Paid Amount: &nbsp;&nbsp;</lable>{{  $data['transaction']['amount']  }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Delevary Address:----- &nbsp;&nbsp;</lable>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Landmark: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->landmark }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Address: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->address }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">City: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->city }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">State: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->state }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Country: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->country }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Pin Code: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->pinCode }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Contact Number: &nbsp;&nbsp;</lable>{{ $data['deliveredAddress']->contactNumber }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                    <table id="responsive-datatable" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <td>Image</td>
                                                <td>Name</td>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Final Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                        
                                        <tbody>
                                            @foreach ($data['product'] as $key => $item)
                                                <tr>
                                                    <td>{{ ($key+1) }}</td>
                                                    <td>
                                                        <img src="{{ $item['image'] }}" alt="" width="100">
                                                    </td>
                                                    <td>
                                                        <span title="{{ $item['name'] }}">{{ $item['nameShort'] }}</span>
                                                    </td>
                                                    <td>{{ number_format($item['priceAfterGst'], 2) }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ number_format(($item['priceAfterGst'] * $item['quantity']), 2) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.details.product', $item['id']) }}" target="_blank">
                                                            <i class="md md-visibility" style="font-size: 20px; color: green;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
