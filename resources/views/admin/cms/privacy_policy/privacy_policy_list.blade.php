@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Privacy Policy</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CMS</a></li>
            <li class="breadcrumb-item active">Privacy Policy</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            
            <form action="{{ route('admin.update.privacyPolicy') }}" method="POST" enctype="multipart/form-data">
                
                @csrf

                <input type="hidden" name="id" value="{{  $data['id']  }}">

                <h4>Privacy Policy</h4>
                <div class="form-group m-t-40">
                    <textarea type="text" name="privacyPolicy" class="summernote form-control">{{ $data['privacyPolicy'] }}</textarea>
                    @if ($errors->has('privacyPolicy'))
                        <span style="color: red">{{ $errors->first('privacyPolicy') }}</span>
                    @endif
                </div>
                
                @if($itemPermission['edit_item']=='1')
                <div class="form-group text-right m-b-0 m-t-30">
                    <button class="btn saveBtn waves-effect waves-light" type="submit"><i class="ti-save"></i> <span>Update</span></button>
                </div>
                @endif

            </form>

        </div>
    </div>
</div>


@endsection
