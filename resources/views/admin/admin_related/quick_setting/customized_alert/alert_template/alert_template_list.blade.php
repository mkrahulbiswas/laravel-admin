@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Alert Template</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Related</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quick Setting</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Customized Alert</a></li>
                            <li class="breadcrumb-item active">Alert Template</li>
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
                                    <span>Add Alert Template</span>
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
                                            <form id="filterAlertTemplateForm" method="POST" action="{{ route('admin.get.alertTemplate') }}" class="m-b-20">
                                                @csrf
                                                <div class="row gap-2">
                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        <div class="form-icon set-validation">
                                                            <select name="alertType" id="alertTypeFilter" class="selectPicker form-control alertTypeDDD" data-style="btn-light" title="Select alert type" data-action="{{ route('admin.get.alertForDDD') }}">
                                                                <option value="">Select Alert Type</option>
                                                                @foreach ($data['alertType'] as $item)
                                                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <i class="mdi mdi-list-status"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                                                        <div class="form-icon set-validation">
                                                            <select name="alertFor" id="alertForFilter" class="selectTwo select2-alertFor form-control alertForDDD"></select>
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
                                                                <button type="button" class="btn btn-info btn-label waves-effect waves-light filterAlertTemplateBtn" title="Search">
                                                                    <i class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                    <span>Search</span>
                                                                </button>
                                                            @endif
                                                            @if ($permission['reset']['permission'] == true)
                                                                <button type="button" class="btn btn-danger btn-label waves-effect waves-light filterAlertTemplateBtn ms-2" title="Reload">
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
                                <table id="adminRelated-quickSetting-customizedAlert-alertTemplate" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Alert Type</th>
                                            <th>Alert For</th>
                                            <th>Default</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Alert Type</th>
                                            <th>Alert For</th>
                                            <th>Default</th>
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

    <div id="con-add-modal" class="modal fade con-add-modal con-common-modal bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="saveAlertTemplateForm" action="{{ route('admin.save.alertTemplate') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Alert Template</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="alertType" class="form-label">Alert type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="alertType" id="alertType" class="form-control form-control-icon alertTypeDDD" data-action="{{ route('admin.get.alertForDDD') }}">
                                        <option value="">Select Alert Type</option>
                                        @foreach ($data['alertType'] as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="alertTypeErr"></div>
                            </div>
                            <div class="form-element col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="alertFor" class="form-label">Alert for <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="alertFor" id="alertFor" class="selectTwo select2-alertFor-addModal form-control form-control-icon alertForDDD"></select>
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="alertForErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="heading" class="form-label">Heading / Subject / Title <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="heading" class="form-control form-control-icon" id="heading" placeholder="Heading">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="headingErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="content" class="form-label">Content / Body <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="set-validation">
                                    <textarea name="content" class="form-control sn-alertTemplate-content summernote" aria-label="With textarea" id="content" placeholder="Content"></textarea>
                                </div>
                                <div class="validation-error" id="contentErr"></div>
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveAlertTemplateBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Save</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-edit-modal" class="modal fade con-edit-modal con-common-modal bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="updateAlertTemplateForm" action="{{ route('admin.update.alertTemplate') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Alert Template</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="alertType" class="form-label">Alert type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="alertType" id="alertType" class="form-control form-control-icon alertTypeDDD" data-action="{{ route('admin.get.alertForDDD') }}">
                                        <option value="">Select Alert Type</option>
                                        @foreach ($data['alertType'] as $item)
                                            <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="alertTypeErr"></div>
                            </div>
                            <div class="form-element col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="alertFor" class="form-label">Alert for <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="alertFor" id="alertFor2" class="selectTwo select2-alertFor-editModal form-control form-control-icon alertForDDD"></select>
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="alertForErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="heading" class="form-label">Heading / Subject / Title <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="heading" class="form-control form-control-icon" id="heading" placeholder="Heading">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                                <div class="validation-error" id="headingErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="content" class="form-label">Content / Body <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="set-validation">
                                    <textarea name="content" class="form-control sn-alertTemplate-content summernote" aria-label="With textarea" id="content" placeholder="Content"></textarea>
                                </div>
                                <div class="validation-error" id="contentErr"></div>
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateAlertTemplateBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Update</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-info-modal" class="modal fade bs-example-modal-lg con-info-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Details Alert Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row info-page-data">
                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Alert Type:</label>
                                    <span class="detail-span d-block mb-0" id="alertType"></span>
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
                                    <label class="details-label form-label mb-1">Alert For:</label>
                                    <span class="detail-span d-block mb-0" id="alertFor"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Heading / Subject / Title:</label>
                                    <span class="detail-span d-block mb-0" id="heading"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Content / Body:</label>
                                    <span class="detail-span d-block mb-0" id="content"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-message-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Variable</label>
                                    <div class="detail-span d-block mb-0" id="variable"></div>
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
