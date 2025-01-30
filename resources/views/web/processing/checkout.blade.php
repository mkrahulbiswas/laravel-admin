@extends('web.layouts.app')
@section('content')
    <div class="py-4 border-bottom breadcrumb-main" style="background-image: url('{{ $data['bannerPic'] }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('web.show.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section-padding">
        <div class="container" style="min-width: 100%; padding: 0 30px;">
            <div class="checkoutMain">
                <div class="checkoutSub">
                    <div class="checkoutItems">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Gst</th>
                                    <th>Quantity</th>
                                    <th>Final Amount</th>
                                    @if($data['payMode'] != '' && $data['payMode'] == config('constants.payMode')['cod'])
                                    <th>Is available</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['product'] as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item['image'] }}" alt="" width="50px">
                                    </td>
                                    <td>
                                        <span title="{{ $item['name'] }}">{{ $item['nameShort'] }}</span>
                                    </td>
                                    <td>{{ $item['price'] }}</td>
                                    <td>{{ $item['discount'] }}{{ $item['priceAfterDiscount'] }}</td>
                                    <td>{{ $item['gst'] }}{{ $item['priceAfterGst'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ ($item['price'] + $item['priceAfterDiscount'] + $item['priceAfterGst']) }}</td>
                                    @if($data['payMode'] != '' && $data['payMode'] == config('constants.payMode')['cod'])
                                    @if($item['payMode'] == config('constants.payMode')['cod'])
                                    <td>{{ config('constants.payMode')['cod'] }} is available</td>
                                    @else
                                    <td>{{ config('constants.payMode')['cod'] }} is not available</td>
                                    @endif
                                    @endif
                                    <td>
                                        <a href="{{ route('web.delete.toCart', $item['cartId']) }}" class="link-dark">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="checkoutOther">
                        <div class="checkoutPayMode" data-action="{{ route('web.show.checkout') }}">
                            <span>Payment mode</span>
                            <span>
                                <label for="">Online</label>
                                <input type="radio" name="payMode" class="payMode" data-formSubmitFrom="payMode" {{ ($data['payMode'] == config('constants.payMode')['online']) ? 'checked' : '' }} value="{{ config('constants.payMode')['online'] }}">
                            </span>
                            <span>
                                <label for="">COD</label>
                                <input type="radio" name="payMode" class="payMode" data-formSubmitFrom="payMode" {{ ($data['payMode'] == config('constants.payMode')['cod']) ? 'checked' : '' }} value="{{ config('constants.payMode')['cod'] }}">
                            </span>
                        </div>
                        <div class="checkoutUserAddress">
                            <div class="userAddressTitle">
                                <span>Delivered to the bellow address</span>
                                <span id="changeAddress">
                                    <a href="{{ route('web.show.dashboard') }}">Change</a>
                                </span>
                            </div>
                            <div class="userAddress">
                                <div class="address">{{ $data['userAddress']['address'] }}</div>
                                <div class="landmark">{{ $data['userAddress']['landmark'] }}</div>
                                <div class="city">{{ $data['userAddress']['city'] }}</div>
                                <div class="state">{{ $data['userAddress']['state'] }}</div>
                                <div class="country">{{ $data['userAddress']['country'] }}</div>
                                <div class="pinCode">{{ $data['userAddress']['pinCode'] }}</div>
                                <div class="contactNumber">{{ $data['userAddress']['contactNumber'] }}</div>
                            </div>
                        </div>
                        <div class="checkoutMakeOrder">
                            @if($data['payMode'] != '')
                            @if($data['payMode'] == config('constants.payMode')['cod'])
                            <button type="button" class="btn btn-primary makeOrder" data-formSubmitFrom="makeOrder" data-action="{{ route('web.save.order') }}">Make Order</button>
                            @else
                            <button type="button" class="btn btn-primary makePayment">Make Payment</button>
                            @endif
                            @endif
                        </div>
                    </div>
                    <form action="" method="post" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="payMode" id="payMode" class="payMode" value="{{ $data['payMode'] }}">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection