@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Update My Account</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">MyAccount</li>
            <li class="breadcrumb-item active">Update My Account</li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <!-- <h4 class="header-title m-t-0">Add New Admin</h4> -->
            <p class="text-muted font-14 m-b-20">
                
            </p>
            <form id="updateAdminForm" action="{{route('admin.update.usersAdmin')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="id" value="{{ $data['id'] }}">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ $data['name'] }}">
                        <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-12" style="display: none;">
                        <label for="email">Email<span class="text-danger"></span></label>
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{{ $data['email'] }}">
                        <span role="alert" id="emailErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-6">
                        <label for="phone">Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="{{ $data['phone'] }}">
                       <span role="alert" id="phoneErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-6">
                        <label for="password">Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control" value="">
                       <span role="alert" id="passwordErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-6">
                        <label for="confirmPassword">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" value="">
                       <span role="alert" id="confirmPasswordErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-12">
                        <label for="role">Role<span class="text-danger"></span></label>
                        <select name="role" id="role" class="selectpicker" data-style="btn-primary btn-custom">
                            <option value="">Select Role Type</option>
                            @foreach ($data['role'] as $item)
                            <option value="{{ $item['id'] }}" {{ ($item['id'] == $data['roleId']) ? 'selected' : '' }}>{{ $item['role'] }}</option>
                            @endforeach
                        </select>
                        <span role="alert" id="roleErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="col-md-12">
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
    
                    <div class="form-group col-md-12">
                        <label for="address">Address<span class="text-danger"></span></label>
                        <textarea name="address" id="address" cols="5" rows="5" parsley-trigger="change" placeholder="Address" class="form-control">{{ $data['address'] }}</textarea>
                        <span role="alert" id="addressErr" style="color:red;font-size: 12px"></span>
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
        </div> <!-- end card-box -->
    </div>
</div>



@endsection
