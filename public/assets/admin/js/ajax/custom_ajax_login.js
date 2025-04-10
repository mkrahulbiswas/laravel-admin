$('document').ready(function () {
    var pathArray = window.location.pathname.split('/'),
        submitForm, submitBtn;

    loader()

    function loader($type) {
        if ($type == 1) {
            $("#internalLoader").fadeIn(500);
            $('body').css({
                'overflow-y': 'hidden'
            });
        } else {
            $("#internalLoader").fadeOut(500);
            $('body').css({
                'overflow-y': 'scroll'
            });
        }
    }

    /*--========================= ( Check Login Page Start ) =========================--*/
    $('#checkLoginForm').submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#checkLoginBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serializeArray(),
            type: $(this).attr('method'),
            dataType: 'json',
            beforeSend: function () {
                loader(1);
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                loader(0);
                submitBtn.attr("disabled", false).find('span').text('save');

                submitForm.find("#emailErr, #passwordErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'Opps....!',
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 30000000
                    });

                    $.each(msg.errors.phone, function (i) {
                        submitForm.find("#emailErr").text(msg.errors.phone[i]).removeClass('').addClass('invalid-feedback');
                    });
                    $.each(msg.errors.password, function (i) {
                        submitForm.find("#passwordErr").text(msg.errors.password[i]).removeClass('').addClass('invalid-feedback');
                    });

                } else {
                    submitForm.find("#emailErr, #passwordErr").addClass('valid-feedback');

                    let timerInterval
                    Swal.fire({
                        title: 'login ' + msg.msg,
                        html: 'you will redirect to dashboard in <strong></strong> seconds.',
                        timer: 2000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showCloseButton: false,
                        showCancelButton: false,
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
                        }
                    });

                }
            }
        });
    });


    $('#forgotPasswordForm').submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#forgotPasswordBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serializeArray(),
            type: $(this).attr('method'),
            dataType: 'json',
            beforeSend: function () {
                loader(1);
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                loader(0);
                submitBtn.attr("disabled", false).find('span').text('save');

                submitForm.find("#emailErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'Opps....!',
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    $.each(msg.errors.email, function (i) {
                        submitForm.find("#emailErr").text(msg.errors.email[i]);
                    });

                } else {
                    // Swal.fire({
                    //     position: 'center-center',
                    //     icon: 'success',
                    //     title: 'Success',
                    //     text: msg.msg,
                    //     showConfirmButton: false,
                    //     timer: 3000
                    // });

                    $('#checkLoginForm, #forgotPasswordForm').closest('.wrapper-page').hide();
                    $('#resetPasswordForm').closest('.wrapper-page').show();

                    submitForm[0].reset();

                }
            }
        });
    });



    $('#resetPasswordForm').submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#resetPasswordBtn');

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serializeArray(),
            type: $(this).attr('method'),
            dataType: 'json',
            beforeSend: function () {
                loader(1);
                submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
            },
            success: function (msg) {
                loader(0);
                submitBtn.attr("disabled", false).find('span').text('save');

                submitForm.find("#otpErr, #passwordErr, #confirmPasswordErr").text('');

                if (msg.status == 0) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'Opps....!',
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    $.each(msg.errors.otp, function (i) {
                        submitForm.find("#otpErr").text(msg.errors.otp[i]);
                    });
                    $.each(msg.errors.password, function (i) {
                        submitForm.find("#passwordErr").text(msg.errors.password[i]);
                    });
                    $.each(msg.errors.confirmPassword, function (i) {
                        submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]);
                    });

                } else {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: 'Success',
                        text: msg.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(function () {
                        submitForm[0].reset();
                    }, 1000);

                }
            }
        });
    });
    /*--========================= ( Check Login Page END ) =========================--*/


});
