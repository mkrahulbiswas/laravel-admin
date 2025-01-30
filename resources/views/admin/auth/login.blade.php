@extends('admin.layouts.app')
@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="{{ asset('assets/media/admin/images/logo-light.png') }}" alt=""
                                    height="20">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Velzon.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form id="checkLoginForm" action="{{ route('check.login') }}" method="POST"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Username</label>
                                        <input type="text" name="phone" class="form-control" id="email"
                                            placeholder="Enter Phone Number" required>
                                        <div class="invalid-feedback" id="emailErr"></div>
                                        {{-- <div class="invalid-feedback">
                                            Please choose a username.
                                        </div> --}}

                                        {{-- <span role="alert" id="emailErr" style="color:red; font-size: 12px"></span> --}}
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="auth-pass-reset-basic.html" class="text-muted">Forgot
                                                password?</a>
                                        </div>
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input"
                                                placeholder="Enter password" name="password" id="password">
                                            <div class="invalid-feedback" id="passwordErr"></div>

                                            {{-- <span role="alert" id="passwordErr" style="color:red; font-size: 12px"></span> --}}

                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Remember
                                            me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit" id="checkLoginBtn">Sign
                                            In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>
                                        <div>
                                            <button type="button"
                                                class="btn btn-primary btn-icon waves-effect waves-light"><i
                                                    class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button"
                                                class="btn btn-danger btn-icon waves-effect waves-light"><i
                                                    class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i
                                                    class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i
                                                    class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Don't have an account ? <a href="auth-signup-basic.html"
                                class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    {{-- <div class="d-flex flex-column flex-root" id="kt_app_root" style="background-image: url({{ asset('assets/media/admin/auth/bg4-dark.jpg') }})">
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <a href="../../../index.html" class="mb-7">
                        <img alt="Logo" src="{{ asset('assets/media/admin/logos/custom-3.svg') }}" />
                    </a>
                    <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>
                </div>
            </div>

            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">

                        <form id="checkLoginForm" action="{{ route('check.login') }}" method="POST" class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="/metronic8/demo1/../demo1/index.html">

                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                            </div>

                            <div class="row g-3 mb-9">
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="{{ asset('assets/media/admin/svg/brand-logos/google-icon.svg') }}" class="h-15px me-3" />
                                        Sign in with Google
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <a href="#"
                                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="{{ asset('assets/media/admin/svg/brand-logos/apple-black.svg') }}" class="theme-light-show h-15px me-3" />
                                        <img alt="Logo" src="{{ asset('assets/media/admin/svg/brand-logos/apple-black-dark.svg') }}" class="theme-dark-show h-15px me-3" />
                                        Sign in with Apple
                                    </a>
                                </div>
                            </div>

                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                            </div>

                            <div class="fv-row mb-6">
                                <input type="text" placeholder="Email" name="phone" id="email" autocomplete="off" class="form-control bg-transparent" />
                                <span role="alert" id="emailErr" style="color:red; font-size: 12px"></span>
                            </div>

                            <div class="fv-row mb-3">
                                <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control bg-transparent" />
                                <span role="alert" id="passwordErr" style="color:red; font-size: 12px"></span>
                            </div>

                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="reset-password.html" class="link-primary">Forgot Password ?</a>
                            </div>

                            <div class="d-grid mb-10">
                                <button id="checkLoginBtn" type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">Sign In</span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>

                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                Not a Member yet?
                                <a href="sign-up.html" class="link-primary">Sign up</a>
                            </div>
                        </form>

                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
