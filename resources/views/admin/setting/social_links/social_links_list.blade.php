@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row mbliviwbrd">
    <div class="col-sm-12">
        @if($itemPermission['add_item']=='1')
        <div class="btn-group pull-right m-t-15">
            <button type="button" data-toggle="modal" data-target="#con-add-modal"  class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add Social Links</button>
        </div>
        @endif
        <h4 class="page-title">Social Links</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setting</a></li>
            <li class="breadcrumb-item active">Social Links</li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Social Links List</h4>
            <p class="text-muted font-14 m-b-30">
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
            </p>

            <table id="setting-socialLinks-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Icon</th>
                        <th>Link</th>
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
                        <h4 class="modal-title">Add Social Links</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="saveSocialLinksForm" action="{{ route('admin.save.socialLinks') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="title">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                    <span role="alert" id="titleErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="icon">Icon<span class="text-danger">*</span></label>
                                    <input type="text" name="icon" id="icon" class="form-control" placeholder="Icon">
                                    <span role="alert" id="iconErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="link">Link<span class="text-danger">*</span></label>
                                    <input type="text" name="link" id="link" class="form-control" placeholder="Link">
                                    <span role="alert" id="linkErr" style="color:red;font-size: 12px"></span>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                            <button type="submit" id="saveSocialLinksBtn"  class="btn saveBtn waves-effect waves-light"><i class="ti-save"></i> <span>Save</span></button>
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
                        <h4 class="modal-title">Update Social Links</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateSocialLinksForm" action="{{ route('admin.update.socialLinks') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="id" id="id" value="">

                                <div class="form-group col-md-6">
                                    <label for="title">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                    <span role="alert" id="titleErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="icon">Icon<span class="text-danger">*</span></label>
                                    <input type="text" name="icon" id="icon" class="form-control" placeholder="Icon">
                                    <span role="alert" id="iconErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="link">Link<span class="text-danger">*</span></label>
                                    <input type="text" name="link" id="link" class="form-control" placeholder="Link">
                                    <span role="alert" id="linkErr" style="color:red;font-size: 12px"></span>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                            <button type="submit" id="updateSocialLinksBtn"  class="btn updateBtn waves-effect waves-light"><i class="ti-save"></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
