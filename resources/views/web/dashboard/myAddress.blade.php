<div class="myAddressMain">
    <div class="addAddressBtn">
        <button type="button" class="btn btn-info">
            <i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;
            <span>Add new address</span>
        </button>
    </div>
    <div class="userAddressListMain">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Address & Landmard</th>
                    <th>Other Info</th>
                    <th>Contact</th>
                    <th>Is Default</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['userAddress'] as $temp)
                <tr>
                    <td>
                        <div class="fullAddress">
                            <div class="one common">
                                <label for="">Address:</label>
                                <span>{{ $temp['address'] }}</span>
                            </div>
                            <div class="two common">
                                <label for="">Landmark:</label>
                                <span>{{ $temp['landmark'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="otherInfo">
                            <div class="one common">
                                <label for="">City:</label>
                                <span>{{ $temp['city'] }}</span>
                            </div>
                            <div class="two common">
                                <label for="">State:</label>
                                <span>{{ $temp['state'] }}</span>
                            </div>
                            <div class="Three common">
                                <label for="">Country:</label>
                                <span>{{ $temp['country'] }}</span>
                            </div>
                            <div class="Four common">
                                <label for="">PinCode:</label>
                                <span>{{ $temp['pinCode'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $temp['contactNumber'] }}</td>
                    <td>
                        @if ($temp['isDefault'] == '1')
                            <span class="isActive">Yes</span>
                        @else
                            <span class="isNotActive">No</span>
                        @endif
                    </td>
                    <td>
                        <div class="actionBtn">
                            <a href="JavaScript:void(0);" data-type="isDefault" data-action="{{ route('web.isDefault.address', $temp['id']) }}" class="actionDatatable" title="Is Default">
                                <i class="fa-solid fa-lock" style="font-size: 20px; color: #2bbbad;"></i>
                                {{-- <i class="fa-solid fa-lock"></i> --}}
                                {{-- <i class="fa-solid fa-lock-open"></i> --}}
                            </a>
                            <a href="JavaScript:void(0);" data-type="edit" title="Edit" data-array="{{ json_encode($temp, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}" class="actionDatatable">
                                <i class="fa-solid fa-pen-to-square" style="font-size: 20px;"></i>
                            </a>
                            <a href="JavaScript:void(0);" data-action="{{ route('web.delete.address', $temp['id']) }}" data-type="delete" class="actionDatatable" title="Delete">
                                <i class="fa-solid fa-trash" style="font-size: 20px; color: red;"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="con-add-address-modal" data-type="logo" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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