@extends('admin.layouts.app')
@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="{{ route('admin.show.roles') }}" class="btn backBtn waves-effect waves-light"><i class=" ti-arrow-left"></i> Back</a>
        </div>
        <h4 class="page-title">Edit Permissions</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setup Admin</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.show.roles') }}">Roles</a></li>
            <li class="breadcrumb-item active">Edit Permissions</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title PermissionAll">Permission Lists</h4>
            <p class="text-muted font-14 m-b-30"></p>

            <div class="col-md-12 p-r-0" style="display: flex; flex-direction: row; justify-content: flex-end;">
                <div class="PermiAll">
                    <label style="padding: 1px 20px; font-size: 20px; font-weight: bold;">Permission all </label>
                    <input type="checkbox" id="CheckAll" checked name="CheckAll" value="0" />
                </div>
                <div class="form-group text-right m-b-0 m-l-10" style="align-self: center;">
                    <button type="submit" id="updatePermissionBtnTop" class="btn updateBtn waves-effect waves-light" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                </div>
            </div>

            <form action="{{route('admin.update.permissions')}}" method="POST" id="updatePermissionForm">
                @csrf

                <input type="hidden" name="role_id" value="{{ $data['roleId'] }}">

                <table id="setupAdmin-permission-listing" class="table tableStyle table-bordered dt-responsive nowrap" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Modules</th>
                            <th>Sub Module</th>
                            <th>Access Item</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Other</th>
                        </tr>
                    </thead>

                    <tbody> </tbody>
                </table>
                <br>
                <div class="form-group text-right m-b-0">
                    <button type="submit" id="updatePermissionBtn" class="btn updateBtn waves-effect waves-light" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                </div>
            </form>
        </div>
    </div>
</div> 

<style>
    #rolePermission-permission-listing_wrapper .row:nth-child(2) .col-sm-12{
        padding: 0;
    }
</style>
@endsection



                   