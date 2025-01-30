@extends('web.layouts.app')
@section('content')
    <div class="py-4 border-bottom breadcrumb-main" style="background-image: url('{{ $data['bannerPic'] }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('web.show.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-xl-6">
                    <h3 class="fw-bold">Know about us</h3>
                    {!! $data['content'] !!}
                </div>
                <div class="col-12 col-xl-6">
                    <img src="{{ $data['image'] }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection