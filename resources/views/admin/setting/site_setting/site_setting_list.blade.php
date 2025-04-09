@extends('admin.layouts.app')
@section('content')

<!-- Page-Title -->
<div class="row mbliviwbrd">
    <div class="col-sm-12">
        <h4 class="page-title">Site Setting</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setting</a></li>
            <li class="breadcrumb-item active">Site Setting</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            
            <form action="{{ route('admin.update.siteSetting') }}" method="POST" id="updateSiteSettingForm" enctype="multipart/form-data">
                
                @csrf

                <input type="hidden" name="id" value="{{  $data['id']  }}">

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="copyRight">Footer Copyright Text<span class="text-danger">*</span></label>
                        <textarea type="text" name="copyRight" class="summernote-mini form-control" placeholder="Meta Description">{{ $data['footer']['copyRight'] }}</textarea>
                        <span role="alert" id="copyRightErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="phone">Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="phone" class="form-control" value="{{ $data['contact']['phone'] }}">
                        <span role="alert" id="phoneErr" style="color:red;font-size: 12px"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" placeholder="email" class="form-control" value="{{ $data['contact']['email'] }}">
                        <span role="alert" id="emailErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="metaTag">Site Meta Tag<span class="text-danger">*</span></label>
                        <input type="text" name="metaTag" id="metaTag" placeholder="Meta Tag" class="form-control" value="{{ $data['metaData']['metaTag'] }}">
                        <span role="alert" id="metaTagErr" style="color:red;font-size: 12px"></span>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="metaTitle">Site Meta Title<span class="text-danger">*</span></label>
                        <input type="text" name="metaTitle" id="metaTitle" placeholder="Meta Title" class="form-control" value="{{ $data['metaData']['metaTitle'] }}">
                        <span role="alert" id="metaTitleErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-12">
                        <label for="metaKeyword">Site Meta Keyword<span class="text-danger">*</span></label>
                        <input type="text" name="metaKeyword" id="metaKeyword" placeholder="Meta Keyword" class="form-control" value="{{ $data['metaData']['metaKeyword'] }}">
                        <span role="alert" id="metaKeywordErr" style="color:red;font-size: 12px"></span>
                    </div>
    
                    <div class="form-group col-md-12">
                        <label for="metaDescription">Site Meta Description<span class="text-danger">*</span></label>
                        <textarea type="text" name="metaDescription" class="form-control" placeholder="Meta Description">{{ $data['metaData']['metaDescription'] }}</textarea>
                        <span role="alert" id="metaDescriptionErr" style="color:red;font-size: 12px"></span>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="bigLogo"><strong>Note:&nbsp;</strong> Big Logo<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" name="bigLogo" id="bigLogo" class="dropify">
                                    </div>
                                    <span role="alert" id="bigLogoErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin stretch-card">
                                <img src="{{ $data['logo']['bigLogo'] }}" class="bigLogo img-responsive img-thumbnail">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="smallLogo"><strong>Note:&nbsp;</strong> Small Logo<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" name="smallLogo" id="smallLogo" class="dropify">
                                    </div>
                                    <span role="alert" id="smallLogoErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin stretch-card">
                                <img src="{{ $data['logo']['smallLogo'] }}" class="smallLogo img-responsive img-thumbnail">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="favIcon"><strong>Note:&nbsp;</strong> Fav Icon<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" name="favIcon" id="favIcon" class="dropify">
                                    </div>
                                    <span role="alert" id="favIconErr" style="color:red;font-size: 12px"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin stretch-card">
                                <img src="{{ $data['logo']['favIcon'] }}" class="favIcon img-responsive img-thumbnail">
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(MenuHelper::isUpdate())
                <div class="form-group text-right m-b-0 m-t-30">
                    <button class="btn saveBtn waves-effect waves-light" type="submit" id="updateSiteSettingBtn"><i class="ti-save"></i> <span>Update</span></button>
                </div>
                @endif

            </form>

        </div>
    </div>
</div>


@endsection
