@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        @if($itemPermission['add_item']=='1')
        <div class="btn-group pull-right m-t-15">
            <button type="button" data-toggle="modal" data-target="#con-add-modal"  class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add New FAQ</button>
        </div>
        @endif
        <h4 class="page-title">FAQ</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CMS</a></li>
            <li class="breadcrumb-item active">FAQ</li>
        </ol>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">FAQ List</h4>
            <p class="text-muted font-14 m-b-30">
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
            </p>

            <table id="cms-faq-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Answer</th>
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
                        <h4 class="modal-title">Add FAQ</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="saveFaqForm" action="{{ route('admin.save.faq') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label for="question">Question<span class="text-danger">*</span></label>
                                    <textarea name="question" cols="2" rows="2" id="question" class="form-control" placeholder="Question"></textarea>
                                    <span role="alert" id="questionErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="answer">Answer<span class="text-danger">*</span></label>
                                    <textarea name="answer" cols="4" rows="4" id="answer" class="form-control" placeholder="Answer"></textarea>
                                    <span role="alert" id="answerErr" style="color:red;font-size: 12px"></span>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal">Close</button>
                            <button type="submit" id="saveFaqBtn"  class="btn saveBtn waves-effect waves-light"><i class="ti-save"></i> <span>Save</span></button>
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
                        <h4 class="modal-title">Update FAQ</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateFaqForm" action="{{ route('admin.update.faq') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="id" id="id" value="">

                                <div class="form-group col-md-12">
                                    <label for="question">Question<span class="text-danger">*</span></label>
                                    <textarea name="question" cols="2" rows="2" id="question" class="form-control" placeholder="Question"></textarea>
                                    <span role="alert" id="questionErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="answer">Answer<span class="text-danger">*</span></label>
                                    <textarea name="answer" cols="4" rows="4" id="answer" class="form-control" placeholder="Answer"></textarea>
                                    <span role="alert" id="answerErr" style="color:red;font-size: 12px"></span>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateFaqBtn"  class="btn updateBtn waves-effect waves-light"><i class="ti-save"></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-detail-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Details FAQ</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="col-md-12">
                                <label style="font-weight: bold">Question:- </label>
                                <span id="question"></span>
                            </div>

                            <div class="col-md-12">
                                <label style="font-weight: bold">Answer:- </label>
                                <span id="answer"></span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
