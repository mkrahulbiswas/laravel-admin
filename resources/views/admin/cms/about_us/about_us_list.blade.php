@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">About Us</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CMS</a></li>
            <li class="breadcrumb-item active">About Us</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            
            <form action="{{ route('admin.update.aboutUs') }}" id="updateAboutUsForm" method="POST" enctype="multipart/form-data">
                
                @csrf

                <input type="hidden" name="id" value="{{  $data['id']  }}">

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="title">Title<span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{{ $data['title'] }}">
                        <span role="alert" id="titleErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="file"><strong>Note:&nbsp;</strong> Image Size should be 1MB to 2MB<span class="text-danger">*</span></label>
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
                                <img src="{{ $data['image'] }}" class="img-responsive img-thumbnail" style="height: 240px">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-8">
                        <label for="content">Content<span class="text-danger">*</span></label>
                        <textarea type="text" name="content" id="content" cols="5" rows="5" class="summernote-one form-control">{{ $data['content'] }}</textarea>
                        <span role="alert" id="contentErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>
                
                @if($itemPermission['edit_item']=='1')
                <div class="form-group text-right m-b-0 m-t-30">
                    <button class="btn saveBtn waves-effect waves-light" id="updateAboutUsBtn" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                </div>
                @endif

            </form>

        </div>
    </div>
</div>


@endsection
