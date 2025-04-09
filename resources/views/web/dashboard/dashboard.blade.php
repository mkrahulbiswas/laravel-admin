@extends('web.layouts.app')
@section('content')
<div class="py-4 border-bottom breadcrumb-main" style="background-image: url('{{ $data['bannerPic'] }}');">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('web.show.home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-padding dashboardCustom" style="background: radial-gradient(white, #e8e8e8);">
    <div class="container">
        <div class="dashboardMain">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-my-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-my-profile" type="button" role="tab" aria-controls="pills-my-profile" aria-selected="true">My profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-my-address-tab" data-bs-toggle="pill" data-bs-target="#pills-my-address" type="button" role="tab" aria-controls="pills-my-address" aria-selected="false">My addresses</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-my-orders-tab" data-bs-toggle="pill" data-bs-target="#pills-my-orders" type="button" role="tab" aria-controls="pills-my-orders" aria-selected="false">My Orders</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active userProfileMain" id="pills-my-profile" role="tabpanel" aria-labelledby="pills-my-profile-tab">
                    @include('web.dashboard.myProfile', ['data' => $data])
                </div>
                <div class="tab-pane fade userAddressMain" id="pills-my-address" role="tabpanel" aria-labelledby="pills-my-address-tab">
                    @include('web.dashboard.myAddress', ['data' => $data])
                </div>
                <div class="tab-pane fade userOrdersMain" id="pills-my-orders" role="tabpanel" aria-labelledby="pills-my-orders-tab">
                    @include('web.dashboard.myOrders', ['data' => $data])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
