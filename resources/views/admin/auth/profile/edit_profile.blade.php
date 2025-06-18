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
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab">
                                <i class="far fa-envelope"></i> Experience
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i> Privacy Policy
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
                        <div class="tab-pane" id="experience" role="tabpanel">
                            <form>
                                <div id="newlink">
                                    <div id="1">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="jobTitle" class="form-label">Job
                                                        Title</label>
                                                    <input type="text" class="form-control" id="jobTitle" placeholder="Job title" value="Lead Designer / Developer">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="companyName" class="form-label">Company
                                                        Name</label>
                                                    <input type="text" class="form-control" id="companyName" placeholder="Company name" value="Themesbrand">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="experienceYear" class="form-label">Experience Years</label>
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <select class="form-control" data-choices data-choices-search-false name="experienceYear" id="experienceYear">
                                                                <option value="">Select years</option>
                                                                <option value="Choice 1">2001</option>
                                                                <option value="Choice 2">2002</option>
                                                                <option value="Choice 3">2003</option>
                                                                <option value="Choice 4">2004</option>
                                                                <option value="Choice 5">2005</option>
                                                                <option value="Choice 6">2006</option>
                                                                <option value="Choice 7">2007</option>
                                                                <option value="Choice 8">2008</option>
                                                                <option value="Choice 9">2009</option>
                                                                <option value="Choice 10">2010</option>
                                                                <option value="Choice 11">2011</option>
                                                                <option value="Choice 12">2012</option>
                                                                <option value="Choice 13">2013</option>
                                                                <option value="Choice 14">2014</option>
                                                                <option value="Choice 15">2015</option>
                                                                <option value="Choice 16">2016</option>
                                                                <option value="Choice 17" selected>2017
                                                                </option>
                                                                <option value="Choice 18">2018</option>
                                                                <option value="Choice 19">2019</option>
                                                                <option value="Choice 20">2020</option>
                                                                <option value="Choice 21">2021</option>
                                                                <option value="Choice 22">2022</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-auto align-self-center">
                                                            to
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <select class="form-control" data-choices data-choices-search-false name="choices-single-default2">
                                                                <option value="">Select years</option>
                                                                <option value="Choice 1">2001</option>
                                                                <option value="Choice 2">2002</option>
                                                                <option value="Choice 3">2003</option>
                                                                <option value="Choice 4">2004</option>
                                                                <option value="Choice 5">2005</option>
                                                                <option value="Choice 6">2006</option>
                                                                <option value="Choice 7">2007</option>
                                                                <option value="Choice 8">2008</option>
                                                                <option value="Choice 9">2009</option>
                                                                <option value="Choice 10">2010</option>
                                                                <option value="Choice 11">2011</option>
                                                                <option value="Choice 12">2012</option>
                                                                <option value="Choice 13">2013</option>
                                                                <option value="Choice 14">2014</option>
                                                                <option value="Choice 15">2015</option>
                                                                <option value="Choice 16">2016</option>
                                                                <option value="Choice 17">2017</option>
                                                                <option value="Choice 18">2018</option>
                                                                <option value="Choice 19">2019</option>
                                                                <option value="Choice 20" selected>2020
                                                                </option>
                                                                <option value="Choice 21">2021</option>
                                                                <option value="Choice 22">2022</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="jobDescription" class="form-label">Job
                                                        Description</label>
                                                    <textarea class="form-control" id="jobDescription" rows="3" placeholder="Enter description">You always want to make sure that your fonts work well together and try to limit the number of fonts you use to three or less. Experiment and play around with the fonts that you already have in the software you're working with reputable font websites. </textarea>
                                                </div>
                                            </div>
                                            <div class="hstack gap-2 justify-content-end">
                                                <a class="btn btn-success" href="javascript:deleteEl(1)">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="newForm" style="display: none;">

                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="javascript:new_link()" class="btn btn-primary">Add
                                            New</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-4 pb-2">
                                <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Two-factor Authentication</h6>
                                        <p class="text-muted">Two-factor authentication is an enhanced
                                            security meansur. Once enabled, you'll be required to give
                                            two types of identification when you log into Google
                                            Authentication and SMS are Supported.</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Enable Two-facor
                                            Authentication</a>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Secondary Verification</h6>
                                        <p class="text-muted">The first factor is a password and the
                                            second commonly includes a text with a code sent to your
                                            smartphone, or biometrics using your fingerprint, face, or
                                            retina.</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Set
                                            up secondary method</a>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Backup Codes</h6>
                                        <p class="text-muted mb-sm-0">A backup code is automatically
                                            generated for you when you turn on two-factor authentication
                                            through your iOS or Android Twitter app. You can also
                                            generate a backup code on twitter.com.</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Generate backup codes</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h5 class="card-title text-decoration-underline mb-3">Application
                                    Notifications:</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex">
                                        <div class="flex-grow-1">
                                            <label for="directMessage" class="form-check-label fs-14">Direct messages</label>
                                            <p class="text-muted">Messages from people you follow</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="directMessage" checked />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="desktopNotification">
                                                Show desktop notifications
                                            </label>
                                            <p class="text-muted">Choose the option you want as your
                                                default setting. Block a site: Next to "Not allowed to
                                                send notifications," click Add.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="desktopNotification" checked />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="emailNotification">
                                                Show email notifications
                                            </label>
                                            <p class="text-muted"> Under Settings, choose Notifications.
                                                Under Select an account, choose the account to enable
                                                notifications for. </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="emailNotification" />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="chatNotification">
                                                Show chat notifications
                                            </label>
                                            <p class="text-muted">To prevent duplicate mobile
                                                notifications from the Gmail and Chat apps, in settings,
                                                turn off Chat notifications.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="chatNotification" />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="purchaesNotification">
                                                Show purchase notifications
                                            </label>
                                            <p class="text-muted">Get real-time purchase alerts to
                                                protect yourself from fraudulent charges.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="purchaesNotification" />
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="card-title text-decoration-underline mb-3">Delete This
                                    Account:</h5>
                                <p class="text-muted">Go to the Data & Privacy section of your profile
                                    Account. Scroll to "Your data & privacy options." Delete your
                                    Profile Account. Follow the instructions to delete your account :
                                </p>
                                <div>
                                    <input type="password" class="form-control" id="passwordInput" placeholder="Enter your password" value="make@321654987" style="max-width: 265px;">
                                </div>
                                <div class="hstack gap-2 mt-3">
                                    <a href="javascript:void(0);" class="btn btn-soft-danger">Close &
                                        Delete This Account</a>
                                    <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
