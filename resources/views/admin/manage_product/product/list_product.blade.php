@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        @if($itemPermission['add_item']=='1')
        <div class="btn-group pull-right m-t-15">
            <a href="{{ route('admin.add.product') }}" class="btn addBtn waves-effect waves-light"><i class="ion-plus-circled"></i> Add New Product</a>
        </div>
        @endif
        <h4 class="page-title">Manage Product List</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Package Master</a></li>
            <li class="breadcrumb-item active">Manage Product List</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Product List</h4>
            <p class="text-muted font-14 m-b-30"> </p>

            <table id="manageProduct-product-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <td>Image</td>
                        <td>Title</td>
                        <td>Price</td>
                        <td>Featured</td>
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
                        <h4 class="modal-title">Update Product Display</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateDisplayProductForm" action="{{ route('admin.display.product') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <input type="hidden" name="id" id="id" value="">

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="featured">Featured<span class="text-danger">*</span></label>
                                    <select name="featured" id="featured" class="selectpicker" data-style="btn-success btn-custom">
                                        <option value="">Select Featured Action</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span role="alert" id="featuredErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="topTrending">Top Trending<span class="text-danger">*</span></label>
                                    <select name="topTrending" id="topTrending" class="selectpicker" data-style="btn-success btn-custom">
                                        <option value="">Select Top Trending Action</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span role="alert" id="topTrendingErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="hotDeals">Hot Deals<span class="text-danger">*</span></label>
                                    <select name="hotDeals" id="hotDeals" class="selectpicker" data-style="btn-success btn-custom">
                                        <option value="">Select Hot Deals Action</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span role="alert" id="hotDealsErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" id="updateDisplayProductBtn"  class="btn updateBtn waves-effect waves-light"><i class=""></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .display{
        display: flex;
        flex-direction: column;
    }
    .display .common{
        display: flex;
        flex-direction: row;
        margin: 5px 0;
    }
    .display .common span{
        display: block;
    }
    .display .common span:last-child{
        margin-left: 5px;
    }
</style>

@endsection
