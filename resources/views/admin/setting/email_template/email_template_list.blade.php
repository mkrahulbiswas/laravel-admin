@extends('admin.layouts.app')
@section('content')

<div class="row mbliviwbrd">
    <div class="col-sm-12">
        <h4 class="page-title">Email Template</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setting</a></li>
            <li class="breadcrumb-item active">Email Template</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Email Template List</h4>
            <p class="text-muted font-14 m-b-30"></p>

            <table id="setting-emailTemplate-listing" class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Slug</th>
                        <th>Variable</th>
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
        <div id="con-edit-modal" data-type="logo" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Email Template</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateEmailTemplateForm" action="{{ route('admin.update.emailTemplate') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="isFile" id="isFile" value="">

                                <div class="form-group col-md-12">
                                    <label for="subject">Page For (Note: It also used as mail subject)<span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Page For">
                                    <span role="alert" id="subjectErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="content">Content<span class="text-danger">*</span></label>
                                    <textarea name="content" id="content" class="summernote form-control" placeholder="Content"></textarea>
                                    <span role="alert" id="contentErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="file"><strong>Note:&nbsp;</strong> File must be PDF type<span class="text-danger"></span></label>
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
                                            <img src="" class="file img-responsive img-thumbnail" style="height: 240px">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                            <button type="submit" id="updateEmailTemplateBtn"  class="btn updateBtn waves-effect waves-light"><i class="ti-save"></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-detail-modal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Details Email Template</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="col-md-12">
                                <label style="font-weight: bold">Subject:- </label>
                                <span id="subject"></span>
                            </div>

                            <div class="col-md-12">
                                <label style="font-weight: bold">File:- </label>
                                <a href="" id="file" target="_blank">File Link</a>
                            </div>

                            <div class="col-md-12">
                                <label style="font-weight: bold">Variable:- </label>
                                <span id="variable"></span>
                            </div>

                            <div class="col-md-12">
                                <label style="font-weight: bold">Content:- </label>
                                <span id="content"></span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
