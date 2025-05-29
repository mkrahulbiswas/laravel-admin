@extends('admin.layouts.app')
@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="{{ route('show.login') }}" class="d-inline-block">
                                <img src="{{ $reqData['bigLogo'] }}" alt="" height="100">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Velzon.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form id="checkLoginForm" action="{{ route('check.login') }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Username</label>
                                        <input type="text" name="phone" class="form-control" id="email" placeholder="Enter Phone Number" required>
                                        <div class="invalid-feedback" id="emailErr"></div>
                                    </div>

                                    <div class="mb-3">
                                        {{-- <div class="float-end">
                                            <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                                        </div> --}}
                                        <label class="form-label" for="password">Password</label>
                                        <div class="position-relative valueShowHide mb-3">
                                            <input type="password" class="form-control pe-5 password" placeholder="Enter password" name="password" id="password">
                                            <div class="invalid-feedback" id="passwordErr"></div>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted valueShowHideBtn" type="button" id="valueShowHideBtn">
                                                <i class="ri-eye-off-fill align-middle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit" id="checkLoginBtn">Sign In</button>
                                    </div>
                                    {{-- <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light">
                                                <i class="ri-facebook-fill fs-16"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light">
                                                <i class="ri-google-fill fs-16"></i>
                                            </button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light">
                                                <i class="ri-github-fill fs-16"></i>
                                            </button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light">
                                                <i class="ri-twitter-fill fs-16"></i>
                                            </button>
                                        </div>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="mt-4 text-center">
                        <p class="mb-0">Don't have an account ? <a href="auth-signup-basic.html" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
@endsection
