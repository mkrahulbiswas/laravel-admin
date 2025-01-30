@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Contact Enquiry</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CMS</a></li>
            <li class="breadcrumb-item active">Contact Enquiry</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Contact Enquiry</h4>
            <p class="text-muted font-14 m-b-30">
                <div class="alert alert-danger" id="alert" style="display: none">
                    <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
                </div>
            </p>

            <table id="cms-contactEnquiry-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
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
        <div id="con-detail-modal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Details Contact Enquiry</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="row">

                                <div class="col-md-6">
                                    <label style="font-weight: bold">Name:- </label>
                                    <span id="name"></span>
                                </div>

                                <div class="col-md-6">
                                    <label style="font-weight: bold">Email:- </label>
                                    <span id="email"></span>
                                </div>

                                <div class="col-md-6">
                                    <label style="font-weight: bold">Phone:- </label>
                                    <span id="phone"></span>
                                </div>

                                <div class="col-md-6">
                                    <label style="font-weight: bold">Date:- </label>
                                    <span id="date"></span>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="col-md-12">
                                    <label style="font-weight: bold">Messege:- </label>
                                    <span id="content"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
