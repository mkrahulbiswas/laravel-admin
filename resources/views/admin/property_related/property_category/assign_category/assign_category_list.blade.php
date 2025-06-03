@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Assign Category</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Property Related</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Broad</a></li>
                            <li class="breadcrumb-item active">Assign Category</li>
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
                @if ($data['propertyType'] != [] && $data['mainCategory'] != [])
                    <div class="card-header cardHeader">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title mb-0">Basic Datatables</h5>
                                <span>Test</span>
                            </div>
                            <div class="d-sm-flex align-items-center justify-content-between">
                                @if ($permission['add']['permission'] == true)
                                    <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                        <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                        <span>Add Assign Category</span>
                                    </button>
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
                @endif
                <div class="card-body cardBody">
                    <div class="row">
                        @if ($data['propertyType'] == [] || $data['mainCategory'] == [])
                            <div class="col-md-12 tdMessages">
                                <div class="row">
                                    @if ($data['propertyType'] == [])
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="alert alert-primary alert-dismissible alert-additional fade show mb-0" role="alert">
                                                <div class="alert-body">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="ri-user-smile-line fs-16 align-middle"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="alert-heading">Note!</h5>
                                                            <p class="mb-0">There is a problem that is we did not found any <b>property type</b>. For manage <b>Assign Category</b> section you must entry <b>property type</b> first.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert-content">
                                                    <p class="mb-0">To add main category <a class="btn btn-sm btn-success" href="{{ route('admin.show.propertyType') }}">click me</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($data['mainCategory'] == [])
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-xl-0 mt-lg-0 mt-3">
                                            <div class="alert alert-primary alert-dismissible alert-additional fade show mb-0" role="alert">
                                                <div class="alert-body">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="ri-user-smile-line fs-16 align-middle"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="alert-heading">Note!</h5>
                                                            <p class="mb-0">There is a problem that is we did not found any <b>main category</b>. For manage <b>Assign Category</b> section you must entry <b>main category</b> first.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert-content">
                                                    <p class="mb-0">To add main category <a class="btn btn-sm btn-success" href="{{ route('admin.show.mainCategory') }}">click me</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else()
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
                                                <form id="filterAssignCategoryForm" method="POST" action="{{ route('admin.get.assignCategory') }}" class="m-b-20">
                                                    @csrf
                                                    <div class="row gap-2">
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                            <div class="form-icon set-validation">
                                                                <select class="selectTwo form-control form-control-icon select2-propertyType" name="propertyType" id="propertyTypeFilter">
                                                                    <option value="">Select property type</option>
                                                                    @foreach ($data['propertyType'] as $key)
                                                                        <option value="{{ $key['id'] }}">{{ $key['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <i class="mdi mdi-list-status"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                            <div class="form-icon set-validation">
                                                                <select class="selectTwo form-control form-control-icon select2-mainCategory" name="mainCategory" id="mainCategoryFilter">
                                                                    <option value="">Select main category</option>
                                                                    @foreach ($data['mainCategory'] as $key)
                                                                        <option value="{{ $key['id'] }}">{{ $key['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <i class="mdi mdi-list-status"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                            <div class="form-icon set-validation">
                                                                <select name="status" id="statusFilter" class="selectPicker" data-style="btn-light btn-custom" title="Select any status">
                                                                    <option value="{{ config('constants.status')['active'] }}">{{ config('constants.status')['active'] }}</option>
                                                                    <option value="{{ config('constants.status')['inactive'] }}">{{ config('constants.status')['inactive'] }}</option>
                                                                </select>
                                                                <i class="mdi mdi-list-status"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                            <div class="form-icon set-validation">
                                                                <select name="default" id="defaultFilter" class="selectPicker" data-style="btn-light btn-custom" title="Select any default type">
                                                                    <option value="{{ config('constants.status')['yes'] }}">{{ config('constants.status')['yes'] }}</option>
                                                                    <option value="{{ config('constants.status')['no'] }}">{{ config('constants.status')['no'] }}</option>
                                                                </select>
                                                                <i class="mdi mdi-list-status"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-element col-sm-12 col-md-6 col-lg-5 col-xl-4 col-xxl-3">
                                                            <div class="form-group d-flex flex-row justify-content-start">
                                                                @if ($permission['search']['permission'] == true)
                                                                    <button type="button" class="btn btn-info btn-label waves-effect waves-light filterAssignCategoryBtn" title="Search">
                                                                        <i class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                        <span>Search</span>
                                                                    </button>
                                                                @endif
                                                                @if ($permission['reset']['permission'] == true)
                                                                    <button type="button" class="btn btn-danger btn-label waves-effect waves-light filterAssignCategoryBtn ms-2" title="Reload">
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
                            <div class="col-md-12 mb-4 no_noteMain">
                                <div class="no_noteSub bg-light">
                                    <p class="no_noteHeading p-3 bg-warning-subtle">
                                        <span><span class="text-danger">Note:</span> In this section we need some list of data </span>
                                        <span class="no_noteText">
                                            <a href="{{ route('admin.show.propertyType') }}" class="btn btn-sm btn-info">
                                                <b>Property type list</b>
                                            </a>
                                        </span>
                                        <span class="no_noteText">
                                            <a href="{{ route('admin.show.mainCategory') }}" class="btn btn-sm btn-info">
                                                <b>Main category list</b>
                                            </a>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12 tdContentMain">
                                <div class="tdContentSub">
                                    <table id="propertyRelated-propertyCategory-assignCategory" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Unique Id</th>
                                                <th>Property Type</th>
                                                <th>Main category</th>
                                                <th>Stats Info</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Unique Id</th>
                                                <th>Property Type</th>
                                                <th>Main category</th>
                                                <th>Stats Info</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="con-add-modal" class="modal fade con-add-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="saveAssignCategoryForm" action="{{ route('admin.save.assignCategory') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Assign Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 mb-3">
                                <label for="name" class="form-label">Main category <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select class="selectTwo form-control form-control-icon select2-mainCategory-addModal" name="mainCategory" id="mainCategory">
                                        <option value="">Select main category</option>
                                        @foreach ($data['mainCategory'] as $key)
                                            <option value="{{ $key['id'] }}">{{ $key['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="mainCategoryErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Property Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select class="selectTwo form-control form-control-icon select2-propertyType-addModal propertyTypeDDD" name="propertyType" id="propertyType" data-action="{{ route('admin.get.assignBroadDDD') }}">
                                        <option value="">Select property type</option>
                                        @foreach ($data['propertyType'] as $key)
                                            <option value="{{ $key['id'] }}">{{ $key['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="propertyTypeErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="assignBroad" class="form-label">Broad Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="assignBroad" id="assignBroad" class="selectTwo select2-assignBroad-addModal assignBroadDDD">
                                        <option value="">Select broad type</option>
                                    </select>
                                    <i class="bx bx-bar-chart-square"></i>
                                </div>
                                <div class="validation-error" id="assignBroadErr"></div>
                            </div>
                            <div class="form-element col-12">
                                <label for="about" class="form-label">About</label>
                                <div class="input-group set-validation">
                                    <span class="input-group-text">
                                        <i class="bx bx-detail"></i>
                                    </span>
                                    <textarea name="about" class="form-control" aria-label="With textarea" id="about" role="3" placeholder="Time about anything"></textarea>
                                </div>
                                <div class="validation-error" id="aboutErr"></div>
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
                        @if ($permission['save']['permission'] == true)
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveAssignCategoryBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Save</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-edit-modal" class="modal fade con-edit-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateAssignCategoryForm" action="{{ route('admin.update.assignCategory') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Assign Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Main category <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select class="selectTwo form-control form-control-icon select2-mainCategory-editModal" name="mainCategory" id="mainCategory2">
                                        <option value="">Select main category</option>
                                        @foreach ($data['mainCategory'] as $key)
                                            <option value="{{ $key['id'] }}" data-name="{{ $key['name'] }}">{{ $key['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="mainCategoryErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Property Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select class="selectTwo form-control form-control-icon select2-propertyType-addModal propertyTypeDDD" name="propertyType" id="propertyType" data-action="{{ route('admin.get.assignBroadDDD') }}">
                                        <option value="">Select property type</option>
                                        @foreach ($data['propertyType'] as $key)
                                            <option value="{{ $key['id'] }}" data-name="{{ $key['name'] }}">{{ $key['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="propertyTypeErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="assignBroad" class="form-label">Broad Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="assignBroad" id="assignBroad" class="selectTwo select2-assignBroad-addModal assignBroadDDD">
                                        <option value="">Select broad type</option>
                                    </select>
                                    <i class="bx bx-bar-chart-square"></i>
                                </div>
                                <div class="validation-error" id="assignBroadErr"></div>
                            </div>
                            <div class="form-element col-12">
                                <label for="about" class="form-label">About</label>
                                <div class="input-group set-validation">
                                    <span class="input-group-text">
                                        <i class="bx bx-detail"></i>
                                    </span>
                                    <textarea name="about" class="form-control" aria-label="With textarea" id="about" role="3" placeholder="Time about anything"></textarea>
                                </div>
                                <div class="validation-error" id="aboutErr"></div>
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
                        @if ($permission['update']['permission'] == true)
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateAssignCategoryBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Update</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-info-modal" class="modal fade con-info-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Details Assign Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row info-page-data">
                        <div class="col-12 col-sm-12 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Property type:</label>
                                    <span class="detail-span d-block mb-0" id="propertyType"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Main category:</label>
                                    <span class="detail-span d-block mb-0" id="mainCategory"></span>
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
                                    <label class="details-label form-label mb-1">About :</label>
                                    <span class="detail-span d-block mb-0" id="about"></span>
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
