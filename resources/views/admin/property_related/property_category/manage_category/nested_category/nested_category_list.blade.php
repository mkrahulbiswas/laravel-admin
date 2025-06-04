<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header cardHeader">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title mb-1">Manage category</h5>
                        <span class="text-muted">From this section you can manage <b>nested category</b> list data</span>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between">
                        @if ($permission['add']['permission'] == true)
                            <button type="button" class="btn btn-success btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#con-add-modal">
                                <i class="las la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                <span>Add Nested Category</span>
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
                                        <form id="filterNestedCategoryForm" method="POST" action="{{ route('admin.get.manageCategory') }}" class="m-b-20">
                                            @csrf
                                            <div class="row gap-2">
                                                <div class="form-element col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2">
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
                                                            <button type="button" class="btn btn-info btn-label waves-effect waves-light filterNestedCategoryBtn" title="Search">
                                                                <i class="mdi mdi-briefcase-search-outline label-icon align-middle fs-16 me-2"></i>
                                                                <span>Search</span>
                                                            </button>
                                                        @endif
                                                        @if ($permission['reset']['permission'] == true)
                                                            <button type="button" class="btn btn-danger btn-label waves-effect waves-light filterNestedCategoryBtn ms-2" title="Reload">
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
                            <table id="propertyRelated-propertyCategory-manageCategory-nested" class="table table-bordered dt-responsive nowrap table-striped align-middle" cellspacing="0" width="100%" data-type="{{ Config::get('constants.status.nested') }}">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unique Id</th>
                                        <th>Name</th>
                                        <th>About</th>
                                        <th>Status</th>
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
