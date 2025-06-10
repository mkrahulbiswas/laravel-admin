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
                <div class="d-sm-flex align-items-center justify-content-between"></div>
            </div>
        </div>
    </div>

    <div class="row main-page-content">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header cardHeader">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title mb-0">Arrange your current nav order</h5>
                            <span>Test</span>
                        </div>
                    </div>
                </div>
                <div class="card-body cardBody">
                    <div class="row navOrderable">
                        <div class="col-md-12 mb-4 no_noteMain">
                            <div class="no_noteSub bg-light">
                                <dl class="row mb-0 p-2">
                                    <dt class="col-12 no_noteHeading">Hear in bellow according to color type is mention the side nav types.</dt>
                                    <dd class="col-12 mb-0 mt-2">
                                        <div class="no_noteBody col-12 d-flex flex-row justify-content-between">
                                            <div class="no_noteCommon bg-info-subtle">
                                                <span class="no_noteText">Color <span class="no_colorType"></span> is denote to <b>Nav Type</b></span>
                                            </div>
                                            <div class="no_noteCommon bg-info-subtle">
                                                <span class="no_noteText">Color <span class="no_colorMain"></span> is denote to <b>Main Nav</b></span>
                                            </div>
                                            <div class="no_noteCommon bg-info-subtle">
                                                <span class="no_noteText">Color <span class="no_colorSub"></span> is denote to <b>Sub Nav</b></span>
                                            </div>
                                            <div class="no_noteCommon bg-info-subtle">
                                                <span class="no_noteText">Color <span class="no_colorNested"></span> is denote to <b>Nested type</b></span>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="col-md-12 no_listMain">
                            <div class="no_listSub">
                                <form method="post" id="updateArrangeNavForm" action="{{ route('admin.update.arrangeNav') }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="navTypeInner allNavCommon">
                                                @foreach ($navList as $itemOne)
                                                    <div class="navTypeList navListCommon">
                                                        <div class="navTypeHeading commonNavHeading">
                                                            <div class="navHeadingTop">
                                                                <i class="bx bx-cable-car"></i>
                                                            </div>
                                                            <div class="navHeadingBottom">
                                                                <span>{{ $itemOne['name'] }}</span>
                                                                <span>{{ $itemOne['uniqueId'] }}</span>
                                                            </div>
                                                            {{-- <input type="hidden" name="navType[]" value="{{ $itemOne['id'] }}"> --}}
                                                            <input type="hidden" name="navType[]" value="{{ decrypt($itemOne['id']) }}">
                                                        </div>
                                                        @if (sizeof($itemOne[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')]) > 0)
                                                            <div class="navMainInner allNavCommon">
                                                                @foreach ($itemOne[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')] as $itemTwo)
                                                                    <div class="navMainList navListCommon">
                                                                        <div class="navMainHeading commonNavHeading">
                                                                            <div class="navHeadingTop">
                                                                                <i class="bx bx-cable-car"></i>
                                                                            </div>
                                                                            <div class="navHeadingBottom">
                                                                                <span>{{ $itemTwo['name'] }}</span>
                                                                                <span>{{ $itemTwo['uniqueId'] }}</span>
                                                                            </div>
                                                                            {{-- <input type="hidden" name="navMain[]" value="{{ $itemTwo['id'] }}"> --}}
                                                                            <input type="hidden" name="navMain[]" value="{{ decrypt($itemTwo['id']) }}">
                                                                        </div>
                                                                        @if (sizeof($itemTwo[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')]) > 0)
                                                                            <div class="navSubInner allNavCommon">
                                                                                @foreach ($itemTwo[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')] as $itemThree)
                                                                                    <div class="navSubList navListCommon">
                                                                                        <div class="navSubHeading commonNavHeading">
                                                                                            <div class="navHeadingTop">
                                                                                                <i class="bx bx-cable-car"></i>
                                                                                            </div>
                                                                                            <div class="navHeadingBottom">
                                                                                                <span>{{ $itemThree['name'] }}</span>
                                                                                                <span>{{ $itemThree['uniqueId'] }}</span>
                                                                                            </div>
                                                                                            {{-- <input type="hidden" name="navSub[]" value="{{ $itemThree['id'] }}"> --}}
                                                                                            <input type="hidden" name="navSub[]" value="{{ decrypt($itemThree['id']) }}">
                                                                                        </div>
                                                                                        @if (sizeof($itemThree[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')]) > 0)
                                                                                            <div class="navNestedInner allNavCommon">
                                                                                                @foreach ($itemThree[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')] as $itemFour)
                                                                                                    <div class="navNestedList navListCommon">
                                                                                                        <div class="navNestedHeading commonNavHeading">
                                                                                                            <div class="navHeadingTop">
                                                                                                                <i class="bx bx-cable-car"></i>
                                                                                                            </div>
                                                                                                            <div class="navHeadingBottom">
                                                                                                                <span>{{ $itemFour['name'] }}</span>
                                                                                                                <span>{{ $itemFour['uniqueId'] }}</span>
                                                                                                            </div>
                                                                                                            {{-- <input type="hidden" name="navNested[]" value="{{ $itemFour['id'] }}"> --}}
                                                                                                            <input type="hidden" name="navNested[]" value="{{ decrypt($itemFour['id']) }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @else
                                                                                        @endif
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @else
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light" id="updateArrangeNavBtn">
                                                <i class="las la-save label-icon align-middle fs-16"></i>
                                                <span>Save</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
