@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        @if($itemPermission['add_item']=='1')
        <div class="btn-group pull-right m-t-15">
            <a href="{{ route('admin.add.client') }}" class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add New Client</a>
        </div>
        @endif
        <h4 class="page-title">Client List</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Users</a></li>
            <li class="breadcrumb-item active">Client List</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Client List</h4>
            <p class="text-muted font-14 m-b-30"> </p>

            <table id="users-client-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <td>Image</td>
                        <td>Name</td>
                        <td>Phone</td>
                        <td>Email</td>
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


@endsection
