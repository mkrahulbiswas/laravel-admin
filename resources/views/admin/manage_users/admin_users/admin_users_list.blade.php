@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Admin Users</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Users</a></li>
                            <li class="breadcrumb-item active">Admin Users</li>
                        </ol>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between"></div>
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
                            @if ($permission['add']['permission'] == true)
                                <a href="{{ route('admin.add.adminUsers') }}" class="btn btn-success btn-label waves-effect waves-light">
                                    <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                    <span>Add New Admin User</span>
                                </a>
                            @endif
                            @if ($permission['filter']['permission'] == true)
                                <button type="button" class="btn btn-warning custom-toggle ms-2 tdFilterBtn d-flex" data-bs-toggle="button">
                                    <span class="icon-on">
                                        <i class="mdi mdi-filter-outline align-bottom"></i>
                                    </span>
                                    <span class="icon-off">
                                        <i class="mdi mdi-filter-off-outline align-bottom"></i>
                                    </span>
                                    <span class="ps-1 d-none" id="filter-applied-count"></span>
                                </button>
                            @endif
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
                                            <form id="filterAdminUsersForm" method="POST" action="{{ route('admin.get.adminUsers') }}" class="m-b-20">
                                                @csrf
                                                <div class="row gap-2">

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="status" id="statusFilter" class="selectPicker" data-style="btn-light btn-custom" title="Select any status">
                                                                <option value="{{ config('constants.status')['active'] }}">{{ config('constants.status')['active'] }}</option>
                                                                <option value="{{ config('constants.status')['inactive'] }}">{{ config('constants.status')['inactive'] }}</option>
                                                            </select>
                                                            <i class="mdi mdi-list-status"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        <div class="form-group d-flex flex-row justify-content-start">
                                                            @if ($permission['search']['permission'] == true)
                                                                <button type="button" class="btn btn-info btn-label waves-effect waves-light filterAdminUsersBtn" title="Search">
                                                                    <i class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                    <span>Search</span>
                                                                </button>
                                                            @endif
                                                            @if ($permission['reset']['permission'] == true)
                                                                <button type="button" class="btn btn-danger btn-label waves-effect waves-light filterAdminUsersBtn ms-2" title="Reload">
                                                                    <i class="bx bx-reset label-icon align-middle fs-16 me-2"></i>
                                                                    <span>Reset</span>
                                                                </button>
                                                            @endif
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
                                <table id="manageUsers-adminUsers" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="con-info-modal" class="modal fade con-info-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Details Role Sub</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row info-page-data">

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-receipt"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Role Main :</label>
                                    <span class="detail-span d-block mb-0" id="roleMain"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Role Sub :</label>
                                    <span class="detail-span d-block mb-0" id="name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-detail"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Description :</label>
                                    <span class="detail-span d-block mb-0" id="description"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    @if ($permission['close']['permission'] == true)
                        <button type="button" class="btn btn-danger btn-label waves-effect waves-light" data-bs-dismiss="modal">
                            <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                            <span>Close</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
