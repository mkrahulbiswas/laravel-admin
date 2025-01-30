@extends('web.layouts.app')
@section('content')
    <div class="py-4 border-bottom breadcrumb-main" style="background-image: url('{{ $data['bannerPic'] }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('web.show.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section-padding">
        <div class="container" style="min-width: 100%; padding: 0 30px;">
            <div class="mk-product-page" id="mk-product-page" data-action="{{ route('web.show.product') }}">
                @csrf
                <div class="mk-category-main">
                    <div class="mk-category">
                        <div class="mk-one">
                            <select class="form-control advance-select-category" id="category-dropdown">
                                <option value="">Select one category</option>
                                @foreach ($data['category'] as $item)
                                    <option data-array="{{ json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mk-two">
                            <input type="text" class="form-control" id="input-search-box" placeholder="Search product by product name.....">
                        </div>
                    </div>
                </div>
                <div class="mk-products">
                    <div class="tab-content tabular-product tabular-product-custom">
                        <div class="tab-pane fade show active">
                            <div class="row mk-products-list-append">
                                @if(sizeof($data['product']) <= 0)
                                <div class="card card-custom">
                                    <div class="card-body">
                                        <span>No product found, please check another categoty.</span>
                                        <div class="image">
                                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/sorry-item-not-found-3328225-2809510.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                @else
                                @foreach ($data['product'] as $key => $item)
                                <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mk-products-item">
                                    <div class="card product-details-click" data-array="{{ json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}">
                                        <div class="position-relative overflow-hidden">
                                            <div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                                <a href="javascript:void(0)">
                                                    <i class="bi bi-heart"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="bi bi-basket3"></i>
                                                </a>
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#QuickViewModal">
                                                    <i class="bi bi-zoom-in"></i>
                                                </a>
                                            </div>
                                            <a href="javascript:void(0)">
                                                <img src="{{ $item['image'] }}" class="card-img-top" alt="...">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="product-info text-center">
                                                <h6 class="mb-1 fw-bold product-name">{{ $item['nameShort'] }}</h6>
                                                <p class="mb-0 h6 fw-bold product-price" style="font-size: 12px;">
                                                    <span style="color: gray"> ₹<strike>{{ $item['price'] }}</strike> </span>&nbsp;&nbsp;
                                                    <span style="color: black">₹{{ $item['priceAfterDiscount'] }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection