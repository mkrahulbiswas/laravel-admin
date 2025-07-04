@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Admin Users Detail</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Users</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.show.adminUsers') }}">Admin Users</a></li>
                            <li class="breadcrumb-item active">Admin Users Detail</li>
                        </ol>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between">
                    @if ($permission['back']['permission'] == true)
                        <button type="button" onClick="javascript:window.close('','_parent','');" class="btn btn-danger btn-label waves-effect waves-light">
                            <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                            <span>Close</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-lg-12 m-b-20">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header cardHeader" id="headingTwo">
                                    <h6 class="m-0">
                                        <a href="#collapseTwo" class="collapsed text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapseTwo">Profile Information</a>
                                    </h6>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body cardBody">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <lable class="font-weight-bold">Image: &nbsp;&nbsp;</lable>
                                                    <img src="{{ $data['image'] }}" class="img-fluid" height="100px" width="100px">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <lable class="font-weight-bold">Name: &nbsp;&nbsp;</lable>{{ ucwords($data['name']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <lable class="font-weight-bold">Phone: &nbsp;&nbsp;</lable>
                                                    <a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <lable class="font-weight-bold">Role: &nbsp;&nbsp;</lable>
                                                    {{ $data['role'] }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <lable class="font-weight-bold">Address: &nbsp;&nbsp;</lable>{{ $data['address'] }}
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
        </div>
    </div> --}}
@endsection
