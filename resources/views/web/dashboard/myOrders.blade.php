<div class="myOrdersMain">
    <div class="userOrdersListMain">
        @foreach ($data['userOrders'] as $tempOne)
        <div class="userOrdersListSub">
            <div class="userOrdersList">
                <div class="one">
                    <div class="left">
                        <span>Order:</span>
                        <span>{{ $tempOne['uniqueId'] }}</span>
                    </div>
                    <div class="right">
                        <span>Date:</span>
                        <span>{{ $tempOne['orderDate'] }}</span>
                    </div>
                </div>
                <div class="two"></div>
            </div>
            <div class="userOrdersProducts">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quatity</th>
                            <th>Final Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tempOne['product'] as $tempTwo)
                        <tr>
                            <td>
                                <img src="{{ $tempTwo['image'] }}" alt="" width="50">
                            </td>
                            <td>
                                <span title="{{ $tempTwo['name'] }}">{{ $tempTwo['nameShort'] }}</span>
                            </td>
                            <td>{{ number_format($tempTwo['priceAfterGst']) }}</td>
                            <td>{{ $tempTwo['quantity'] }}</td>
                            <td>{{ number_format($tempTwo['priceAfterGst'] * $tempTwo['quantity']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div id="con-update-order-modal" data-type="logo" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight: bold; color: black; font-size: 20px;">Add new address</span>
            </div>
            <form action="{{ route('web.save.address') }}" method="POST" id="saveAddressForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-12 common">
                            <label class="form-label" for="address">Address <span>*</span></label>
                            <input type="text" name="address" id="address" placeholder="Address" class="form-control rounded-0">
                            <span class="validationError" id="addressErr"></span>
                        </div>
                        <div class="mb-3 col-md-12 common">
                            <label class="form-label" for="landmark">Land Mark <span>*</span></label>
                            <input type="text" name="landmark" id="landmark" placeholder="Land Mark" class="form-control rounded-0">
                            <span class="validationError" id="landmarkErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="city">City <span>*</span></label>
                            <input type="text" name="city" id="city" placeholder="City" class="form-control rounded-0">
                            <span class="validationError" id="cityErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="state">State <span>*</span></label>
                            <input type="text" name="state" id="state" placeholder="State" class="form-control rounded-0">
                            <span class="validationError" id="stateErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="country">Country <span>*</span></label>
                            <input type="text" name="country" id="country" placeholder="Country" class="form-control rounded-0">
                            <span class="validationError" id="countryErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="pinCode">Pin Code <span>*</span></label>
                            <input type="text" name="pinCode" id="pinCode" placeholder="Pin Code" class="form-control rounded-0">
                            <span class="validationError" id="pinCodeErr"></span>
                        </div>
                        <div class="mb-3 col-md-12 common">
                            <label class="form-label" for="contactNumber">Contact Number <span>*</span></label>
                            <input type="text" name="contactNumber" id="contactNumber" placeholder="Contact Number" class="form-control rounded-0">
                            <span class="validationError" id="contactNumberErr"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close close-modal btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa-solid fa-xmark"></i>
                        <span> Close</span>
                    </button>
                    <button type="submit" id="saveAddressBtn" class="btn btn-primary">
                        <span>Add address</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="con-edit-address-modal" data-type="logo" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight: bold; color: black; font-size: 20px;">Update previous address</span>
            </div>
            <form action="{{ route('web.update.address') }}" method="POST" id="updateAddressForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="mb-3 col-md-12 common">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" name="address" id="address" placeholder="Address" class="form-control rounded-0">
                            <span class="validationError" id="addressErr"></span>
                        </div>
                        <div class="mb-3 col-md-12 common">
                            <label class="form-label" for="landmark">Land Mark</label>
                            <input type="text" name="landmark" id="landmark" placeholder="Land Mark" class="form-control rounded-0">
                            <span class="validationError" id="landmarkErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="city">City</label>
                            <input type="text" name="city" id="city" placeholder="City" class="form-control rounded-0">
                            <span class="validationError" id="cityErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="state">State</label>
                            <input type="text" name="state" id="state" placeholder="State" class="form-control rounded-0">
                            <span class="validationError" id="stateErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="country">Country</label>
                            <input type="text" name="country" id="country" placeholder="Country" class="form-control rounded-0">
                            <span class="validationError" id="countryErr"></span>
                        </div>
                        <div class="mb-3 col-md-6 common">
                            <label class="form-label" for="pinCode">Pin Code</label>
                            <input type="text" name="pinCode" id="pinCode" placeholder="Pin Code" class="form-control rounded-0">
                            <span class="validationError" id="pinCodeErr"></span>
                        </div>
                        <div class="mb-3 col-md-12 common">
                            <label class="form-label" for="contactNumber">Contact Number</label>
                            <input type="text" name="contactNumber" id="contactNumber" placeholder="Contact Number" class="form-control rounded-0">
                            <span class="validationError" id="contactNumberErr"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close close-modal btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa-solid fa-xmark"></i>
                        <span> Close</span>
                    </button>
                    <button type="submit" id="updateAddressBtn" class="btn btn-primary">
                        <span>Update address</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>