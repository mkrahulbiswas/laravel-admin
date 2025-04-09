@extends('web.layouts.app')
@section('content')

    <div class="py-4 border-bottom breadcrumb-main" style="background-image: url('{{ $data['bannerPic'] }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('web.show.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <section class="section-padding">
        <div class="container">

            <div class="border p-3">
                {!! $data['googleMap'] !!}
            </div>

            <div class="separator my-3"></div>

            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="p-4 border">
                        <form action="{{ route('web.save.contactUs') }}" method="POST" id="contact_send_form">
                            @csrf
                            <div class="form-body">
                                <h4 class="mb-0 fw-bold">Drop Us a Line</h4>
                                <div class="my-3 border-bottom"></div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Enter Your Name</label>
                                        <input type="text" name="name" id="contact_form_name" placeholder="E.g. John Example" class="form-control rounded-0">
                                        <span class="validationError" id="contact_form_name_err"></span>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Enter Email</label>
                                        <input type="text" name="email" id="contact_form_email" placeholder="E.g. john@example.com" class="form-control rounded-0">
                                        <span class="validationError" id="contact_form_email_err"></span>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone" id="contact_form_phone" placeholder="E.g: 0000000000" class="form-control rounded-0">
                                        <span class="validationError" id="contact_form_phone_err"></span>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control rounded-0" name="message" id="contact_form_message" placeholder="You message...." rows="4" cols="4"></textarea>
                                        <span class="validationError" id="contact_form_message_err"></span>
                                    </div>
                                    <div class="mb-0 col-md-12">
                                        <button type="button" id="contact_send_btn" class="btn btn-dark btn-ecomm">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="p-3 border">
                        <h4 class="mb-0 fw-bold">How you contact us</h4>
                        <div class="my-3 border-bottom"></div>
                        <div class="address mb-3">
                            <h5 class="mb-0 fw-bold">Address</h5>
                            <p class="mb-0 font-12">{{ $data['address'] }}</p>
                        </div>
                        <hr>
                        <div class="phone mb-3">
                            <h5 class="mb-0 fw-bold">Phone</h5>
                            <p class="mb-0 font-13">Mobile : {{ $data['phone'] }}</p>
                        </div>
                        <hr>
                        <div class="email mb-3">
                            <h5 class="mb-0 fw-bold">Email</h5>
                            <p class="mb-0 font-13">{{ $data['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    
@endsection