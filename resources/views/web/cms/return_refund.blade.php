@extends('web.layouts.app')
@section('content')
    <div class="py-4 border-bottom breadcrumb-main" style="background-image: url('{{ $data['bannerPic'] }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('web.show.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Return & Refund Policy</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section-padding return-refund">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="common">
                        <h3 class="fw-bold">Return Policy</h3>
                        {!! $data['return'] !!}
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <hr>
                </div> --}}
                <div class="col-md-6">
                    <div class="common">
                        <h3 class="fw-bold">Refund Policy</h3>
                        {!! $data['refund'] !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <br>
                </div>
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        @foreach ($data['faq'] as $key=>$item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="lol-{{ $key }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#loll-{{ $key }}" aria-expanded="{{ ($key == 0) ? 'true' : 'false' }}" aria-controls="loll-{{ $key }}">{!! $item['question'] !!}</button>
                            </h2>
                            <div id="loll-{{ $key }}" class="accordion-collapse collapse {{ ($key == 0) ? 'show' : '' }}" aria-labelledby="lol-{{ $key }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">{!! $item['answer'] !!}</div>
                            </div>
                        </div>
                        {{-- <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Accordion Item #2</button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    aa
                                </div>
                            </div>
                        </div> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
