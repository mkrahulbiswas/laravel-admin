$(function () {
    "use strict";

    $(document).ready(function () {
        $('.product-thumbs').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            prevArrow: "<button type='button' class='slick-prev pull-left'><i class='bi bi-chevron-left'></i></button>",
            nextArrow: "<button type='button' class='slick-next pull-right'><i class='bi bi-chevron-right'></i></button>",
            responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                }
            ]
        });
    });


    $(document).ready(function () {
        $('.cartegory-box').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            prevArrow: "<button type='button' class='slick-prev pull-left'><i class='bi bi-chevron-left'></i></button>",
            nextArrow: "<button type='button' class='slick-next pull-right'><i class='bi bi-chevron-right'></i></button>",
            responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                }
            ]
        });


    });
});

(function ($) {
    'use strict';
    $('.dropify').dropify();
})(jQuery);


$(document).ready(function () {
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        fade: true,
        centerMode: false,
        focusOnSelect: true,
        asNavFor: '.slider-nav',
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='bi bi-chevron-left'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='bi bi-chevron-right'></i></button>",
    })

    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        arrows: false,
        centerMode: false,
        focusOnSelect: true,
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='bi bi-chevron-left'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='bi bi-chevron-right'></i></button>",
    })
});

$('.modal').on('shown.bs.modal', function (e) {
    $('.slider-for').slick('setPosition');
    $('.slider-nav').slick('setPosition');
    $('.wrap-modal-slider').addClass('open');
})


$(document).ready(function () {
    let loginRegisterModal = $('.con-loginRegister-modal'),
        productModal = $('#con-product-modal');

    /*--- Contact Enquiry ---*/
    $('#contact_send_btn').click(function () {
        let actionBtn = $(this);
        $.ajax({
            url: actionBtn.closest('form').attr('action'),
            type: actionBtn.closest('form').attr('method'),
            data: {
                "_token": actionBtn.closest('form').find('[name="_token"]').val(),
                "name": actionBtn.closest('form').find('#contact_form_name').val(),
                "email": actionBtn.closest('form').find('#contact_form_email').val(),
                "phone": actionBtn.closest('form').find('#contact_form_phone').val(),
                "message": actionBtn.closest('form').find('#contact_form_message').val(),
            },
            beforeSend: function () {
                actionBtn.attr("disabled", "disabled").find('span').text('please wait...');
            },
            success: function (msg) {
                actionBtn.attr("disabled", false).find('span').text('send message');
                actionBtn.closest('form').find("#contact_form_name_err, #contact_form_email_err, #contact_form_phone_err, #contact_form_message_err").text('');
                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.name, function (i) {
                        actionBtn.closest('form').find("#contact_form_name_err").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.email, function (i) {
                        actionBtn.closest('form').find("#contact_form_email_err").text(msg.errors.email[i]);
                    });
                    $.each(msg.errors.phone, function (i) {
                        actionBtn.closest('form').find("#contact_form_phone_err").text(msg.errors.phone[i]);
                    });
                    $.each(msg.errors.message, function (i) {
                        actionBtn.closest('form').find("#contact_form_message_err").text(msg.errors.message[i]);
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    actionBtn.closest('form')[0].reset();
                }
            }
        });
    })



    /*--- Product ---*/
    $('.advance-select-category').select2({
        tags: false,
        placeholder: "Select Font Style"
    });

    $('#mk-product-page #input-search-box, #mk-product-page #category-dropdown').on('keyup change', function () {
        let actionBtn = $(this),
            closestClass = $(this).closest('#mk-product-page'),
            dataArray = (closestClass.find('#category-dropdown').find('option:selected').val() == '') ? {
                id: ''
            } : JSON.parse(closestClass.find('#category-dropdown').find('option:selected').attr('data-array')),
            html = '';

        $.ajax({
            url: closestClass.attr('data-action'),
            type: 'post',
            data: {
                "_token": closestClass.find('[name="_token"]').val(),
                "text": (closestClass.find('#input-search-box').val() == '') ? '' : closestClass.find('#input-search-box').val(),
                "id": dataArray.id,
            },
            beforeSend: function () {
                // actionBtn.attr("disabled", "disabled").find('span').text('please wait...');
            },
            success: function (msg) {
                // actionBtn.attr("disabled", false).find('span').text('send message');
                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else if (msg.status == 1) {
                    let productList = msg.data.product;
                    html = '';
                    closestClass.find('.mk-products-list-append').html(html);

                    if (productList.length > 0) {
                        productList.forEach(element => {
                            html += '<div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mk-products-item">';
                            html += '<div class="card product-details-click" data-array="' + encodeURIComponent(JSON.stringify(element)) + '">';
                            html += '<div class="position-relative overflow-hidden">';
                            html += '<div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">';
                            html += '<a href="javascript:void(0)">';
                            html += '<i class="bi bi-heart"></i>';
                            html += '</a>';
                            html += '<a href="javascript:void(0)">';
                            html += '<i class="bi bi-basket3"></i>';
                            html += '</a>';
                            html += '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#QuickViewModal">';
                            html += '<i class="bi bi-zoom-in"></i>';
                            html += '</a>';
                            html += '</div>';
                            html += '<a href="javascript:void(0)">';
                            html += '<img src="' + element.image + '" class="card-img-top" alt="...">';
                            html += '</a>';
                            html += '</div>';
                            html += '<div class="card-body">';
                            html += '<div class="product-info text-center">';
                            html += '<h6 class="mb-1 fw-bold product-name">' + element.nameShort + '</h6>';
                            html += '<p class="mb-0 h6 fw-bold product-price" style="font-size: 12px;">';
                            html += '<span style="color: gray"> ₹<strike>' + element.price + '</strike> </span>&nbsp;&nbsp;';
                            html += '<span style="color: black">₹' + element.priceAfterGst + '</span>';
                            html += '</p>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        });
                    } else {
                        html += '<div class="card card-custom">';
                        html += '<div class="card-body">';
                        html += '<span>No product found, please check another categoty.</span>';
                        html += '<div class="image">';
                        html += '<img src="https://cdni.iconscout.com/illustration/premium/thumb/sorry-item-not-found-3328225-2809510.png" alt="">';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    }
                    closestClass.find('.mk-products-list-append').html(html);
                }
            }
        });
    })

    $('body').delegate('.product-details-click', 'click', function () {
        productModal.modal('show');
        let dataArray = JSON.parse(decodeURIComponent($(this).attr('data-array')));

        productModal.find('#image').attr('src', dataArray.image);
        productModal.find('#name').html(dataArray.name);
        productModal.find('#price').html('₹' + dataArray.price.toFixed(2));
        productModal.find('#priceAfterDiscount').html('₹' + dataArray.priceAfterGst.toFixed(2));
        productModal.find('#category').html(dataArray.category);
        productModal.find('#quantity').html(dataArray.quantity);
        productModal.find('#units').html(dataArray.units);
        productModal.find('#description').html(dataArray.description);
        productModal.find('#id').val(dataArray.id);

        let payMode = '';
        if (dataArray.payMode == 'COD') {
            payMode = 'This product is available only for cash on delivery';
        } else {
            payMode = 'This product is available only for online delivery';
        }
        productModal.find('#payMode').html(payMode);
    });

    /*--- Add To Cart ---*/
    let addToCart = $('#addToCart');
    addToCart.find('.common').click(function () {
        let quantity = addToCart.find('.quantity input').val();
        if ($(this).attr('data-type') == 'plus') {
            if (quantity >= 10) {
                Swal.fire({
                    position: 'center-center',
                    icon: 'warning',
                    title: 'Limit exceeded',
                    text: 'You cannot chose more than 10 quantities.',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                quantity++;
            }
        } else {
            if (quantity > 1) {
                quantity--;
            }
        }
        addToCart.find('.quantity span').text(quantity)
        addToCart.find('.quantity input').val(quantity)
    });

    $("#addToCartBtn").click(function (event) {

        submitForm = $(this).closest('form');
        submitBtn = $(this);

        if (submitForm.find('#userId').val() == 1) {
            submitForm.trigger('submit');
        } else {
            Swal.fire({
                position: 'center-center',
                icon: 'warning',
                title: 'Login required',
                text: 'Oops! you need to login first before adding products in cart',
                showConfirmButton: false,
                timer: 3000
            }).then(function () {
                loginRegisterCommon();
                productModal.modal('hide');
                loginRegisterModal.modal('show');
                loginRegisterModal.find('.loginForm').css({
                    'display': 'block'
                });
            });
        }
    });


    /*--- Checkout ---*/
    let checkoutId = $('.checkoutMain');
    checkoutId.find('.payMode, .makeOrder').click(function () {
        if ($(this).attr('data-formSubmitFrom') == 'payMode') {
            checkoutId.find('#payMode').val($(this).val())
            checkoutId.find('#checkoutForm').attr('action', $(this).closest('.checkoutPayMode').attr('data-action'))
        } else {
            checkoutId.find('#checkoutForm').attr('action', $(this).attr('data-action'))
        }
        checkoutId.find('#checkoutForm').trigger('submit')
    })


    /*--- Login Register ---*/
    $('body').delegate('.loginRegister-click', 'click', function () {
        loginRegisterCommon();
        loginRegisterModal.find('.loginForm').css({
            'display': 'block'
        });
        loginRegisterModal.modal('show');
    });

    loginRegisterModal.find('.backToLogin').click(function () {
        loginRegisterCommon();
        loginRegisterModal.find('.loginForm').css({
            'display': 'block'
        });
    });

    loginRegisterModal.find('.backToRegister').click(function () {
        loginRegisterCommon();
        loginRegisterModal.find('.registerForm').css({
            'display': 'block'
        });
    });

    $("#checkLoginForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#checkLoginBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () {
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                submitBtn.attr("disabled", false).find('span').text('Sign in');

                submitForm.find("#emailErr, #passwordErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.email, function (i) {
                        submitForm.find("#emailErr").text(msg.errors.email[i]);
                    });
                    $.each(msg.errors.password, function (i) {
                        submitForm.find("#passwordErr").text(msg.errors.password[i]);
                    });
                } else if (msg.status == 1) {
                    let timerInterval
                    Swal.fire({
                        title: msg.title,
                        position: 'center-center',
                        icon: 'success',
                        html: msg.msg,
                        timer: 2000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                Swal.getContent().querySelector('strong')
                                    .textContent = Swal.getTimerLeft();
                            }, 100);
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload();
                            submitForm[0].reset();
                        }
                    });
                } else if (msg.status == 3) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    loginRegisterCommon();
                    loginRegisterModal.find('.otpForm').css({
                        'display': 'block'
                    });
                    loginRegisterModal.find('#checkOtpForm .my-email').text(msg.data.email);
                    loginRegisterModal.find('#checkOtpForm #id').val(msg.data.id);
                }
            }
        });
    });

    $("#saveRegisterForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveRegisterBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () {
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                submitBtn.attr("disabled", false).find('span').text('Sign up');

                submitForm.find("#nameErr, #phoneErr, #emailErr, #passwordErr, #confirmPasswordErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.phone, function (i) {
                        submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                    });
                    $.each(msg.errors.email, function (i) {
                        submitForm.find("#emailErr").text(msg.errors.email[i]);
                    });
                    $.each(msg.errors.password, function (i) {
                        submitForm.find("#passwordErr").text(msg.errors.password[i]);
                    });
                    $.each(msg.errors.confirmPassword, function (i) {
                        submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]);
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    loginRegisterCommon();
                    loginRegisterModal.find('.otpForm').css({
                        'display': 'block'
                    });
                    loginRegisterModal.find('#checkOtpForm .my-email').text(msg.data.email);
                    loginRegisterModal.find('#checkOtpForm #id').val(msg.data.id);
                }
            }
        });
    });

    $("#checkOtpForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#checkOtpBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () {
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                submitBtn.attr("disabled", false).find('span').text('save');

                submitForm.find("#otpErr, #otpErr, #otpErr, #otpErr, #otpErr, #otpErr, #otpErr").text('');

                console.log(msg)

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.otp, function (i) {
                        submitForm.find("#otpErr").text(msg.errors.otp[i]);
                    });
                } else if (msg.status == 2) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else if (msg.status == 3) {
                    let timerInterval
                    Swal.fire({
                        title: msg.title,
                        position: 'center-center',
                        icon: 'success',
                        html: msg.msg,
                        timer: 2000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                Swal.getContent().querySelector('strong')
                                    .textContent = Swal.getTimerLeft();
                            }, 100);
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload();
                            submitForm[0].reset();
                        }
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    submitForm[0].reset();
                }
            }
        });
    });

    $('#resendOtpBtn').click(function () {
        let actionBtn = $(this);
        $.ajax({
            url: actionBtn.attr('data-action'),
            type: 'POST',
            data: {
                "_token": actionBtn.closest('form').find('[name="_token"]').val(),
                "id": actionBtn.closest('form').find('#id').val(),
            },
            beforeSend: function () {
                actionBtn.attr("disabled", "disabled").find('span').text('please wait...');
            },
            success: function (msg) {
                actionBtn.attr("disabled", false).find('span').text('Resend OTP');
                actionBtn.closest('form').find("#otpErr").text('');
                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.otp, function (i) {
                        actionBtn.closest('form').find("#otpErr").text(msg.errors.otp[i]);
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    actionBtn.closest('form')[0].reset();
                }
            }
        });
    })

    function loginRegisterCommon() {
        loginRegisterModal.find('.loginForm')[0].reset();
        loginRegisterModal.find('.registerForm')[0].reset();
        loginRegisterModal.find('.otpForm')[0].reset();
        loginRegisterModal.find('.loginForm, .registerForm, .otpForm').css({
            'display': 'none'
        });
    }


    /*---- (Update Profile) ----*/
    $('#updateProfileForm #isPassChange').click(function () {
        if ($(this).is(':checked')) {
            $(this).closest('form')
                .find('.oldPassword, .newPassword, .confirmPassword')
                .show()
                .children('#oldPassword, #newPassword, #confirmPassword')
                .attr('readonly', false)
                .val('');
            $(this).val(1)
        } else {
            $(this).closest('form')
                .find('.oldPassword, .newPassword, .confirmPassword')
                .hide()
                .children('#oldPassword, #newPassword, #confirmPassword')
                .attr('readonly', false)
                .val('');
            $(this).val(0)
        }
    })

    $('.userProfileMain .closeBtn').click(function () {
        $('.myProfileMain').show();
        $('.updateProfileMain').hide();
    })

    $('.userProfileMain .updateBtn').click(function () {
        $('.myProfileMain').hide();
        $('.updateProfileMain').show();
    })

    $("#updateProfileForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateProfileBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () {
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                submitBtn.attr("disabled", false).find('span').text('Update profile');

                submitForm.find("#fileErr, #nameErr, #phoneErr, #isPassChangeErr, #oldPasswordErr, #newPasswordErr, #confirmPasswordErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.file, function (i) {
                        submitForm.find("#fileErr").text(msg.errors.file[i]);
                    });
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.phone, function (i) {
                        submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                    });
                    $.each(msg.errors.isPassChange, function (i) {
                        submitForm.find("#isPassChangeErr").text(msg.errors.isPassChange[i]);
                    });
                    $.each(msg.errors.oldPassword, function (i) {
                        submitForm.find("#oldPasswordErr").text(msg.errors.oldPassword[i]);
                    });
                    $.each(msg.errors.newPassword, function (i) {
                        submitForm.find("#newPasswordErr").text(msg.errors.newPassword[i]);
                    });
                    $.each(msg.errors.confirmPassword, function (i) {
                        submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]);
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    submitForm.find('.dropify-clear').trigger('click');
                    window.location.reload();
                }
            }
        });
    });


    /*---- (Update Address) ----*/
    $('.addAddressBtn button').click(function () {
        $('#con-add-address-modal').modal('show');
    })

    $("#saveAddressForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveAddressBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () {
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                submitBtn.attr("disabled", false).find('span').text('Save address');

                submitForm.find("#addressErr, #landmarkErr, #cityErr, #stateErr, #countryErr, #pinCodeErr, #contactNumberErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.address, function (i) {
                        submitForm.find("#addressErr").text(msg.errors.address[i]);
                    });
                    $.each(msg.errors.landmark, function (i) {
                        submitForm.find("#landmarkErr").text(msg.errors.landmark[i]);
                    });
                    $.each(msg.errors.city, function (i) {
                        submitForm.find("#cityErr").text(msg.errors.city[i]);
                    });
                    $.each(msg.errors.state, function (i) {
                        submitForm.find("#stateErr").text(msg.errors.state[i]);
                    });
                    $.each(msg.errors.country, function (i) {
                        submitForm.find("#countryErr").text(msg.errors.country[i]);
                    });
                    $.each(msg.errors.pinCode, function (i) {
                        submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]);
                    });
                    $.each(msg.errors.contactNumber, function (i) {
                        submitForm.find("#contactNumberErr").text(msg.errors.contactNumber[i]);
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    submitForm[0].reset();
                    window.location.reload();
                }
            }
        });
    })

    $("#updateAddressForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateAddressBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function () {
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                submitBtn.attr("disabled", false).find('span').text('Update address');

                submitForm.find("#addressErr, #landmarkErr, #cityErr, #stateErr, #countryErr, #pinCodeErr, #contactNumberErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $.each(msg.errors.address, function (i) {
                        submitForm.find("#addressErr").text(msg.errors.address[i]);
                    });
                    $.each(msg.errors.landmark, function (i) {
                        submitForm.find("#landmarkErr").text(msg.errors.landmark[i]);
                    });
                    $.each(msg.errors.city, function (i) {
                        submitForm.find("#cityErr").text(msg.errors.city[i]);
                    });
                    $.each(msg.errors.state, function (i) {
                        submitForm.find("#stateErr").text(msg.errors.state[i]);
                    });
                    $.each(msg.errors.country, function (i) {
                        submitForm.find("#countryErr").text(msg.errors.country[i]);
                    });
                    $.each(msg.errors.pinCode, function (i) {
                        submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]);
                    });
                    $.each(msg.errors.contactNumber, function (i) {
                        submitForm.find("#contactNumberErr").text(msg.errors.contactNumber[i]);
                    });
                } else if (msg.status == 1) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: msg.title,
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    submitForm[0].reset();
                    window.location.reload();
                }
            }
        });
    })

    $('body').delegate('.userAddressMain .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            res = '',
            action = $(this).attr('data-action'),
            data = '';

        if (type == 'isDefault') {

            res = confirm('Do you really want to make it default?');
            if (res === false) {
                return;
            }

            $.ajax({
                url: action,
                type: 'get',
                dataType: 'json',
                beforeSend: function () {},
                success: function (msg) {
                    if (msg.status == 0) {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'warning',
                            title: msg.title,
                            text: msg.msg,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: msg.title,
                            text: msg.msg,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function () {
                            window.location.reload();
                        })
                    }
                    setTimeout(function () {
                        $("#alert").css('display', 'none');
                    }, 5000);
                }
            });
        } else if (type == 'delete') {

            res = confirm('Do you really want to delete?');
            if (res === false) {
                return;
            }

            $.ajax({
                url: action,
                type: 'get',
                dataType: 'json',
                beforeSend: function () {},
                success: function (msg) {
                    if (msg.status == 0) {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'warning',
                            title: msg.title,
                            text: msg.msg,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: msg.title,
                            text: msg.msg,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function () {
                            window.location.reload();
                        });
                        // window.location.reload();
                    }
                    setTimeout(function () {
                        $("#alert").css('display', 'none');
                    }, 5000);
                }
            });
        } else if (type == 'edit') {
            id = $('#con-edit-address-modal');
            id.modal('show');
            dataArray = JSON.parse($(this).attr('data-array'));
            id.find('#id').val(dataArray.id);
            id.find('#address').val(dataArray.address);
            id.find('#landmark').val(dataArray.landmark);
            id.find('#city').val(dataArray.city);
            id.find('#state').val(dataArray.state);
            id.find('#country').val(dataArray.country);
            id.find('#pinCode').val(dataArray.pinCode);
            id.find('#contactNumber').val(dataArray.contactNumber);
        } else {}
    });



    /*--- Modal Close ---*/
    let modalClose = $('#con-product-modal, #con-loginRegister-modal, #con-add-address-modal, #con-edit-address-modal');

    modalClose.on("hidden.bs.modal", function () {
        $(this).modal('hide');
        $(this).find('form')[0].reset();
        modalCloseCall();
    })

    modalClose.find('.close-modal').click(function () {
        modalClose.modal('hide');
        $(this).closest('form')[0].reset();
        modalCloseCall();
    })

    function modalCloseCall() {
        addToCart.find('.quantity span').text(1)
        addToCart.find('.quantity input').val(1)

        $("#checkLoginForm").find("#alert").css('display', 'none');
        $('#checkLoginForm').find("#emailErr, #passwordErr").text('');

        $("#checkLoginForm").find("#alert").css('display', 'none');
        $('#checkLoginForm').find("#emailErr, #passwordErr").text('');

        $("#saveRegisterForm").find("#alert").css('display', 'none');
        $('#saveRegisterForm').find("#nameErr, #phoneErr, #emailErr, #passwordErr, #confirmPasswordErr").text('');

        $("#checkOtpForm").find("#alert").css('display', 'none');
        $('#checkOtpForm').find("#otpErr").text('');

        $("#saveAddressForm, #updateAddressForm").find("#alert").css('display', 'none');
        $('#saveAddressForm, #updateAddressForm').find("#addressErr, #landmarkErr, #cityErr, #stateErr, #countryErr, #pinCodeErr, #contactNumberErr").text('');
    }
})