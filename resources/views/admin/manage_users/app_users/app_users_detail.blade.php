@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>App Users Detail</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Users</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.show.appUsers') }}">App Users</a></li>
                            <li class="breadcrumb-item active">App Users Detail</li>
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

    <div class="row main-page-content">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header cardHeader">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title mb-0">Form to create a new admin user</h5>
                            <span>Test</span>
                        </div>
                    </div>
                </div>
                <div class="card-body cardBody">
                    <div class="row">
                        <div class="col-md-12 detailElementMain">
                            <div class="detailElementSub">

                                <div class="profile-foreground position-relative profileCover">
                                    <div class="profile-wid-bg">
                                        <img src="{{ asset('assets/media/admin/images/profile-bg.jpg') }}" alt="" class="profile-wid-img" />
                                    </div>
                                </div>
                                <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
                                    <div class="row g-4">
                                        <div class="col-auto">
                                            <div class="avatar-lg">
                                                <img src="{{ $data['detail']['getFile']['public']['fullPath']['asset'] }}" alt="user-img" class="img-thumbnail rounded-circle" style="width: 100%; height:100%;" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="p-2">
                                                <h3 class="text-white mb-1">{{ $data['detail']['name'] }}</h3>
                                                <p class="text-white text-opacity-75">{{ $data['detail']['customizeInText']['userType']['raw'] }}</p>
                                                <div class="hstack text-white-50 gap-1">
                                                    {{-- <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $data['detail']['address'] }}, {{ $data['detail']['state'] }}, {{ $data['detail']['country'] }}, {{ $data['detail']['pinCode'] }}</div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-auto order-last order-lg-0">
                                            <div class="row text text-white-50 text-center">
                                                <div class="col-lg-6 col-4">
                                                    <div class="p-2">
                                                        <h4 class="text-white mb-1">24.3K</h4>
                                                        <p class="fs-14 mb-0">Followers</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-4">
                                                    <div class="p-2">
                                                        <h4 class="text-white mb-1">1.3K</h4>
                                                        <p class="fs-14 mb-0">Following</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="d-flex profile-wrapper">
                                                <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                                            <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Overview</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content pt-4 text-muted">
                                                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-xxl-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-5">Complete Your Profile</h5>
                                                                    <div class="progress animated-progress custom-progress progress-label">
                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                                            <div class="label">30%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-3">Basic info</h5>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-borderless mb-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th class="p-0 pt-1 pb-1" scope="row">Mobile :</th>
                                                                                    <td class="text-muted p-0 pt-1 pb-1">{{ $data['detail']['phone'] }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="p-0 pt-1 pb-1" scope="row">E-mail :</th>
                                                                                    <td class="text-muted p-0 pt-1 pb-1">{{ $data['detail']['email'] }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="p-0 pt-1 pb-1" scope="row">Create Date</th>
                                                                                    <td class="text-muted p-0 pt-1 pb-1">{{ $data['detail']['date'] }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-4">Portfolio</h5>
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                        <div>
                                                                            <a href="javascript:void(0);" class="avatar-xs d-block">
                                                                                <span class="avatar-title rounded-circle fs-16 bg-body text-body">
                                                                                    <i class="ri-github-fill"></i>
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                        <div>
                                                                            <a href="javascript:void(0);" class="avatar-xs d-block">
                                                                                <span class="avatar-title rounded-circle fs-16 bg-primary">
                                                                                    <i class="ri-global-fill"></i>
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                        <div>
                                                                            <a href="javascript:void(0);" class="avatar-xs d-block">
                                                                                <span class="avatar-title rounded-circle fs-16 bg-success">
                                                                                    <i class="ri-dribbble-fill"></i>
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                        <div>
                                                                            <a href="javascript:void(0);" class="avatar-xs d-block">
                                                                                <span class="avatar-title rounded-circle fs-16 bg-danger">
                                                                                    <i class="ri-pinterest-fill"></i>
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-9">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-1">About myself</h5>
                                                                    {{-- <p>{!! $data['detail']['about'] !!}</p> --}}
                                                                    <div class="row">
                                                                        <div class="col-6 col-md-4">
                                                                            <div class="d-flex mt-4">
                                                                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                                        <i class="ri-user-2-fill"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex-grow-1 overflow-hidden">
                                                                                    <p class="mb-1">Designation :</p>
                                                                                    <h6 class="text-truncate mb-0">Lead Designer / Developer</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 col-md-4">
                                                                            <div class="d-flex mt-4">
                                                                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                                        <i class="ri-global-line"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex-grow-1 overflow-hidden">
                                                                                    <p class="mb-1">Website :</p>
                                                                                    <a href="#" class="fw-semibold">www.velzon.com</a>
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
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
