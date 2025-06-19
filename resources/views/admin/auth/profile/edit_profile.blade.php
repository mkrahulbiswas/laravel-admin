@extends('admin.layouts.app')
@section('content')
    <div class="position-relative profileCover mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ asset('assets/media/admin/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                            <img src="{{ $data['detail']['getFile']['public']['fullPath']['asset'] }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="link-primary changeModal" data-bs-toggle="modal" data-bs-target="#con-change-modal" data-type="password">Forgot password?</a>
                        <a href="javascript:void(0);" class="link-primary changeModal" data-bs-toggle="modal" data-bs-target="#con-change-modal" data-type="pin">Forgot pin?</a>
                        <h5 class="fs-16 mb-1">{{ $data['detail']['name'] }}</h5>
                        <p class="text-muted mb-0">{{ $data['detail']['subRole'] == [] ? $data['detail']['mainRole']['name'] : $data['detail']['subRole']['name'] }}</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Portfolio</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-add-fill align-bottom me-1"></i> Add</a>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-body text-body">
                                <i class="ri-github-fill"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" id="gitUsername" placeholder="Username" value="@daveadame">
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-primary">
                                <i class="ri-global-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com" value="www.velzon.com">
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-success">
                                <i class="ri-dribbble-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="dribbleName" placeholder="Username" value="@dave_adame">
                    </div>
                    <div class="d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-danger">
                                <i class="ri-pinterest-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="pinterestName" placeholder="Username" value="Advance Dave">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePasswordPin" role="tab">
                                <i class="far fa-user"></i> Change Password & Pin
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form id="updateAuthProfileForm" action="{{ route('admin.update.authProfile') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['detail']['id'] }}">
                                <input type="hidden" name="uniqueId" value="{{ $data['detail']['uniqueId']['raw'] }}">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="row">
                                            <div class="form-element col-12 mb-3">
                                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                <div class="form-icon set-validation">
                                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Name" value="{{ $data['detail']['name'] }}">
                                                    <i class="bx bx-message-edit"></i>
                                                </div>
                                                <div class="validation-error" id="nameErr"></div>
                                            </div>
                                            <div class="form-element col-12 mb-3">
                                                <label for="about" class="form-label">About</label>
                                                <div class="input-group set-validation">
                                                    <textarea name="about" class="form-control sn-adminUser-about summernote" aria-label="With textarea" id="about" placeholder="Write something about you">{{ $data['detail']['about'] }}</textarea>
                                                </div>
                                                <div class="validation-error" id="aboutErr"></div>
                                            </div>
                                            {{-- <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                <label for="email" class="form-label">Email <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                <div class="form-icon set-validation">
                                                    <input type="text" name="email" class="form-control form-control-icon" id="email" placeholder="Email" value="{{ $data['detail']['email'] }}">
                                                    <i class="mdi mdi-email-edit-outline"></i>
                                                </div>
                                                <div class="validation-error" id="emailErr"></div>
                                            </div>
                                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                                <label for="phone" class="form-label">Phone <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                <div class="form-icon set-validation">
                                                    <input type="text" name="phone" class="form-control form-control-icon" id="phone" placeholder="Phone" value="{{ $data['detail']['phone'] }}">
                                                    <i class="mdi mdi-phone"></i>
                                                </div>
                                                <div class="validation-error" id="phoneErr"></div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="row">
                                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                <label for="pinCode" class="form-label">Pin Code <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                <div class="form-icon set-validation">
                                                    <input type="text" name="pinCode" class="form-control form-control-icon" id="pinCode" placeholder="Pin Code" value="{{ $data['detail']['pinCode'] }}">
                                                    <i class="las la-location-arrow"></i>
                                                </div>
                                                <div class="validation-error" id="pinCodeErr"></div>
                                            </div>
                                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                <label for="state" class="form-label">State <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                <div class="form-icon set-validation">
                                                    <input type="text" name="state" class="form-control form-control-icon" id="state" placeholder="State" value="{{ $data['detail']['state'] }}">
                                                    <i class="las la-location-arrow"></i>
                                                </div>
                                                <div class="validation-error" id="stateErr"></div>
                                            </div>
                                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                <label for="country" class="form-label">Country <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                <div class="form-icon set-validation">
                                                    <input type="text" name="country" class="form-control form-control-icon" id="country" placeholder="Country" value="{{ $data['detail']['country'] }}">
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
                                                    <textarea name="address" class="form-control" aria-label="With textarea" id="address" rows="5" cols="50" placeholder="Give your address">{{ $data['detail']['address'] }}</textarea>
                                                </div>
                                                <div class="validation-error" id="addressErr"></div>
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
                                        @if ($permission['update']['permission'] == true)
                                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light ms-2" id="updateAuthProfileBtn">
                                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                                <span>Update</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="changePasswordPin" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="card border card-border-warning">
                                        <div class="card-header bg-warning-subtle">
                                            <h6 class="card-title mb-0">Change login password</h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="updateAuthPasswordForm" action="{{ route('admin.change.authPassword') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data['detail']['id'] }}">
                                                <div class="row">
                                                    <div class="form-element col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                                                        <label for="oldPassword" class="form-label">Old Password <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                        <div class="form-icon set-validation">
                                                            <input type="text" name="oldPassword" class="form-control form-control-icon" id="oldPassword" placeholder="Old Password" value="">
                                                            <i class="las la-hospital"></i>
                                                        </div>
                                                        <div class="validation-error" id="oldPasswordErr"></div>
                                                    </div>
                                                    <div class="form-element col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                                                        <label for="newPassword" class="form-label">New Password <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                        <div class="form-icon set-validation">
                                                            <input type="text" name="newPassword" class="form-control form-control-icon" id="newPassword" placeholder="New Password" value="">
                                                            <i class="las la-hospital"></i>
                                                        </div>
                                                        <div class="validation-error" id="newPasswordErr"></div>
                                                    </div>
                                                    <div class="form-element col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                                                        <label for="confirmPassword" class="form-label">Confirm Password <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                        <div class="form-icon set-validation">
                                                            <input type="text" name="confirmPassword" class="form-control form-control-icon" id="confirmPassword" placeholder="Confirm Password" value="">
                                                            <i class="las la-hospital"></i>
                                                        </div>
                                                        <div class="validation-error" id="confirmPasswordErr"></div>
                                                    </div>
                                                    <div class="form-element col-12 mt-3">
                                                        <div class="col-md border border-1 border-bottom border-success"></div>
                                                    </div>
                                                    <div class="form-element col-12 text-center mt-3">
                                                        @if ($permission['update']['permission'] == true)
                                                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light ms-2" id="updateAuthPasswordBtn">
                                                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                                                <span>Update Password</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="card border card-border-success">
                                        <div class="card-header bg-success-subtle">
                                            <h6 class="card-title mb-0">Change profile pin</h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="updateAuthPinForm" action="{{ route('admin.change.authPin') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data['detail']['id'] }}">
                                                <div class="row">
                                                    <div class="form-element col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                                                        <label for="oldPin" class="form-label">Old PIN <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                        <div class="form-icon set-validation">
                                                            <input type="text" name="oldPin" class="form-control form-control-icon" id="oldPin" placeholder="Old PIN" value="">
                                                            <i class="las la-map-pin"></i>
                                                        </div>
                                                        <div class="validation-error" id="oldPinErr"></div>
                                                    </div>
                                                    <div class="form-element col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                                                        <label for="newPin" class="form-label">New PIN <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                        <div class="form-icon set-validation">
                                                            <input type="text" name="newPin" class="form-control form-control-icon" id="newPin" placeholder="New PIN" value="">
                                                            <i class="las la-map-pin"></i>
                                                        </div>
                                                        <div class="validation-error" id="newPinErr"></div>
                                                    </div>
                                                    <div class="form-element col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                                                        <label for="confirmPin" class="form-label">Confirm PIN <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                        <div class="form-icon set-validation">
                                                            <input type="text" name="confirmPin" class="form-control form-control-icon" id="confirmPin" placeholder="Confirm PIN" value="">
                                                            <i class="las la-map-pin"></i>
                                                        </div>
                                                        <div class="validation-error" id="confirmPinErr"></div>
                                                    </div>
                                                    <div class="form-element col-12 mt-3">
                                                        <div class="col-md border border-1 border-bottom border-success"></div>
                                                    </div>
                                                    <div class="form-element col-12 text-center mt-3">
                                                        @if ($permission['update']['permission'] == true)
                                                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light ms-2" id="updateAuthPinBtn">
                                                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                                                <span>Update PIN</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-3 border-bottom pb-2">
                                <div class="float-end">
                                    <a href="javascript:void(0);" class="link-primary">All Logout</a>
                                </div>
                                <h5 class="card-title">Login History</h5>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-smartphone-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>iPhone 12 Pro</h6>
                                    <p class="text-muted mb-0">Los Angeles, United States - March 16 at
                                        2:47PM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-tablet-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Apple iPad Pro</h6>
                                    <p class="text-muted mb-0">Washington, United States - November 06
                                        at 10:43AM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-smartphone-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Galaxy S21 Ultra 5G</h6>
                                    <p class="text-muted mb-0">Conneticut, United States - June 12 at
                                        3:24PM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                        <i class="ri-macbook-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Dell Inspiron 14</h6>
                                    <p class="text-muted mb-0">Phoenix, United States - July 26 at
                                        8:10AM</p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="con-change-modal" class="modal fade con-change-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forget <span class="changeType"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-bottom-2">
                    <div class="row">
                        <div class="col-12 sendOtp">
                            <div class="card m-0">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 text-success">Trying to reset <span class="changeType"></span></h5>
                                    <p class="card-text">To reset your profile <b><span class="changeType"></span></b> you need to follow few steps.</p>
                                    <p class="card-text">1) You need to click on <b>Next</b> button to start first step, where an <b>OTP</b> send to your registered email ({{ $data['detail']['email'] }}).</p>
                                    {{-- <p class="card-text">2) Next you need to verify OTP. For thant you need to  and click on <b>Verify</b> button</p> --}}
                                    <p class="card-text">
                                        <small class="text-warning">Note: this steps is to send OTP</small>
                                    </p>
                                    <div class="col-md border border-1 border-bottom border-success-subtle mb-2"></div>
                                    <form id="resetAuthSendForm" action="{{ route('admin.reset.authSend') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data['detail']['id'] }}">
                                        <input type="hidden" name="type" class="type" value="">
                                        <div class="text-end">
                                            @if ($permission['send']['permission'] == true)
                                                <button type="submit" class="btn btn-ghost-primary waves-effect waves-light" id="resetAuthSendBtn">
                                                    <span>Click to send OTP</span>
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 verifyOtp">
                            <div class="card m-0">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 text-success">Trying to reset <span class="changeType"></span></h5>
                                    <p class="card-text">To reset your profile <b><span class="changeType"></span></b> you need to follow few steps.</p>
                                    <p class="card-text">2) Next you need to verify <b>OTP</b>. For that you need to put the <b>OTP</b> inside the form and need to click on <b>Verify</b> button.</p>
                                    <p class="card-text">
                                        <small class="text-warning">Note: this steps to verify OTP</small>
                                    </p>
                                    <form id="resetAuthVerifyForm" action="{{ route('admin.reset.authVerify') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data['detail']['id'] }}">
                                        <input type="hidden" name="type" class="type" value="">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <div class="bg-info-subtle p-3 rounded-2">
                                                    <div class="row justify-content-center">
                                                        <div class="form-element col-10">
                                                            <label for="otp" class="form-label">Please Put Your OTP <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="otp" class="form-control form-control-icon" id="otp" placeholder="Your OTP" value="">
                                                                <i class="bx bx-message-edit"></i>
                                                            </div>
                                                            <div class="validation-error" id="otpErr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="col-md border border-1 border-bottom border-success-subtle"></div>
                                            </div>
                                            <div class="col-12 text-end">
                                                @if ($permission['verify']['permission'] == true)
                                                    <button type="submit" class="btn btn-ghost-primary waves-effect waves-light" id="resetAuthVerifyBtn">
                                                        <span>Verify OTP</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 resetPassword">
                            <div class="card m-0">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 text-success">Trying to reset <span class="changeType"></span></h5>
                                    <p class="card-text">To reset your profile <b><span class="changeType"></span></b> you need to follow few steps.</p>
                                    <p class="card-text">3) New you need to give valid <b>password</b> inside the form and after that you need to click on <b>update password</b> button.</p>
                                    <p class="card-text">
                                        <small class="text-warning">Note: this steps to reset <span class="changeType"></span></small>
                                    </p>
                                    <form id="resetAuthUpdateForm" action="{{ route('admin.reset.authUpdate') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data['detail']['id'] }}">
                                        <input type="hidden" name="type" class="type" value="">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <div class="bg-info-subtle p-3 rounded-2 pinForm">
                                                    <div class="row justify-content-center">
                                                        <div class="form-element col-sm-12 col-md-12 col-lg-10 col-xl-10 mb-3">
                                                            <label for="newPin" class="form-label">New Pin <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="newPin" class="form-control form-control-icon" id="newPin" placeholder="New Pin" value="">
                                                                <i class="bx bx-message-edit"></i>
                                                            </div>
                                                            <div class="validation-error" id="newPinErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                                            <label for="confirmPin" class="form-label">Confirm Pin <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="confirmPin" class="form-control form-control-icon" id="confirmPin" placeholder="Confirm Pin" value="">
                                                                <i class="bx bx-message-edit"></i>
                                                            </div>
                                                            <div class="validation-error" id="confirmPinErr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-info-subtle p-3 rounded-2 passwordForm">
                                                    <div class="row justify-content-center">
                                                        <div class="form-element col-sm-12 col-md-12 col-lg-10 col-xl-10 mb-3">
                                                            <label for="newPassword" class="form-label">New Password <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="newPassword" class="form-control form-control-icon" id="newPassword" placeholder="New Password" value="">
                                                                <i class="bx bx-message-edit"></i>
                                                            </div>
                                                            <div class="validation-error" id="newPasswordErr"></div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                                            <label for="confirmPassword" class="form-label">Confirm Password <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                                            <div class="form-icon set-validation">
                                                                <input type="text" name="confirmPassword" class="form-control form-control-icon" id="confirmPassword" placeholder="Confirm Password" value="">
                                                                <i class="bx bx-message-edit"></i>
                                                            </div>
                                                            <div class="validation-error" id="confirmPasswordErr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="col-md border border-1 border-bottom border-success-subtle"></div>
                                            </div>
                                            <div class="col-12 text-end">
                                                @if ($permission['update']['permission'] == true)
                                                    <button type="submit" class="btn btn-ghost-primary waves-effect waves-light" id="resetAuthUpdateBtn">
                                                        <span>Update and change</span>
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
    </div>
@endsection

@section('footScripts')
    <script>
        $('document').ready(function() {
            let targetModal = $('#con-change-modal');
            $('.changeModal').click(function() {
                targetModal.find('.verifyOtp, .resetPassword, .pinForm, .passwordForm').hide()
                let targetClass = $(this),
                    type = targetClass.attr('data-type');
                if (type == 'pin') {
                    changeButtonType = 'Update PIN'
                    targetModal.find('.pinForm').show()
                } else {
                    changeButtonType = 'Update Password'
                    targetModal.find('.passwordForm').show()
                }
                targetModal.find('.changeType, #myModalLabel').text(type)
                targetModal.find('.changeButtonType').text(changeButtonType)
                targetModal.find('.type').val(type)
            })
            targetModal.on("hidden.bs.modal", function() {
                targetModal.find('.verifyOtp, .resetPassword, .pinForm, .passwordForm').hide()
                targetModal.find('.sendOtp').show()
            })
        });
    </script>
@stop
