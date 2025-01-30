@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="{{ route('admin.show.client') }}" class="btn backBtn waves-effect waves-light"><i class=" ti-arrow-left"></i> Back</a>
        </div>
        <h4 class="page-title">Add New Client</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Users</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.show.client')}}">Client List</a></li>
            <li class="breadcrumb-item active">Add New Client</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <!-- <h4 class="header-title m-t-0">Add New Admin</h4> -->
            <p class="text-muted font-14 m-b-20">
                
            </p>
            <form id="saveClientForm" action="{{route('admin.save.client')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="">
                        <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="">
                       <span role="alert" id="emailErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="phone">Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="">
                       <span role="alert" id="phoneErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-8">
                        <label for="businessName">Business Name<span class="text-danger">*</span></label>
                        <input type="text" name="businessName" id="businessName" placeholder="Business Name" class="form-control" value="">
                        <span role="alert" id="businessNameErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="businessEmail">Business Email<span class="text-danger">*</span></label>
                        <input type="text" name="businessEmail" id="businessEmail" placeholder="Business Email" class="form-control" value="">
                       <span role="alert" id="businessEmailErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="address">Address<span class="text-danger">*</span></label>
                        <textarea name="address" id="address" cols="10" rows="10" parsley-trigger="change" placeholder="Address" class="form-control"></textarea>
                        <span role="alert" id="addressErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="businessAddress">Business Address<span class="text-danger">*</span></label>
                        <textarea name="businessAddress" id="businessAddress" cols="10" rows="10" parsley-trigger="change" placeholder="Business Address" class="form-control"></textarea>
                        <span role="alert" id="businessAddressErr" style="color:red;font-size: 12px"></span>
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
                </div>


                <br>
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
                <div class="form-group text-right m-b-0">
                    <button id="saveClientBtn" class="btn saveBtn waves-effect waves-light" type="submit"><i class="ti-save"></i> 
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div> <!-- end card-box -->
    </div>
</div>

@endsection