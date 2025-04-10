@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Nav Nested</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Panel</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Nav</a></li>
                            <li class="breadcrumb-item active">Nav Nested</li>
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
                            <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                <span>Add Nav Nested</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-data-main">
                            <div class="table-data">
                                <table id="managePanel-manageNav-navNested" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Nav Type</th>
                                            <th>Nav Main</th>
                                            <th>Nav Sub</th>
                                            <th>Nav Nested</th>
                                            <th>Nav Icon</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Nav Type</th>
                                            <th>Nav Main</th>
                                            <th>Nav Sub</th>
                                            <th>Nav Nested</th>
                                            <th>Nav Icon</th>
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

    <div id="con-add-modal" class="modal fade con-add-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="saveNavNestedForm" action="{{ route('admin.save.navNested') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Nav Nested</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 mb-3">
                                <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navType" id="navType" class="selectTwo select2-navType-addModal navTypeDDD" data-action="{{ route('admin.get.navMainDDD') }}">
                                        <option value="">Select Nav Type</option>
                                        @foreach ($data['navType']['navType'] as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="navTypeErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="navMain" class="form-label">Nav Main <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navMain" id="navMain" class="selectTwo select2-navMain-addModal navMainDDD" data-action="{{ route('admin.get.navSubDDD') }}"></select>
                                    <i class="bx bx-bar-chart-square"></i>
                                </div>
                                <div class="validation-error" id="navMainErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="navSub" class="form-label">Nav Sub <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navSub" id="navSub" class="selectTwo select2-navSub-addModal navSubDDD"></select>
                                    <i class="bx bx-list-ul"></i>
                                </div>
                                <div class="validation-error" id="navSubErr"></div>
                            </div>
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type" required>
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
                        <button type="button" class="btn btn-danger btn-label waves-effect waves-light" data-bs-dismiss="modal">
                            <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                            <span>Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveNavNestedBtn">
                            <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                            <span>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-edit-modal" class="modal fade con-edit-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateNavNestedForm" action="{{ route('admin.update.navNested') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Nav Nested</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-12 mb-3">
                                <label for="navType" class="form-label">Nav Type <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navType" id="navType2" class="selectTwo select2-navType-editModal navTypeDDD" data-action="{{ route('admin.get.navMainDDD') }}">
                                        <option value="">Select Nav Type</option>
                                        @foreach ($data['navType']['navType'] as $item)
                                            <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}">
                                                {{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bx bx-receipt"></i>
                                </div>
                                <div class="validation-error" id="navTypeErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="navMain" class="form-label">Nav Main <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navMain" id="navMain2" class="selectTwo select2-navMain-editModal navMainDDD" data-action="{{ route('admin.get.navSubDDD') }}"></select>
                                    <i class="bx bx-bar-chart-square"></i>
                                </div>
                                <div class="validation-error" id="navMainErr"></div>
                            </div>
                            <div class="form-element col-12 mb-3">
                                <label for="navSub" class="form-label">Nav Sub <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <select name="navSub" id="navSub2" class="selectTwo select2-navSub-editModal navSubDDD"></select>
                                    <i class="bx bx-list-ul"></i>
                                </div>
                                <div class="validation-error" id="navSubErr"></div>
                            </div>
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type" required>
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
                        <button type="button" class="btn btn-danger btn-label waves-effect waves-light" data-bs-dismiss="modal">
                            <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                            <span>Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateNavNestedBtn">
                            <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                            <span>Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-detail-modal" class="modal fade con-detail-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Details Nav Nested</h5>
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
                                        <i class="bx bx-bar-chart-square"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Nav Main :</label>
                                    <span class="detail-span d-block mb-0" id="navMain"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="bx bx-list-ul"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Nav Sub :</label>
                                    <span class="detail-span d-block mb-0" id="navSub"></span>
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
                    <button type="button" class="btn btn-danger btn-label waves-effect waves-light" data-bs-dismiss="modal">
                        <i class="las la-window-close label-icon align-middle fs-16 me-2"></i>
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
