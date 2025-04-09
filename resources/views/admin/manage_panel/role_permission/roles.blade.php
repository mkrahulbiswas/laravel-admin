@extends('admin.layouts.app')
@section('content')


<div class="row">
    <div class="col-sm-12">
        @if($itemPermission['add_item']=='1')
        <div class="btn-group pull-right m-t-15">
            <button type="button" data-toggle="modal" data-target="#con-add-modal" class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add Role</button>
        </div>
        @endif

        <h4 class="page-title">Roles</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setup Admin</a></li>
            <li class="breadcrumb-item active">Roles</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Role Lists</h4>
            <p class="text-muted font-14 m-b-30"></p>

            <table id="setupAdmin-role-listing" class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Roles</th>
                        <th>Description</th>
                        <th>Status</th>
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
        <div id="con-add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="{{route('admin.save.roles')}}" method="POST" id="saveRoleForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Role<span class="text-danger">*</span></label>
                                        <input type="text" name="role" placeholder="Role" class="form-control" id="role">
                                        <span role="alert" id="roleErr" style="color:red;font-size: 12px"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Description<span class="text-danger">*</span></label>
                                        <textarea name="description" placeholder="Role Description" class="form-control" id="description"></textarea>
                                        <span role="alert" id="descriptionErr" style="color:red;font-size: 12px"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" class="btn saveBtn waves-effect waves-light" id="saveRoleBtn" type="submit"><i class="ti-save"></i> <span> Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div id="con-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="{{route('admin.update.roles')}}" method="POST" id="updateRoleForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Role<span class="text-danger">*</span></label>
                                        <input type="text" name="role" placeholder="Role" class="form-control" id="role">
                                        <span role="alert" id="roleErr" style="color:red;font-size: 12px"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Description<span class="text-danger">*</span></label>
                                        <textarea name="description" placeholder="Role Description" class="form-control" id="description"></textarea>
                                        <span role="alert" id="descriptionErr" style="color:red;font-size: 12px"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" class="btn updateBtn waves-effect waves-light" id="updateRoleBtn" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div id="con-detail-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail View Of Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="com-md-12">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role"><b>Role: </b></label>
                                        <span id="role"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="description"><b>Description: </b></label>
                                        <span id="description"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class=""></i> Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection



                   