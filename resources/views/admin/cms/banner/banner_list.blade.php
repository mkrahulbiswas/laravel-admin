@extends('admin.layouts.app')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            @if ($itemPermission['add_item'] == '1')
                <div class="btn-group pull-right m-t-15">
                    <button type="button" data-toggle="modal" data-target="#con-add-modal" class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add Banner</button>
                </div>
            @endif
            <h4 class="page-title">Banner</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">CMS</a></li>
                <li class="breadcrumb-item active">Banner</li>
            </ol>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title">Banner List</h4>
                <p class="text-muted font-14 m-b-30">
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
                </p>

                <form id="filterBannerForm" method="POST" action="{{ route('admin.get.banner') }}" class="m-b-20">
                    @csrf

                    <div class="row" style="background-color: #fff; padding-top: 20px; box-shadow: 0 5px 10px #bfbfbf; margin: 0; padding: 0;">

                        <div class="col-md-12 p-t-10 m-b-10">
                            <p style="color: #000 !important; text-decoration: underline; font-size: 18px;">Filter Your Table Data:-</p>
                        </div>

                        <div class="col-md-4 m-t-5">
                            <select name="for" id="forFilter" class="form-control">
                                <option value="">Select Image For</option>
                                @foreach (config('constants.bannerFor') as $item)
                                    <option value="{{ $item }}">{{ Str::replace('_', ' ', $item) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 m-t-5">
                            <div class="form-group d-flex flex-row justify-content-around">
                                <button class="btn searchBtn filterBannerBtn" title="Search" type="button"><i class=""></i> Search</button>
                                <button class="btn reloadBtn filterBannerBtn" title="Reload" type="button"><i class=""></i> Reload</button>
                            </div>
                        </div>

                    </div>
                </form>

                <table id="cms-banner-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div id="con-add-modal" data-type="logo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Banner</h4>
                            <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="saveBannerForm" action="{{ route('admin.save.banner') }}" method="POST" enctype="multipart/form-data" novalidate="">
                            @csrf

                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="for">Image For<span class="text-danger">*</span></label>
                                        <select name="for" id="for" class="form-control">
                                            <option value="">Select Image For</option>
                                            @foreach (config('constants.bannerFor') as $item)
                                                <option value="{{ $item }}">{{ Str::replace('_', ' ', $item) }}</option>
                                            @endforeach
                                        </select>
                                        <span role="alert" id="forErr" style="color:red;font-size: 12px"></span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="file"><strong>Note:&nbsp;</strong> Image should be under 1 to 2 MB<span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-lg-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="file" name="file" id="file" class="dropify">
                                                    </div>
                                                    <span role="alert" id="fileErr" style="color:red;font-size: 12px"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="alert alert-danger" id="alert" style="display: none">
                                <center><strong id="validationAlert"></strong></center>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal">Close</button>
                                <button type="submit" id="saveBannerBtn" class="btn saveBtn waves-effect waves-light"><i class="ti-save"></i> <span>Save</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div id="con-edit-modal" data-type="logo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Banner</h4>
                            <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateBannerForm" action="{{ route('admin.update.banner') }}" method="PUT" enctype="multipart/form-data" novalidate="">
                            @csrf

                            <div class="modal-body">
                                <div class="row">

                                    <input type="hidden" name="id" id="id" value="">

                                    <div class="form-group col-md-12">
                                        <label for="for">Image For<span class="text-danger">*</span></label>
                                        <select name="for" id="for" class="form-control">
                                            <option value="">Select Image For</option>
                                            @foreach (config('constants.bannerFor') as $item)
                                                <option value="{{ $item }}">{{ Str::replace('_', ' ', $item) }}</option>
                                            @endforeach
                                        </select>
                                        <span role="alert" id="forErr" style="color:red;font-size: 12px"></span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="file"><strong>Note:&nbsp;</strong> Image should be under 1 to 2 MB<span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-lg-6 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="file" name="file" id="file" class="dropify">
                                                    </div>
                                                    <span role="alert" id="fileErr" style="color:red;font-size: 12px"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 grid-margin stretch-card">
                                                <img src="" class="img-responsive img-thumbnail" style="height: 240px">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="alert alert-danger" id="alert" style="display: none">
                                <center><strong id="validationAlert"></strong></center>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal">Close</button>
                                <button type="submit" id="updateBannerBtn" class="btn updateBtn waves-effect waves-light"><i class="ti-save"></i> <span>Update</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
