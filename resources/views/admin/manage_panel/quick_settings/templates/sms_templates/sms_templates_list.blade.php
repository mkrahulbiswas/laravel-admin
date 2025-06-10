<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header cardHeader">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title mb-1">SMS Templates</h5>
                        <span>From this section you can manage sms templates.</span>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between">
                        @if ($permission['add']['permission'] == true)
                            <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                <span>Add SMS Template</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body cardBody">
                <div class="row">
                    <div class="col-md-12 tdContentMain">
                        <div class="tdContentSub">
                            <table id="managePanel-quickSettings-logo" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unique Id</th>
                                        <th>Big Logo</th>
                                        <th>Small Logo</th>
                                        <th>Favicon</th>
                                        <th>Default</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Unique Id</th>
                                        <th>Big Logo</th>
                                        <th>Small Logo</th>
                                        <th>Favicon</th>
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

<div id="con-add-modal" class="modal fade con-add-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="saveManageCategoryForm" action="{{ route('admin.save.manageCategory') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                @csrf
                <input type="hidden" name="type" id="type" class="type" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add <span class="myModalLabel"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-element col-12 mb-3">
                            <label for="mainCategory" class="form-label">Main Category <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            <div class="form-icon set-validation">
                                <select name="mainCategory" id="mainCategory" class="selectTwo select2-mainCategory-addModal mainCategoryDDD" data-action="{{ route('admin.get.mainCategoryDDD') }}">
                                    <option value="">Select Nav Type</option>
                                    @foreach ($data['mainCategory'] as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                <i class="bx bx-receipt"></i>
                            </div>
                            <div class="validation-error" id="mainCategoryErr"></div>
                        </div>
                        <div class="form-element col-12 mb-3">
                            <label for="subCategory" class="form-label">Sub Category <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            <div class="form-icon set-validation">
                                <select name="subCategory" id="subCategory" class="selectTwo select2-subCategory-addModal subCategoryDDD">
                                    <option value="">Select Sum Type</option>
                                </select>
                                <i class="bx bx-bar-chart-square"></i>
                            </div>
                            <div class="validation-error" id="subCategoryErr"></div>
                        </div>
                        <div class="form-element col-12 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            <div class="form-icon set-validation">
                                <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Name">
                                <i class="bx bx-message-edit"></i>
                            </div>
                            <div class="validation-error" id="nameErr"></div>
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
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveManageCategoryBtn">
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
            <form id="updateManageCategoryForm" action="{{ route('admin.update.manageCategory') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                @csrf
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="type" id="type" class="type" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit <span class="myModalLabel"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-element col-12 mb-3">
                            <label for="mainCategory" class="form-label">Main Category <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            <div class="form-icon set-validation">
                                <select name="mainCategory" id="mainCategory2" class="selectTwo select2-mainCategory-editModal mainCategoryDDD" data-action="{{ route('admin.get.mainCategoryDDD') }}">
                                    <option value="">Select Nav Type</option>
                                    @foreach ($data['mainCategory'] as $item)
                                        <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                <i class="bx bx-receipt"></i>
                            </div>
                            <div class="validation-error" id="mainCategoryErr"></div>
                        </div>
                        <div class="form-element col-12 mb-3">
                            <label for="subCategory" class="form-label">Sub Category <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            <div class="form-icon set-validation">
                                <select name="subCategory" id="subCategory2" class="selectTwo select2-subCategory-editModal subCategoryDDD"></select>
                                <i class="bx bx-bar-chart-square"></i>
                            </div>
                            <div class="validation-error" id="subCategoryErr"></div>
                        </div>
                        <div class="form-element col-12 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                            <div class="form-icon set-validation">
                                <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Name">
                                <i class="bx bx-message-edit"></i>
                            </div>
                            <div class="validation-error" id="nameErr"></div>
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
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateManageCategoryBtn">
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
                <h5 class="modal-title" id="myModalLabel">Details <span class="myModalLabel"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row info-page-data">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="d-flex mb-4 each-detail-box">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <label class="details-label form-label mb-1">Main Category:</label>
                                <span class="detail-span d-block mb-0" id="mainCategory"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" style="display: none;">
                        <div class="d-flex mb-4 each-detail-box">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <label class="details-label form-label mb-1">Sub Category:</label>
                                <span class="detail-span d-block mb-0" id="subCategory"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" style="display: none;">
                        <div class="d-flex mb-4 each-detail-box">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="bx bx-message-edit"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <label class="details-label form-label mb-1">Nested Category:</label>
                                <span class="detail-span d-block mb-0" id="nestedCategory"></span>
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
