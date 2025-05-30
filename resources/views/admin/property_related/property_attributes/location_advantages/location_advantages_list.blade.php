@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Location Advantages</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Property Related</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Property Attributes</a></li>
                            <li class="breadcrumb-item active">Location Advantages</li>
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
                            <span>Test</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between">
                            @if ($permission['add']['permission'] == true)
                                <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                    <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                    <span>Add Nav Type</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 tdContentMain">
                            <div class="tdContentSub">
                                <table id="propertyRelated-propertyAttributes-locationAdvantages" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Name</th>
                                            <th>About</th>
                                            <th>Stats Info</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Unique Id</th>
                                            <th>Name</th>
                                            <th>About</th>
                                            <th>Stats Info</th>
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
                <form id="saveLocationAdvantagesForm" action="{{ route('admin.save.locationAdvantages') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Nav Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type">
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="saveLocationAdvantagesBtn">
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
                <form id="updateLocationAdvantagesForm" action="{{ route('admin.update.locationAdvantages') }}" method="POST" enctype="multipart/form-data" novalidate class="common-form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Nav Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-element col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">{{ __('messages.requiredFiend') }}</span></label>
                                <div class="form-icon set-validation">
                                    <input type="text" name="name" class="form-control form-control-icon" id="name" placeholder="Nav type">
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
                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateLocationAdvantagesBtn">
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
                    <h5 class="modal-title" id="myModalLabel">Details Nav Type</h5>
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
                                    <label class="details-label form-label mb-1">Name :</label>
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
