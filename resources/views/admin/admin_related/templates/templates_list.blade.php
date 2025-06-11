@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="mb-3 mb-sm-0">
                    <h4>Templates</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Related</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quick Settings</a></li>
                            <li class="breadcrumb-item active">Templates</li>
                        </ol>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between"></div>
            </div>
        </div>
    </div>

    <div class="row main-page-content">
        <div class="col-12">
            <div class="card-body cardBodyTab">
                <ul class="nav nav-pills nav-customs nav-danger ulNavList" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none">
                                <i class="mdi mdi-email"></i>
                            </span>
                            <span class="d-none d-sm-block">Email Templates</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none">
                                <i class="las las la-sms"></i>
                            </span>
                            <span class="d-none d-sm-block">SMS Templates</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <div class="tab-pane active show" id="arrow-overview" role="tabpanel">
                        @include('admin.property_related.property_category.manage_category.main_category.main_category_list')
                    </div>
                    <div class="tab-pane" id="arrow-profile" role="tabpanel">
                        @include('admin.property_related.property_category.manage_category.main_category.main_category_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
