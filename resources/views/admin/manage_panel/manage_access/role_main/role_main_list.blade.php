@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Role Main</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Panel</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Access</a></li>
                            <li class="breadcrumb-item active">Role Main</li>
                        </ol>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between">

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
                            <button type="button" class="btn btn-success btn-label waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#con-add-modal"><i
                                    class="las la-plus-circle label-icon align-middle fs-16 me-2"></i> Add Main
                                Role</button>
                            <button type="button" class="btn btn-warning custom-toggle ms-2 filter-table-data-btn d-flex"
                                data-bs-toggle="button">
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
                        <div class="col-md-12 mb-4 filter-table-data-main" data-filterStatus="0">
                            <div class="filter-table-data">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="d-sm-flex align-items-center justify-content-between">
                                            <div class="mb-3 mb-sm-0">
                                                <h5 class="m-0">Filter bellow table data:</h5>
                                            </div>
                                            <div class="d-sm-flex align-items-center justify-content-between">
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm btn-icon waves-effect waves-light filter-table-data-close-btn">
                                                    <i class="mdi mdi-close-box fs-5"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="filter-table-form p-3">
                                            <form id="filterRoleMainForm" method="POST"
                                                action="{{ route('admin.get.roleMain') }}" class="m-b-20">
                                                @csrf
                                                <div class="row">

                                                    <div class="form-element col-md-2 m-t-5">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="status" id="statusFilter" class="selectPicker"
                                                                data-style="btn-light btn-custom" title="Select any status">
                                                                <option value="{{ config('constants.status')['active'] }}">
                                                                    {{ config('constants.status')['active'] }}</option>
                                                                <option
                                                                    value="{{ config('constants.status')['inactive'] }}">
                                                                    {{ config('constants.status')['inactive'] }}</option>
                                                            </select>
                                                            <i class="mdi mdi-list-status"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 m-t-5">
                                                        <div class="form-group d-flex flex-row justify-content-around">
                                                            <button type="button"
                                                                class="btn btn-info btn-label waves-effect waves-light filterRoleMainBtn"
                                                                title="Search"><i
                                                                    class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                Search</button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-label waves-effect waves-light filterRoleMainBtn"
                                                                title="Reload"><i
                                                                    class="bx bx-reset label-icon align-middle fs-16 me-2"></i>
                                                                Reset</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 table-data-main">
                            <div class="table-data">
                                <table id="managePanel-manageAccess-roleMain"
                                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Role Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Role Name</th>
                                            <th>Description</th>
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

    <div id="con-add-modal" class="modal fade con-add-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="saveRoleMainForm" action="{{ route('admin.save.roleMain') }}" method="POST"
                    enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Role Main</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-12 col-md-12 col-xl-12 col-lg-12 mb-3">
                                <label for="name" class="form-label">Role type <span
                                        class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon"
                                        id="name" placeholder="Role Name" required>
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="nameErr"></div>
                            </div>
                            <div class="form-element col-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="input-group set-validation">
                                    <span class="input-group-text">
                                        <i class="bx bx-detail"></i>
                                    </span>
                                    <textarea name="description" class="form-control" aria-label="With textarea" id="description" role="3"
                                        placeholder="Give any description if you want"></textarea>
                                </div>
                                <div class="validation-error" id="descriptionErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-label waves-effect waves-light"
                            data-bs-dismiss="modal"><i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                            Close</button>
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light"
                            id="saveRoleMainBtn"><i class="las la-save label-icon align-middle fs-16 me-2"></i>
                            <span>Save</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-edit-modal" class="modal fade con-edit-modal con-common-modal" tabindex="-1"
        aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateRoleMainForm" action="{{ route('admin.update.roleMain') }}" method="POST"
                    enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Role Main</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-12 col-md-12 col-xl-12 col-lg-12 mb-3">
                                <label for="name" class="form-label">Role type <span
                                        class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon"
                                        id="name" placeholder="Role Name" required>
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="nameErr"></div>
                            </div>
                            <div class="form-element col-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="input-group set-validation">
                                    <span class="input-group-text">
                                        <i class="bx bx-detail"></i>
                                    </span>
                                    <textarea name="description" class="form-control" aria-label="With textarea" id="description" role="3"
                                        placeholder="Give any description if you want"></textarea>
                                </div>
                                <div class="validation-error" id="descriptionErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-label waves-effect waves-light"
                            data-bs-dismiss="modal"><i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                            Close</button>
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light"
                            id="updateRoleMainBtn"><i class="las la-save label-icon align-middle fs-16 me-2"></i>
                            <span>Update</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-detail-modal" class="modal fade con-detail-modal con-common-modal" tabindex="-1"
        aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Details Role Main</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row detail-page-data">

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-receipt"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Nav Type :</label>
                                    <span class="detail-span d-block mb-0" id="navType"></span>
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
                                    <label class="details-label form-label mb-1">Name :</label>
                                    <span class="detail-span d-block mb-0" id="name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-library"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Icon :</label>
                                    <span class="detail-span d-block mb-0" id="icon"></span>
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
                    <button type="button" class="btn btn-danger btn-label waves-effect waves-light"
                        data-bs-dismiss="modal"><i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
