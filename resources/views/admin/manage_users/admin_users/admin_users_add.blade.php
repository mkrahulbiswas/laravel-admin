@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Add New Admin Users</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Users</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.show.adminUsers') }}">Admin Users</a></li>
                            <li class="breadcrumb-item active">Add New Admin Users</li>
                        </ol>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between">
                    @if ($permission['back']['permission'] == true)
                        <a href="{{ route('admin.show.adminUsers') }}" class="btn btn-warning btn-label waves-effect waves-light">
                            <i class="las la-backward label-icon align-middle fs-16 me-2"></i>
                            <span>Back</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row main-page-content">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title mb-0">Form to create a new admin user</h5>
                            <span>Test</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 formElementMain">
                            <div class="formElementSub">
                                <form id="saveAdminUsersForm" action="{{ route('admin.save.adminUsers') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-4">
                                            <div class="card cardForm">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0">Basic Info</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Name">
                                                                <i class="bx bx-message-edit"></i>
                                                            </div>
                                                            <div class="validation-error" id="nameErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="email" class="form-label">Email <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="email" class="form-control form-control-icon" id="email" placeholder="Email">
                                                                <i class="mdi mdi-email-edit-outline"></i>
                                                            </div>
                                                            <div class="validation-error" id="emailErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="phone" class="form-label">Phone <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="phone" class="form-control form-control-icon" id="phone" placeholder="Phone">
                                                                <i class="mdi mdi-phone"></i>
                                                            </div>
                                                            <div class="validation-error" id="phoneErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="roleMain" class="form-label">Role Main <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <select name="roleMain" id="roleMain" class="selectTwo select2-roleMain roleMainDDD" data-action="{{ route('admin.get.roleSubDDD') }}">
                                                                    <option value="">Select Role Main</option>
                                                                    @foreach ($data['roleMain'] as $item)
                                                                        <option value="{{ $item['id'] }}" data-exist="{{ $item['extraData']['hasRoleSub'] }}">{{ $item['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <i class="bx bx-receipt"></i>
                                                            </div>
                                                            <div class="validation-error" id="roleMainErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4" style="display: none;">
                                                            <label for="roleSub" class="form-label">Role Sub <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <select name="roleSub" id="roleSub" class="selectTwo select2-roleSub roleSubDDD">
                                                                    <option value="">Select Role Sub</option>
                                                                </select>
                                                                <i class="bx bx-bar-chart-square"></i>
                                                            </div>
                                                            <div class="validation-error" id="roleSubErr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-4">
                                            <div class="card cardForm">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0">Address Info</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="pinCode" class="form-label">Pin Code <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="pinCode" class="form-control form-control-icon" id="pinCode" placeholder="Pin Code">
                                                                <i class="las la-location-arrow"></i>
                                                            </div>
                                                            <div class="validation-error" id="pinCodeErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="state" class="form-label">State <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="state" class="form-control form-control-icon" id="state" placeholder="State">
                                                                <i class="las la-location-arrow"></i>
                                                            </div>
                                                            <div class="validation-error" id="stateErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                            <label for="country" class="form-label">Country <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="country" class="form-control form-control-icon" id="country" placeholder="Country">
                                                                <i class="las la-location-arrow"></i>
                                                            </div>
                                                            <div class="validation-error" id="countryErr"></div>
                                                        </div>
                                                        <div class="form-element col-12">
                                                            <label for="address" class="form-label">Address <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="input-group set-validation">
                                                                <span class="input-group-text">
                                                                    <i class="las la-address-card"></i>
                                                                </span>
                                                                <textarea name="address" class="form-control" aria-label="With textarea" id="address" role="5" cols="5" placeholder="Give your address"></textarea>
                                                            </div>
                                                            <div class="validation-error" id="addressErr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-4">
                                            <div class="card cardForm">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0">About my self</h6>
                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                                                            <label for="about" class="form-label">Profile Pic</label>
                                                            <div class="input-group set-validation">
                                                                <input type="file" name="file" id="file" class="dropify" data-max-file-size="1M">
                                                            </div>
                                                            <div class="validation-error" id="fileErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-8 col-xl-9">
                                                            <label for="about" class="form-label">About</label>
                                                            <div class="input-group set-validation">
                                                                <textarea name="about" class="form-control sn-adminUser-about summernote" aria-label="With textarea" id="about" placeholder="Write something about you"></textarea>
                                                            </div>
                                                            <div class="validation-error" id="aboutErr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-element col-12 mt-3">
                                            <div class="col-md border border-1 border-bottom border-success"></div>
                                        </div>
                                        <div class="form-element col-12 text-center mt-3">
                                            @if ($permission['reload']['permission'] == true)
                                                <button type="button" class="btn btn-danger btn-label waves-effect waves-light" onclick="window.location.reload()">
                                                    <i class="mdi mdi-reload label-icon align-middle fs-16 me-2"></i>
                                                    <span>Reload</span>
                                                </button>
                                            @endif
                                            @if ($permission['save']['permission'] == true)
                                                <button type="submit" class="btn btn-primary btn-label waves-effect waves-light ms-2" id="saveAdminUsersBtn">
                                                    <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                                    <span>Save</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
