<div class="myProfileMain">
    <div class="updateBtn">
        <button type="button" class="btn btn-info">
            <i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;
            <span>Edit profile</span>
        </button>
    </div>
    <div class="profileInfoMain">
        <div class="image">
            <img src="{{ $data['user']['image'] }}" class="img-fluid rounded-top" alt="">
        </div>
        <div class="profileInfo">
            <div class="common">
                <label for="">Name</label>
                <span>{{ $data['user']['name'] }}</span>
            </div>
            <div class="common">
                <label for="">Email</label>
                <span>{{ $data['user']['email'] }}</span>
            </div>
            <div class="common">
                <label for="">Phone</label>
                <span>{{ $data['user']['phone'] }}</span>
            </div>
        </div>
    </div>
</div>
<div class="updateProfileMain" style="display: none;">
    <div class="closeBtn">
        <button type="button" class="btn btn-danger">
            <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;
            <span>Close</span>
        </button>
    </div>
    <div class="updateProfileInfo">
        <form action="{{ route('web.update.profile') }}" method="POST" id="updateProfileForm">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $data['user']['id'] }}">
            <div class="row">
                <div class="mb-3 col-md-12 common">
                    <label for="file"><strong>Note:&nbsp;</strong> Image should be under 1 to 2 MB<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <input type="file" name="file" id="file" class="dropify">
                                </div>
                                <span role="alert" id="fileErr" style="color:red;font-size: 12px"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                            <img src="{{ $data['user']['image'] }}" class="img-responsive img-thumbnail" style="height: 234px">
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-6 common">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="E.g. John Example" class="form-control rounded-0" value="{{ $data['user']['name'] }}">
                    <span class="validationError" id="nameErr"></span>
                </div>
                <div class="mb-3 col-md-6 common">
                    <label class="form-label" for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="E.g: 0000000000" class="form-control rounded-0" value="{{ $data['user']['phone'] }}">
                    <span class="validationError" id="phoneErr"></span>
                </div>
                <div class="mb-3 col-md-12 common">
                    <label class="form-label" for="isPassChange">Want change password&nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox" name="isPassChange" id="isPassChange" value="0">
                    <span class="validationError" id="isPassChangeErr"></span>
                </div>
                <div class="mb-3 col-md-4 common oldPassword" style="display: none;">
                    <label class="form-label" for="oldPassword">Old Password</label>
                    <input type="text" name="oldPassword" id="oldPassword" readonly placeholder="Old Password" class="form-control rounded-0">
                    <span class="validationError" id="oldPasswordErr"></span>
                </div>
                <div class="mb-3 col-md-4 common newPassword" style="display: none;">
                    <label class="form-label" for="newPassword">New Password</label>
                    <input type="text" name="newPassword" id="newPassword" readonly placeholder="New Password" class="form-control rounded-0">
                    <span class="validationError" id="newPasswordErr"></span>
                </div>
                <div class="mb-3 col-md-4 common confirmPassword" style="display: none;">
                    <label class="form-label" for="confirmPassword">Confirm Password</label>
                    <input type="text" name="confirmPassword" id="confirmPassword" readonly placeholder="Confirm Password" class="form-control rounded-0">
                    <span class="validationError" id="confirmPasswordErr"></span>
                </div>
                <div class="mb-0 col-md-12 updateProfileBtn">
                    <button type="submit" id="updateProfileBtn" class="btn btn-primary">
                        <span>Update profile</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>