@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Profile</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <!-- <h4 class="header-title m-t-0">Add New Admin</h4> -->
            <p class="text-muted font-14 m-b-20">
                
            </p>
            <form id="updateAdminForm" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="id" value="{{ $data['id'] }}">

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ $data['name'] }}">
                        <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">Email<span class="text-danger"></span></label>
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{{ $data['email'] }}">
                        <span role="alert" id="emailErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="phone">Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="{{ $data['phone'] }}">
                       <span role="alert" id="phoneErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="orgName">Org Name<span class="text-danger">*</span></label>
                        <input type="text" name="orgName" id="orgName" placeholder="Org Name" class="form-control" value="{{ $data['orgName'] }}">
                        <span role="alert" id="orgNameErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="orgEmail">Org Email<span class="text-danger"></span></label>
                        <input type="text" name="orgEmail" id="orgEmail" placeholder="Org Email" class="form-control" value="{{ $data['orgEmail'] }}">
                        <span role="alert" id="orgEmailErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="orgPhone">Org Phone<span class="text-danger">*</span></label>
                        <input type="text" name="orgPhone" id="orgPhone" placeholder="Org Phone" class="form-control" value="{{ $data['orgPhone'] }}">
                       <span role="alert" id="orgPhoneErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="file">Image</label>
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
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="address">Personal Address<span class="text-danger"></span></label>
                        <textarea name="address" id="address" cols="5" rows="10" parsley-trigger="change" placeholder="Address" class="form-control">{{ $data['address'] }}</textarea>
                        <span role="alert" id="addressErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="orgAddress">Organization Address<span class="text-danger"></span></label>
                        <textarea name="orgAddress" id="orgAddress" cols="5" rows="10" parsley-trigger="change" placeholder="Address" class="form-control">{{ $data['orgAddress'] }}</textarea>
                        <span role="alert" id="orgAddressErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>


                <br>
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
                <div class="form-group text-right m-b-0">
                    <button id="updateAdminBtn" class="btn btn-primary waves-effect waves-light" type="submit"><i class="ti-save"></i> 
                        <span>Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection