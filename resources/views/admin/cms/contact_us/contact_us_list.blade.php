@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Contact Us</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CMS</a></li>
            <li class="breadcrumb-item active">Contact Us</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            
            <form action="{{ route('admin.update.contactUs') }}" id="updateContactUsForm" method="POST" enctype="multipart/form-data">
                
                @csrf

                <input type="hidden" name="id" value="{{  $data['id']  }}">

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="phone">Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="{{ $data['phone'] }}">
                        <span role="alert" id="phoneErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{{ $data['email'] }}">
                        <span role="alert" id="emailErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-6">
                        <label for="googleMap">Google Map<span class="text-danger">*</span></label>
                        <input type="text" name="googleMap" id="googleMap" placeholder="Google Map" class="form-control" value="{{ $data['googleMap'] }}">
                        <span role="alert" id="googleMapErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-6">
                        <label for="address">Address<span class="text-danger">*</span></label>
                        <textarea type="text" name="address" id="address" class="form-control" cols="5" rows="5">{{ $data['address'] }}</textarea>
                        <span role="alert" id="addressErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>
                
                @if($itemPermission['edit_item']=='1')
                <div class="form-group text-right m-b-0 m-t-30">
                    <button class="btn saveBtn waves-effect waves-light" id="updateContactUsBtn" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                </div>
                @endif

            </form>

        </div>
    </div>
</div>


@endsection
