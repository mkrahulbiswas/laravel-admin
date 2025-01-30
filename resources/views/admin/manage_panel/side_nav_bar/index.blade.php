@extends('admin.layouts.app')
@section('content')


<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Show Nav Bar</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Setup Admin</a></li>
            <li class="breadcrumb-item active">Show Nav Bar</li>
        </ol>
    </div>
</div>

<div class="row">
    <p class="text-muted font-14 m-b-30">
        <div class="alert alert-danger" id="alert" style="display: none">
            <center><strong id="validationAlert" style="font-size: 14px; font-weight: 500"></strong></center>
        </div>
    </p>
    <div class="col-lg-12 m-b-20">
        <ul class="nav nav-pills mb-3 Appearance">
            <li class="nav-item tab">
                <a href="#tabOne" data-toggle="tab" aria-expanded="true" class="nav-link">Main Menu</a>
            </li>
            <li class="nav-item tab">
                <a href="#tabTwo" data-toggle="tab" aria-expanded="false" class="nav-link show">Sub Menu</a>
            </li>
            <li class="nav-item tab">
                <a href="#tabThree" data-toggle="tab" aria-expanded="false" class="nav-link active show">Arrange Order</a>
            </li>
        </ul>
        
        <div class="tab-content" style="padding: 0;">

            <div class="tab-pane" id="tabOne">
                <div class="col-sm-12" style="padding: 0; background: linear-gradient(180deg, transparent, #0797dd );">
                    <ol class="breadcrumb" style="padding: 25px 0 2px 20px; margin-bottom: 0;">
                        <li class="breadcrumb-item">Setup Admin</li>
                        <li class="breadcrumb-item">Nav Bar</li>
                        <li class="breadcrumb-item active">Main Menu</li>
                    </ol>
                </div>
                @include('admin.setup_admin.side_nav_bar.main_menu.list')
            </div>
            

            <div class="tab-pane" id="tabTwo">
                <div class="col-sm-12" style="padding: 0; background: linear-gradient(180deg, transparent, #0797dd );">
                    <ol class="breadcrumb" style="padding: 25px 0 2px 20px; margin-bottom: 0;">
                        <li class="breadcrumb-item">Setup Admin</li>
                        <li class="breadcrumb-item">Nav Bar</li>
                        <li class="breadcrumb-item active">Sub Menu</li>
                    </ol>
                </div>
                @include('admin.setup_admin.side_nav_bar.sub_menu.list', ['mainMenu' => $data['mainMenu']])
            </div>
            

            <div class="tab-pane active" id="tabThree">
                <div class="col-sm-12" style="padding: 0; background: linear-gradient(180deg, transparent, #0797dd );">
                    <ol class="breadcrumb" style="padding: 25px 0 2px 20px; margin-bottom: 0;">
                        <li class="breadcrumb-item">Setup Admin</li>
                        <li class="breadcrumb-item">Nav Bar</li>
                        <li class="breadcrumb-item active">Arrange Order</li>
                    </ol>
                </div>
                @include('admin.setup_admin.side_nav_bar.arrange_order.list', ['sideNavBar' => $data['sideNavBar']])
            </div>
            


        </div>

    </div>
</div>
{{-- @include('admin.setup_admin.side_nav_bar.arrange_order.list', ['sideNavBar' => $data['sideNavBar']]) --}}


@endsection               