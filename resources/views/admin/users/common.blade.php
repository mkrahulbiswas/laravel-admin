<div class="card">
    <div class="card-header" id="headingTwo">
        <h6 class="m-0">
            <a href="#collapseTwo" class="collapsed text-dark" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">Credits Information</a>
        </h6>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
            
            <div class="row">
                @foreach ($data['credits'] as $itemOne)
                <div class="col-sm-4 col-xs-12">
                    <div class="card m-b-20 text-white bg-success text-xs-center">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <lable class="font-weight-bold">Total Credits Amount: &nbsp;&nbsp;</lable>{{ number_format($itemOne['totalCredits'], 2) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <lable class="font-weight-bold">Amount Paid By Client: &nbsp;&nbsp;</lable>{{ number_format($itemOne['clientPay'], 2) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <lable class="font-weight-bold">Remaining Amount To Be Paid: &nbsp;&nbsp;</lable>{{ number_format((($itemOne['totalCredits'] - $itemOne['clientPay']) - $itemOne['clientNeverPay']), 2) }}
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