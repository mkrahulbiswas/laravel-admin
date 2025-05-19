@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Arrange Nav</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Panel</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage Nav</a></li>
                            <li class="breadcrumb-item active">Arrange Nav</li>
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
                            <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal"><i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i> Add Nav Type</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4"></div>
                        <div class="col-md-12 tdContentMain">
                            <div class="tdContentSub">
                                <div class="all-nav-list" id="toNavType">
                                    @foreach ($navList as $itemOne)
                                        <div class="nav-type-list list-group-item" id="">
                                            <div class="nav-type-heading common-nav-heading">{{ $itemOne['uniqueId'] }}</div>
                                            @if (sizeof($itemOne[Config::get('constants.typeCheck.manageNav.navMain.type')]) > 0)
                                                <div class="nav-main-inner">
                                                    @foreach ($itemOne[Config::get('constants.typeCheck.manageNav.navMain.type')] as $itemTwo)
                                                        <div class="nav-main-list list-group-item items" id="">
                                                            <div class="nav-main-heading common-nav-heading">{{ $itemTwo['uniqueId'] }}</div>
                                                            {{-- @if (sizeof($itemTwo[Config::get('constants.typeCheck.manageNav.navSub.type')]) > 0)
                                        @foreach ($itemTwo[Config::get('constants.typeCheck.manageNav.navSub.type')] as $itemThree)
                                        <div class="nav-sub-list list-group-item items">
                                            <div class="nav-sub-heading common-nav-heading">{{ $itemThree['uniqueId'] }}</div>
                                            @if (sizeof($itemThree[Config::get('constants.typeCheck.manageNav.navNested.type')]) > 0)
                                            @foreach ($itemThree[Config::get('constants.typeCheck.manageNav.navNested.type')] as $itemFour)
                                            <div class="nav-nested-list list-group-item items">
                                                <div class="nav-nested-heading common-nav-heading">{{ $itemFour['uniqueId'] }}</div>
                                            </div>
                                            @endforeach
                                            @else
                                            @endif
                                        </div>
                                        @endforeach
                                        @else
                                        @endif --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="con-detail-modal" class="modal fade con-detail-modal con-common-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                    <button type="button" class="btn btn-danger btn-label waves-effect waves-light" data-bs-dismiss="modal"><i class="las la-window-close label-icon align-middle fs-16 me-2"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
