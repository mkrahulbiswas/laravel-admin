@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Logo</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Panel</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quick Settings</a></li>
                            <li class="breadcrumb-item active">Logo</li>
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
                            <h5 class="card-title mb-1">Logo</h5>
                            <span>From this section you can manage logo for everywhere.</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between">
                            @if ($permission['add']['permission'] == true)
                                <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                    <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                    <span>Add Sub Role</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
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

    <div id="con-add-modal" class="modal fade bs-example-modal-lg con-add-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="saveLogoForm" action="{{ route('admin.save.logo') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Logo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="about" class="form-label">Big Logo</label>
                                <div class="input-group set-validation">
                                    <input type="file" class="dropify" data-max-file-size="1M" name="bigLogo" id="bigLogo">
                                </div>
                                <div class="validation-error" id="bigLogoErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="about" class="form-label">Small Logo</label>
                                <div class="input-group set-validation">
                                    <input type="file" class="dropify" data-max-file-size="1M" name="smallLogo" id="smallLogo">
                                </div>
                                <div class="validation-error" id="smallLogoErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <label for="about" class="form-label">Favicon</label>
                                <div class="input-group set-validation">
                                    <input type="file" class="dropify" data-max-file-size="1M" name="favicon" id="favicon">
                                </div>
                                <div class="validation-error" id="faviconErr"></div>
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveLogoBtn">
                                <i class="las la-save label-icon align-middle fs-16 me-2"></i>
                                <span>Save</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="con-edit-modal" class="modal fade bs-example-modal-lg con-edit-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="updateLogoForm" action="{{ route('admin.update.logo') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Logo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="about" class="form-label">Big Logo</label>
                                <div class="input-group set-validation">
                                    <div class="d-flex justify-between gap-3">
                                        <div class="col-md-6">
                                            <input type="file" name="bigLogo" id="bigLogo" class="dropify" data-max-file-size="1M">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="" class="img-responsive img-thumbnail" style="height: 200px">
                                        </div>
                                    </div>
                                </div>
                                <div class="validation-error" id="bigLogoErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="about" class="form-label">Small Logo</label>
                                <div class="input-group set-validation">
                                    <div class="d-flex justify-between gap-3">
                                        <div class="col-md-6">
                                            <input type="file" name="smallLogo" id="smallLogo" class="dropify" data-max-file-size="1M">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="" class="img-responsive img-thumbnail" style="height: 200px">
                                        </div>
                                    </div>
                                </div>
                                <div class="validation-error" id="smallLogoErr"></div>
                            </div>
                            <div class="form-element col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="about" class="form-label">Favicon</label>
                                <div class="input-group set-validation">
                                    <div class="d-flex justify-between gap-3">
                                        <div class="col-md-6">
                                            <input type="file" name="favicon" id="favicon" class="dropify" data-max-file-size="1M">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="" class="img-responsive img-thumbnail" style="height: 200px">
                                        </div>
                                    </div>
                                </div>
                                <div class="validation-error" id="faviconErr"></div>
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateLogoBtn">
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
                    <h5 class="modal-title" id="myModalLabel">Details Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row info-page-data">

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Big Logo:</label>
                                    <span class="detail-span d-block mb-0" id="bigLogo">
                                        <img src="" alt="" height="200px">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Small Logo:</label>
                                    <span class="detail-span d-block mb-0" id="smallLogo">
                                        <img src="" alt="" height="200px">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6 col-lg-6">
                            <div class="d-flex mb-4 each-detail-box">
                                <div class="flex-grow-1 overflow-hidden">
                                    <label class="details-label form-label mb-1">Favicon:</label>
                                    <span class="detail-span d-block mb-0" id="favicon">
                                        <img src="" alt="" height="200px">
                                    </span>
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
