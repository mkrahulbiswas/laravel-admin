@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        @if($itemPermission['add_item']=='1')
        <div class="btn-group pull-right m-t-15">
            <button type="button" data-toggle="modal" data-target="#con-add-modal"  class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add Logo</button>
        </div>
        @endif
        <h4 class="page-title">Logo</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setting</a></li>
            <li class="breadcrumb-item active">Logo</li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Category Lists</h4>
            <p class="text-muted font-14 m-b-30">
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
            </p>

            <table id="cms-logo-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Big Logo</th>
                        <th>Small Logo</th>
                        <th>Fav Icon</th>
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
                        <h4 class="modal-title">Add Logo</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="saveLogoForm" action="{{ route('admin.save.logo') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label for="bigLogo"><strong>Note:&nbsp;</strong> Big Logo<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="file" name="bigLogo" id="bigLogo" class="dropify">
                                                </div>
                                                <span role="alert" id="bigLogoErr" style="color:red;font-size: 12px"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="smallLogo"><strong>Note:&nbsp;</strong> Small Logo<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="file" name="smallLogo" id="smallLogo" class="dropify">
                                                </div>
                                                <span role="alert" id="smallLogoErr" style="color:red;font-size: 12px"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="favIcon"><strong>Note:&nbsp;</strong> FAv Icon<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="file" name="favIcon" id="favIcon" class="dropify">
                                                </div>
                                                <span role="alert" id="favIconErr" style="color:red;font-size: 12px"></span>
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
                            <button type="submit" id="saveLogoBtn"  class="btn saveBtn waves-effect waves-light"><i class="ti-save"></i> <span>Save</span></button>
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
                        <h4 class="modal-title">Update Logo</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateLogoForm" action="{{ route('admin.update.logo') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="id" id="id" value="">

                                <div class="form-group">
                                    <label for="bigLogo"><strong>Note:&nbsp;</strong> Big Logo<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="file" name="bigLogo" id="bigLogo" class="dropify">
                                                </div>
                                                <span role="alert" id="bigLogoErr" style="color:red;font-size: 12px"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 grid-margin stretch-card">
                                            <img src="" class="bigLogo img-responsive img-thumbnail" style="height: 240px">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="smallLogo"><strong>Note:&nbsp;</strong> Small Logo<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="file" name="smallLogo" id="smallLogo" class="dropify">
                                                </div>
                                                <span role="alert" id="smallLogoErr" style="color:red;font-size: 12px"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 grid-margin stretch-card">
                                            <img src="" class="smallLogo img-responsive img-thumbnail" style="height: 240px">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="favIcon"><strong>Note:&nbsp;</strong> FAv Icon<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="file" name="favIcon" id="favIcon" class="dropify">
                                                </div>
                                                <span role="alert" id="favIconErr" style="color:red;font-size: 12px"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 grid-margin stretch-card">
                                            <img src="" class="favIcon img-responsive img-thumbnail" style="height: 240px">
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
                            <button type="submit" id="updateLogoBtn"  class="btn updateBtn waves-effect waves-light"><i class="ti-save"></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
