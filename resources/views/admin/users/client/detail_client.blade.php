@extends('admin.layouts.app')
@section('content')
        

<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="#" onClick="javascript:window.close('','_parent','');" class="btn closeBtn waves-effect waves-light m-l-15"><i class="ti-close"></i> Close</a>
        </div>
        <h4 class="page-title">Client Details</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="JavaScript:void(0);">Users</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.show.client') }}">Client List</a></li>
            <li class="breadcrumb-item active">Client Details</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            

            <div class="row">
                <div class="col-lg-12 m-b-20">
                    <div id="accordion">
                        
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h6 class="m-0">
                                    <a href="#collapseOne" class="collapsed text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">Profile Information</a>
                                </h6>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <lable class="font-weight-bold">Image: &nbsp;&nbsp;</lable>
                                                        <img src="{{ $data['image'] }}" class="img-fluid" height="100px" width="100px">
                                                    </div>
                                                </div>
        
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Name: &nbsp;&nbsp;</lable>{{ ucwords($data['name']) }}
                                                            </div>
                                                        </div>
                
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Phone: &nbsp;&nbsp;</lable>
                                                                <a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a>
                                                            </div>
                                                        </div>
                
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <lable class="font-weight-bold">Email: &nbsp;&nbsp;</lable>
                                                                <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <lable class="font-weight-bold">Address: &nbsp;&nbsp;</lable>{{ $data['address'] }}
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <lable class="font-weight-bold">Business Name: &nbsp;&nbsp;</lable>{{ $data['businessName'] }}
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <lable class="font-weight-bold">Business Email: &nbsp;&nbsp;</lable>{{ $data['businessEmail'] }}
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <lable class="font-weight-bold">Business Address: &nbsp;&nbsp;</lable>{{ $data['businessAddress'] }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        @include('admin.users.common')

                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h6 class="m-0">
                                    <a href="#collapseThree" class="collapsed text-dark" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">Payment Information</a>
                                </h6>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        @foreach ($data['salesEntry'] as $itemOne)
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="card m-b-20 text-white bg-success text-xs-center">
                                                <div class="card-body">
                                                    <blockquote class="card-bodyquote">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="font-weight-bold">Total Sale Amount: &nbsp;&nbsp;</lable>{{ number_format($itemOne['totalSale'], 2) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="font-weight-bold">Amount Paid By Client: &nbsp;&nbsp;</lable>{{ number_format($itemOne['clientPay'], 2) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="font-weight-bold">Remaining Amount To Be Paid: &nbsp;&nbsp;</lable>{{ number_format((($itemOne['totalSale'] - $itemOne['clientPay']) - $itemOne['clientNeverPay']), 2) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="font-weight-bold">Amount Client Never Paid: &nbsp;&nbsp;</lable>{{ number_format($itemOne['clientNeverPay'], 2) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                            </div>
                                                            <table class="responsive-datatable-custom tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="background-color: white;">
                                                                <thead>
                                                                    <tr>
                                                                        <td>Amount</td>
                                                                        <td>Settlement</td>
                                                                        <td>Date</td>
                                                                    </tr>
                                                                </thead>
                                                
                                                                <tbody>
                                                                    @foreach ($itemOne['payment'] as $itemTwo)
                                                                        <tr>
                                                                            <td>{{ number_format($itemTwo['amount'], 2) }}</td>
                                                                            <td>{!! $itemTwo['settlement'] !!}</td>
                                                                            <td>{{ $itemTwo['date'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>


@endsection
