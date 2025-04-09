@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Orders List</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Manage Orders</a></li>
            <li class="breadcrumb-item active">Orders List</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Orders List</h4>
            <p class="text-muted font-14 m-b-30"> </p>

            <form id="filterOrdersForm" method="POST" action="{{ route('admin.get.orders') }}" class="m-b-20">
                @csrf

                <input type="hidden" name="id" id="id" value="">

                <div class="row" style="background-color: #fff; padding-top: 20px; box-shadow: 0 5px 10px #bfbfbf; margin: 0; padding: 0;">

                    <div class="col-md-12 p-t-10 m-b-10">
                        <p style="color: #000 !important; text-decoration: underline; font-size: 18px;">Filter Your Table Data:-</p>
                    </div>

                    <div class="col-md-2 m-t-5">
                        <select name="payMode" id="payModeFilter" class="advance-select-payMode form-control">
                            <option value="">Select Order Type</option>
                            <option value="{{ config('constants.payMode')['cod'] }}">{{ Str::replace('_', ' ', config('constants.payMode')['cod']) }}</option>
                            <option value="{{ config('constants.payMode')['online'] }}">{{ Str::replace('_', ' ', config('constants.payMode')['online']) }}</option>
                        </select>
                    </div>

                    <div class="col-md-2 m-t-5">
                        <select name="status" id="statusFilter" class="advance-select-status form-control">
                            <option value="">Select Status</option>
                            <option value="{{ config('constants.status')['pending'] }}">{{ Str::replace('_', ' ', config('constants.status')['pending']) }}</option>
                            <option value="{{ config('constants.status')['placed'] }}">{{ Str::replace('_', ' ', config('constants.status')['placed']) }}</option>
                            <option value="{{ config('constants.status')['accepted'] }}">{{ Str::replace('_', ' ', config('constants.status')['accepted']) }}</option>
                            <option value="{{ config('constants.status')['rejected'] }}">{{ Str::replace('_', ' ', config('constants.status')['rejected']) }}</option>
                            <option value="{{ config('constants.status')['canceled'] }}">{{ Str::replace('_', ' ', config('constants.status')['canceled']) }}</option>
                            <option value="{{ config('constants.status')['readyForPackaging'] }}">{{ Str::replace('_', ' ', config('constants.status')['readyForPackaging']) }}</option>
                            <option value="{{ config('constants.status')['dispatched'] }}">{{ Str::replace('_', ' ', config('constants.status')['dispatched']) }}</option>
                            <option value="{{ config('constants.status')['delivered'] }}">{{ Str::replace('_', ' ', config('constants.status')['delivered']) }}</option>
                        </select>
                    </div>

                    <div class="col-md-2 m-t-5">
                        <div class="form-group d-flex flex-row justify-content-around">
                          <button class="btn searchBtn filterOrdersBtn" title="Search" type="button"><i class=""></i> Search</button>
                          <button class="btn reloadBtn filterOrdersBtn" title="Reload" type="button"><i class=""></i> Reload</button>
                        </div>
                    </div>

                </div>
            </form>

            <table id="manageOrders-orders-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <td>Order ID</td>
                        <td>Total Item</td>
                        <td>Order Type</td>
                        <td>Order Date</td>
                        <td>Status</td>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div id="con-edit-modal" class="con-edit-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Order Status</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateStatusForm" action="{{ route('admin.status.orders') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <input type="hidden" name="id" id="id" value="">

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="status">Featured<span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="advance-select-status form-control">
                                        <option value="">Select Status</option>
                                        <option value="{{ config('constants.status')['pending'] }}">{{ Str::replace('_', ' ', config('constants.status')['pending']) }}</option>
                                        <option value="{{ config('constants.status')['placed'] }}">{{ Str::replace('_', ' ', config('constants.status')['placed']) }}</option>
                                        <option value="{{ config('constants.status')['accepted'] }}">{{ Str::replace('_', ' ', config('constants.status')['accepted']) }}</option>
                                        <option value="{{ config('constants.status')['rejected'] }}">{{ Str::replace('_', ' ', config('constants.status')['rejected']) }}</option>
                                        <option value="{{ config('constants.status')['readyForPackaging'] }}">{{ Str::replace('_', ' ', config('constants.status')['readyForPackaging']) }}</option>
                                        <option value="{{ config('constants.status')['dispatched'] }}">{{ Str::replace('_', ' ', config('constants.status')['dispatched']) }}</option>
                                        <option value="{{ config('constants.status')['delivered'] }}">{{ Str::replace('_', ' ', config('constants.status')['delivered']) }}</option>
                                    </select>
                                    <span role="alert" id="statusErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-12" style="display: none;">
                                    <label for="reason">Reason<span class="text-danger">*</span></label>
                                    <textarea name="reason" id="reason" class="form-control" placeholder="Reason" cols="5" rows="5"></textarea>
                                    <span role="alert" id="reasonErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" id="updateStatusBtn"  class="btn updateBtn waves-effect waves-light"><i class=""></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
