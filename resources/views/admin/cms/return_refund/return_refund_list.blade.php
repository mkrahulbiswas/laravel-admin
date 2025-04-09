@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Return & Refund Policy</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CMS</a></li>
            <li class="breadcrumb-item active">Return & Refund Policy</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            
            <form action="{{ route('admin.update.returnRefund') }}" id="updateReturnRefundForm" method="POST" enctype="multipart/form-data">
                
                @csrf

                <input type="hidden" name="id" value="{{  $data['id']  }}">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="return">Return<span class="text-danger">*</span></label>
                        <textarea type="text" name="return" id="return" cols="5" rows="5" class="summernote-one form-control">{{ $data['return'] }}</textarea>
                        <span role="alert" id="returnErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="refund">Refund<span class="text-danger">*</span></label>
                        <textarea type="text" name="refund" id="refund" cols="5" rows="5" class="summernote-one form-control">{{ $data['refund'] }}</textarea>
                        <span role="alert" id="refundErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>
                
                @if($itemPermission['edit_item']=='1')
                <div class="form-group text-right m-b-0 m-t-30">
                    <button class="btn saveBtn waves-effect waves-light" id="updateReturnRefundBtn" type="submit">
                        <i class="ti-save"></i>
                        <span>Update</span>
                    </button>
                </div>
                @endif

            </form>

        </div>
    </div>
</div>


@endsection
