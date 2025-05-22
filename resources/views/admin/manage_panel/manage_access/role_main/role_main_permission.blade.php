@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Permission</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Panel</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Access</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.show.roleMain') }}">Role Main</a></li>
                            <li class="breadcrumb-item active">Permission</li>
                        </ol>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.show.roleMain') }}" class="btn btn-warning btn-label waves-effect waves-light">
                        <i class="las la-backward label-icon align-middle fs-16 me-2"></i>
                        <span>Back</span>
                    </a>
                    {{-- <button type="button" class="btn btn-danger btn-label waves-effect waves-light ms-2" data-bs-toggle="button" onClick="javascript:window.close('','_parent','');">
                        <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                        <span>Close</span>
                    </button> --}}
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
                            <h5 class="card-title mb-0">Basic Datatables</h5>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-warning custom-toggle ms-2 tdFilterBtn d-flex" data-bs-toggle="button">
                                <span class="icon-on">
                                    <i class="mdi mdi-filter-outline align-bottom"></i>
                                </span>
                                <span class="icon-off">
                                    <i class="mdi mdi-filter-off-outline align-bottom"></i>
                                </span>
                                <span class="ps-1 d-none" id="filter-applied-count"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4 tdFilterMain" data-filterStatus="0">
                            <div class="tdFilterSub">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="d-sm-flex align-items-center justify-content-between">
                                            <div class="mb-3 mb-sm-0">
                                                <h5 class="m-0">Filter bellow table data:</h5>
                                            </div>
                                            <div class="d-sm-flex align-items-center justify-content-between">
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-icon waves-effect waves-light tdFilterCloseBtn">
                                                    <i class="mdi mdi-close-box fs-5"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="tdFilterForm p-3">
                                            <form id="filterPermissionRoleMainForm" method="POST" action="{{ route('admin.get.permissionRoleMain') }}" class="m-b-20">
                                                @csrf
                                                <div class="row gap-2">

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="navType" id="navTypeFilter" class="selectTwo select2-navType navTypeDDD" data-action="{{ route('admin.get.navMainDDD') }}">
                                                                <option value="">Select Nav Type</option>
                                                                @foreach ($data[Config::get('constants.typeCheck.manageNav.navType.type')] as $item)
                                                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <i class="bx bx-receipt"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="navMain" id="navMainFilter" class="selectTwo select2-navMain navMainDDD" data-action="{{ route('admin.get.navSubDDD') }}"></select>
                                                            <i class="bx bx-bar-chart-square"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="navSub" id="navSubFilter" class="selectTwo select2-navSub navSubDDD"></select>
                                                            <i class="bx bx-message-edit"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        <div class="form-group d-flex flex-row justify-content-start">
                                                            <button type="button" class="btn btn-info btn-label waves-effect waves-light filterPermissionRoleMainBtn" title="Search">
                                                                <i class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                <span>Search</span>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-label waves-effect waves-light filterPermissionRoleMainBtn ms-2" title="Reload">
                                                                <i class="bx bx-reset label-icon align-middle fs-16 me-2"></i>
                                                                <span>Reset</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 tdContentMain">
                            <div class="tdContentSub">
                                <form action="{{ route('admin.update.permissionRoleMain') }}" method="PUT" id="updatePermissionRoleMainForm">
                                    <div class="col-md-12 p-r-0" style="display: flex; flex-direction: row; justify-content: flex-end;">
                                        <div class="PermiAll">
                                            <label style="padding: 1px 20px; font-size: 20px; font-weight: bold;">Permission all </label>
                                            <input type="checkbox" id="CheckAll" checked name="CheckAll" value="0" />
                                        </div>
                                        <div class="form-group text-right m-b-0 m-l-10" style="align-self: center;">
                                            <button type="submit" id="updatePermissionBtnTop" class="btn btn-success waves-effect waves-light" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                                        </div>
                                    </div>

                                    @csrf
                                    <input type="hidden" name="roleMainId" value="{{ $data['roleMainId'] }}">
                                    <table id="managePanel-manageAccess-permissionRoleMain" data-id="{{ $data['roleMainId'] }}" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nav Type Name</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <br>
                                    <div class="form-group text-right m-b-0">
                                        <button type="submit" id="updatePermissionRoleMainBtn" class="btn btn-success waves-effect waves-light" type="submit"><i class="ti-save"></i> <span>Update</span></button>
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
