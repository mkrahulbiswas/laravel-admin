@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Sub Nav</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Related</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation Access</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Side Nav</a></li>
                            <li class="breadcrumb-item active">Sub Nav</li>
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
                <div class="card-header cardHeader">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title mb-0">Basic Data Tables</h5>
                            <span>Test</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between">
                            @if ($permission['add']['permission'] == true)
                                <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                    <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                    <span>Add Sub Nav</span>
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
                <div class="card-body cardBody">
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
                                            <form id="filterSubNavForm" method="POST" action="{{ route('admin.get.subNav') }}" class="m-b-20">
                                                @csrf
                                                <div class="row gap-2">

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="navType" id="navTypeFilter" class="selectTwo select2-navType navTypeDDD" data-action="{{ route('admin.get.mainNavDDD') }}">
                                                                <option value="">Select Nav Type</option>
                                                                @foreach ($data['navType'] as $item)
                                                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <i class="bx bx-receipt"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        {{-- <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label> --}}
                                                        <div class="form-icon set-validation">
                                                            <select name="mainNav" id="mainNavFilter" class="selectTwo select2-mainNav mainNavDDD"></select>
                                                            <i class="bx bx-bar-chart-square"></i>
                                                        </div>
                                                    </div>

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

                                                    <div class="form-element col-sm-12 col-md-6 col-lg-5 col-xl-4 col-xxl-3">
                                                        <div class="form-group d-flex flex-row justify-content-start">
                                                            @if ($permission['search']['permission'] == true)
                                                                <button type="button" class="btn btn-info btn-label waves-effect waves-light filterSubNavBtn" title="Search">
                                                                    <i class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                    <span>Search</span>
                                                                </button>
                                                            @endif
                                                            @if ($permission['reset']['permission'] == true)
                                                                <button type="button" class="btn btn-danger btn-label waves-effect waves-light filterSubNavBtn ms-2" title="Reload">
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
                                <table id="adminRelated-navigationAccess-manageSideNav-subNav" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Nav Type</th>
                                            <th>Main Nav</th>
                                            <th>Sub Nav</th>
                                            <th>Nav Icon</th>
                                            <th>Stat Info</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Nav Type</th>
                                            <th>Main Nav</th>
                                            <th>Sub Nav</th>
                                            <th>Nav Icon</th>
                                            <th>Stat Info</th>
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

    <div id="con-add-modal" class="modal fade con-add-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="saveSubNavForm" action="{{ route('admin.save.subNav') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Sub Nav</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 mb-3">
                                <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navType" id="navType" class="selectTwo select2-navType-addModal navTypeDDD" data-action="{{ route('admin.get.mainNavDDD') }}">
                                        <option value="">Select Nav Type</option>
                                        @foreach ($data['navType'] as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="navTypeErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="mainNav" class="form-label">Main Nav <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="mainNav" id="mainNav" class="selectTwo select2-mainNav-addModal mainNavDDD">
                                        <option value="">Select Nav Type</option>
                                    </select>
                                    <i class="bx bx-bar-chart-square"></i>
                                </div>
                                <div class="validation-error" id="mainNavErr"></div>
                            </div>
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="nameErr"></div>
                            </div>
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6">
                                <label for="icon" class="form-label">Icon <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="icon" class="form-control form-control-icon" id="icon" placeholder="Class of icon">
                                    <i class="bx bx-library"></i>
                                </div>
                                <div class="validation-error" id="iconErr"></div>
                            </div>
                            <div class="form-element col-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="input-group set-validation">
                                    <span class="input-group-text">
                                        <i class="bx bx-detail"></i>
                                    </span>
                                    <textarea name="description" class="form-control" aria-label="With textarea" id="description" role="3" placeholder="Give any description if you want"></textarea>
                                </div>
                                <div class="validation-error" id="descriptionErr"></div>
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveSubNavBtn">
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
                <form id="updateSubNavForm" action="{{ route('admin.update.subNav') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Sub Nav</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 mb-3">
                                <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navType" id="navType2" class="selectTwo select2-navType-editModal navTypeDDD" data-action="{{ route('admin.get.mainNavDDD') }}">
                                        <option value="">Select Nav Type</option>
                                        @foreach ($data['navType'] as $item)
                                            <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}">
                                                {{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="navTypeErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="mainNav" class="form-label">Main Nav <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="mainNav" id="mainNav2" class="selectTwo select2-mainNav-editModal mainNavDDD"></select>
                                    <i class="bx bx-bar-chart-square"></i>
                                </div>
                                <div class="validation-error" id="mainNavErr"></div>
                            </div>
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="nameErr"></div>
                            </div>
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6">
                                <label for="icon" class="form-label">Icon <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="icon" class="form-control form-control-icon" id="icon" placeholder="Class of icon">
                                    <i class="bx bx-library"></i>
                                </div>
                                <div class="validation-error" id="iconErr"></div>
                            </div>
                            <div class="form-element col-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="input-group set-validation">
                                    <span class="input-group-text">
                                        <i class="bx bx-detail"></i>
                                    </span>
                                    <textarea name="description" class="form-control" aria-label="With textarea" id="description" role="3" placeholder="Give any description if you want"></textarea>
                                </div>
                                <div class="validation-error" id="descriptionErr"></div>
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateSubNavBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Update</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-access-modal" class="modal fade con-access-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="accessSubNavForm" action="{{ route('admin.access.subNav') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Set Nav Type Access</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 mb-3">
                                <label for="name" class="form-label">Nav Type Name</label>
                                <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type" readonly>
                            </div>
                            <div class="form-element col-12">
                                <label for="name" class="form-label">Set Access <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            </div>
                            @foreach (Config::get('constants.rolePermission.accessType') as $item)
                                <div class="form-element col-sm-4 col-md-4 col-xl-4 col-lg-4">
                                    <div class="form-icon set-validation">
                                        <div class="form-check form-switch form-switch-success">
                                            <label class="fw-normal form-check-label" for="switchCheck{{ $item }}">{{ $item }}</label>
                                            <input class="form-check-input" name="access[{{ $item }}]" type="checkbox" role="switch" id="switchCheck{{ $item }}">
                                        </div>
                                    </div>
                                    <div class="validation-error" id="nameErr"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($permission['close']['permission'] == true)
                            <button type="button" class="btn btn-danger btn-label waves-effect waves-light" data-bs-dismiss="modal">
                                <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                                <span>Close</span>
                            </button>
                        @endif
                        @if ($permission['set']['permission'] == true)
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="accessSubNavBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Set Access</span>
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
                    <h5 class="modal-title" id="myModalLabel">Details Sub Nav</h5>
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
                                    <label class="details-label form-label mb-1">Nav Type :</label>
                                    <span class="detail-span d-block mb-0" id="navType"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-bar-chart-square"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Main Nav :</label>
                                    <span class="detail-span d-block mb-0" id="mainNav"></span>
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

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="col-12">
                            <div class="d-flex each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="mdi mdi-access-point"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Access set :</label>
                                    <span class="detail-span mb-0" id="access"></span>
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
