(function ($) {

    $(function () {
        var submitBtn, id = '';


        /*--========================= ( Profile START ) =========================--*/
        //---- ( Auth Profile Update ) ----//
        $("#updateAuthProfileForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAuthProfileBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.pinCode, function (i) {
                            submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.state, function (i) {
                            submitForm.find("#stateErr").text(msg.errors.state[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.country, function (i) {
                            submitForm.find("#countryErr").text(msg.errors.country[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.location.reload()
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Change Password ) ----//
        $("#changeAuthPasswordForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#changeAuthPasswordBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update Password',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.oldPassword, function (i) {
                            submitForm.find("#oldPasswordErr").text(msg.errors.oldPassword[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.newPassword, function (i) {
                            submitForm.find("#newPasswordErr").text(msg.errors.newPassword[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.confirmPassword, function (i) {
                            submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 2) {
                        submitForm.find("#oldPasswordErr").html(msg.msg + ' <a href="javascript:void(0);" class="link-primary resetModal" data-bs-toggle="modal" data-bs-target="#con-reset-modal" data-type="password">Forgot password?</a>').closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            resetForm: {
                                inputField: {}
                            },
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Change Pin ) ----//
        $("#changeAuthPinForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#changeAuthPinBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update PIN',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.oldPin, function (i) {
                            submitForm.find("#oldPinErr").text(msg.errors.oldPin[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.newPin, function (i) {
                            submitForm.find("#newPinErr").text(msg.errors.newPin[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.confirmPin, function (i) {
                            submitForm.find("#confirmPinErr").text(msg.errors.confirmPin[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 2) {
                        submitForm.find("#oldPinErr").html(msg.msg + ' <a href="javascript:void(0);" class="link-primary resetModal" data-bs-toggle="modal" data-bs-target="#con-reset-modal" data-type="pin">Forgot pin?</a>').closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            resetForm: {
                                inputField: {}
                            },
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Reset Send ) ----//
        $("#resetAuthSendForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#resetAuthSendBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        submitBtnState: {
                            dataPass: {
                                text: 'Click to send OTP',
                                disabled: false
                            }
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                    })
                    if (msg.status == 1) {
                        submitForm.closest('.con-reset-modal').find('.sendOtp, .verifyOtp, .resetPassword').hide()
                        submitForm.closest('.con-reset-modal').find('.verifyOtp').show()
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Reset Verify ) ----//
        $("#resetAuthVerifyForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#resetAuthVerifyBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Verify OTP',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.otp, function (i) {
                            submitForm.find("#otpErr").text(msg.errors.otp[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        submitForm.closest('.con-reset-modal').find('.sendOtp, .verifyOtp, .resetPassword').hide()
                        submitForm.closest('.con-reset-modal').find('.resetPassword').show()
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Reset Update ) ----//
        $("#resetAuthUpdateForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#resetAuthUpdateBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update and change',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.newPin, function (i) {
                            submitForm.find("#newPinErr").text(msg.errors.newPin[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.confirmPin, function (i) {
                            submitForm.find("#confirmPinErr").text(msg.errors.confirmPin[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.newPassword, function (i) {
                            submitForm.find("#newPasswordErr").text(msg.errors.newPassword[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.confirmPassword, function (i) {
                            submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 2) {
                        submitForm.closest('.con-reset-modal').find('.sendOtp, .verifyOtp, .resetPassword').hide()
                        submitForm.closest('.con-reset-modal').find('.sendOtp').show()
                    } else {
                        submitForm.closest('#con-reset-modal').modal('hide');
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Change Image ) ----//
        $("#changeAuthImageForm").submit(function (event) {
            let submitForm = $(this),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        loader: {
                            isSet: true
                        },
                        targetId: {
                            submitForm: submitForm,
                        },
                        reset: {
                            resetValidation: {}
                        },
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        reset: {
                            resetValidation: {}
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        submitForm.find('.user-profile-image').attr('src', msg.data.image)
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Change Send ) ----//
        $("#changeAuthSendForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#changeAuthSendBtn'),
                formData = new FormData(this);

            console.log(window.commonAction);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        submitBtnState: {
                            dataPass: {
                                text: 'Continue',
                                disabled: false
                            }
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        reset: {
                            resetValidation: {}
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        submitForm.closest('.con-change-modal').find('.sendOtp, .verifyOtp').hide()
                        submitForm.closest('.con-change-modal').find('.verifyOtp').show()
                        submitForm.closest('.con-change-modal').find('#changeValue').val(msg.data.changeValue)
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Auth Change Verify ) ----//
        $("#changeAuthVerifyForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#changeAuthVerifyBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Verify OTP',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.otp, function (i) {
                            submitForm.find("#otpErr").text(msg.errors.otp[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        submitForm.closest('.con-change-modal').find('.sendOtp, .verifyOtp').hide()
                        submitForm.closest('.con-change-modal').find('.sendOtp').show()
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });
        /*--========================= ( Profile END ) =========================--*/


        /*--========================= ( Manage Users START ) =========================--*/
        //---- ( Admin Users Save ) ----//
        $("#saveAdminUsersForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveAdminUsersBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subRole, function (i) {
                            submitForm.find("#subRoleErr").text(msg.errors.subRole[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.pinCode, function (i) {
                            submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.state, function (i) {
                            submitForm.find("#stateErr").text(msg.errors.state[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.country, function (i) {
                            submitForm.find("#countryErr").text(msg.errors.country[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {},
                                summernote: {},
                                dropify: {},
                            },
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Admin Users Update ) ----//
        $("#updateAdminUsersForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAdminUsersBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subRole, function (i) {
                            submitForm.find("#subRoleErr").text(msg.errors.subRole[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.pinCode, function (i) {
                            submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.state, function (i) {
                            submitForm.find("#stateErr").text(msg.errors.state[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.country, function (i) {
                            submitForm.find("#countryErr").text(msg.errors.country[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Admin Users Status, Edit, Detail ) ----//
        $('body').delegate('#manageUsers-adminUsers .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#manageUsers-adminUsers'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#icon').val(data.icon);
                id.find('#description').val(data.description);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#icon').html('<i class="' + data.icon + '"></i>');
                id.find('#description').text(data.description);
            }
        });
        /*--========================= ( Manage Users END ) =========================--*/




        /*--========================= ( Navigation & Access START ) =========================--*/
        //---- ( Nav Type Save ) ----//
        $("#saveNavTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveNavTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-navType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Nav Type Update ) ----//
        $("#updateNavTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateNavTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-navType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Nav Type Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-navigationAccess-manageSideNav-navType .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-navigationAccess-manageSideNav-navType'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#icon').val(data.icon);
                id.find('#description').val(data.description);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#icon').html('<i class="' + data.icon + '"></i>');
                id.find('#description').text(data.description);
            }
        });


        //---- ( Main Nav Save ) ----//
        $("#saveMainNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveMainNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.navType, function (i) {
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-mainNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Main Nav Update ) ----//
        $("#updateMainNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateMainNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.navType, function (i) {
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-mainNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Main Nav Access ) ----//
        $("#accessMainNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#accessMainNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Set Access',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-mainNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Main Nav Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-navigationAccess-manageSideNav-mainNav .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-navigationAccess-manageSideNav-mainNav'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find("#navType2 option[data-name='" + data.navType.name + "']").prop("selected", true).trigger('change');
                id.find('#name').val(data.name);
                id.find('#icon').val(data.icon);
                id.find('#description').val(data.description);
            } else if (type == 'access') {
                data = JSON.parse($(this).attr('data-array'));
                if (data.extraData.hasSubNav > 0) {
                    window.commonAction({
                        swal: {
                            type: 'basic',
                            props: {
                                position: 'center-center',
                                icon: 'warning',
                                title: 'Oops....!',
                                html: 'There some sub nav found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.subNavRoute + '">sub nav</a>',
                                showConfirmButton: false,
                                timer: 10000
                            }
                        },
                    })
                } else {
                    id = $('#con-access-modal');
                    id.modal('show');
                    if (data.access != null) {
                        Object.entries(data.access).forEach((element) => {
                            id.find('[name="access[' + element[0] + ']"]').attr('checked', (element[1] == true) ? true : false)
                        });
                    }
                    id.find('#id').val(data.id);
                    id.find('#name').val(data.name);
                }
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#navType').text(data.navType.name);
                id.find('#icon').html('<i class="' + data.icon + '"></i>');
                id.find('#description').text(data.description);
                if (data.access != null) {
                    setTimeout(() => {
                        id.find('#access').html('');
                        Object.entries(data.access).forEach((element) => {
                            if (element[1]) {
                                id.find('#access').append('<div class="accessSet">' + element[0] + '</div>');
                            }
                        });
                    }, 1000)
                } else {
                    id.find('#access').text('No access set yet, please set now. Its impotent because without access you cannot controls action buttons.');
                }
            }
        });


        //---- ( Sub Nav Save ) ----//
        $("#saveSubNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveSubNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.navType, function (i) {
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-subNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Sub Nav Update ) ----//
        $("#updateSubNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateSubNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.navType, function (i) {
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-subNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Sub Nav Access ) ----//
        $("#accessSubNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#accessSubNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Set Access',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-subNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Sub Nav Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-navigationAccess-manageSideNav-subNav .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-navigationAccess-manageSideNav-subNav'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#icon').val(data.icon);
                id.find('#description').val(data.description);
                id.find("#navType2 option[data-name='" + data.navType.name + "']").prop("selected", true).trigger('change');
                setTimeout(() => {
                    id.find("#mainNav2 option[data-name='" + data.mainNav.name + "']").prop("selected", true).trigger('change');
                }, 1000);
            } else if (type == 'access') {
                data = JSON.parse($(this).attr('data-array'));
                if (data.extraData.hasNestedNav > 0) {
                    window.commonAction({
                        swal: {
                            type: 'basic',
                            props: {
                                position: 'center-center',
                                icon: 'warning',
                                title: 'Oops....!',
                                html: 'There some nested nav found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.nestedNavRoute + '">nested nav</a>',
                                showConfirmButton: false,
                                timer: 10000
                            }
                        },
                    })
                } else {
                    id = $('#con-access-modal');
                    id.modal('show');
                    if (data.access != null) {
                        Object.entries(data.access).forEach((element) => {
                            id.find('[name="access[' + element[0] + ']"]').attr('checked', (element[1] == true) ? true : false)
                        });
                    }
                    id.find('#id').val(data.id);
                    id.find('#name').val(data.name);
                }
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#navType').text(data.navType.name);
                id.find('#mainNav').text(data.mainNav.name);
                id.find('#icon').html('<i class="' + data.icon + '"></i>');
                id.find('#description').text(data.description);
                if (data.access != null) {
                    setTimeout(() => {
                        id.find('#access').html('');
                        Object.entries(data.access).forEach((element) => {
                            if (element[1]) {
                                id.find('#access').append('<div class="accessSet">' + element[0] + '</div>');
                            }
                        });
                    }, 1000)
                } else {
                    id.find('#access').text('No access set yet, please set now. Its impotent because without access you cannot controls action buttons.');
                }
            }
        });


        //---- ( Nested Nav Save ) ----//
        $("#saveNestedNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveNestedNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.navType, function (i) {
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subNav, function (i) {
                            submitForm.find("#subNavErr").text(msg.errors.subNav[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-nestedNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Nested Nav Update ) ----//
        $("#updateNestedNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateNestedNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.navType, function (i) {
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subNav, function (i) {
                            submitForm.find("#subNavErr").text(msg.errors.subNav[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-nestedNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Nested Nav Access ) ----//
        $("#accessNestedNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#accessNestedNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Set Access',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-nestedNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Nested Nav Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-navigationAccess-manageSideNav-nestedNav .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-navigationAccess-manageSideNav-nestedNav'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#icon').val(data.icon);
                id.find('#description').val(data.description);
                id.find("#navType2 option[data-name='" + data.navType.name + "']").prop("selected", true).trigger('change');
                setTimeout(() => {
                    id.find("#mainNav2 option[data-name='" + data.mainNav.name + "']").prop("selected", true).trigger('change');
                }, 1000);
                setTimeout(() => {
                    id.find("#subNav2 option[data-name='" + data.subNav.name + "']").prop("selected", true).trigger('change');
                }, 2000);
            } else if (type == 'access') {
                data = JSON.parse($(this).attr('data-array'));
                id = $('#con-access-modal');
                id.modal('show');
                if (data.access != null) {
                    Object.entries(data.access).forEach((element) => {
                        id.find('[name="access[' + element[0] + ']"]').attr('checked', (element[1] == true) ? true : false)
                    });
                }
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#navType').text(data.navType.name);
                id.find('#mainNav').text(data.mainNav.name);
                id.find('#subNav').text(data.subNav.name);
                id.find('#icon').html('<i class="' + data.icon + '"></i>');
                id.find('#description').text(data.description);
                if (data.access != null) {
                    setTimeout(() => {
                        id.find('#access').html('');
                        Object.entries(data.access).forEach((element) => {
                            if (element[1]) {
                                id.find('#access').append('<div class="accessSet">' + element[0] + '</div>');
                            }
                        });
                    }, 1000)
                } else {
                    id.find('#access').text('No access set yet, please set now. Its impotent because without access you cannot controls action buttons.');
                }
            }
        });


        //---- ( Arrange Side Nav Update ) ----//
        $("#updateArrangeSideNavForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateArrangeSideNavBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })

                    if (msg.status == 0) {

                    } else {
                        window.location.reload();
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });
        /*--========================= ( Navigation & Access END ) =========================--*/


        /*--========================= ( Role & Permission START ) =========================--*/
        //---- ( Main Role Save ) ----//
        $("#saveMainRoleForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveMainRoleBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-rolePermission-manageRole-mainRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Main Role Update ) ----//
        $("#updateMainRoleForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateMainRoleBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-rolePermission-manageRole-mainRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Permission Main Role Update ) ----//
        $("#updatePermissionMainRoleForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updatePermissionMainRoleBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        // $.each(msg.errors.name, function (i) {
                        //     submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        // });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-permissionMainRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Main Role Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-rolePermission-manageRole-mainRole .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-rolePermission-manageRole-mainRole'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#description').val(data.description);
            } else if (type == 'info') {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#description').text(data.description);
            } else if (type == 'permission') {
                data = JSON.parse($(this).attr('data-array'));
                window.commonAction({
                    swal: {
                        type: 'basic',
                        props: {
                            position: 'center-center',
                            icon: 'warning',
                            title: 'Oops....!',
                            html: 'There some sub role found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.subRoleRoute + '">sub role</a>',
                            showConfirmButton: false,
                            timer: 10000
                        }
                    },
                })
            } else if (type == 'setPermission') {
                data = JSON.parse($(this).attr('data-array'));
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: "Are you sure to create permission set against of all side nav, of this particular role type '" + data.name + "'",
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else {}
        });


        //---- ( Sub Role Save ) ----//
        $("#saveSubRoleForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveSubRoleBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-rolePermission-manageRole-subRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Sub Role Update ) ----//
        $("#updateSubRoleForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateSubRoleBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-rolePermission-manageRole-subRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Permission Sub Role Update ) ----//
        $("#updatePermissionSubRoleForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updatePermissionSubRoleBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        // $.each(msg.errors.name, function (i) {
                        //     submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        // });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-permissionSubRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Sub Role Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-rolePermission-manageRole-subRole .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-rolePermission-manageRole-subRole'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#description').val(data.description);
                id.find("#mainRole2 option[data-name='" + data.mainRole.name + "']").prop("selected", true).trigger('change');
            } else if (type == 'info') {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#mainRole').text(data.mainRole.name);
                id.find('#name').text(data.name);
                id.find('#description').text(data.description);
            } else if (type == 'setPermission') {
                data = JSON.parse($(this).attr('data-array'));
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: "Are you sure to create permission set against of all side nav, of this particular role type '" + data.name + "'",
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else {}
        });
        /*--========================= ( Role & Permission END ) =========================--*/



        /*--========================= ( Quick Setting START ) =========================--*/
        //---- ( Logo Save ) ----//
        $("#saveLogoForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveLogoBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.bigLogo, function (i) {
                            submitForm.find("#bigLogoErr").text(msg.errors.bigLogo[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.smallLogo, function (i) {
                            submitForm.find("#smallLogoErr").text(msg.errors.smallLogo[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.favicon, function (i) {
                            submitForm.find("#faviconErr").text(msg.errors.favicon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-siteSetting-logo')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Logo Update ) ----//
        $("#updateLogoForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateLogoBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.bigLogo, function (i) {
                            submitForm.find("#bigLogoErr").text(msg.errors.bigLogo[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.smallLogo, function (i) {
                            submitForm.find("#smallLogoErr").text(msg.errors.smallLogo[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.favicon, function (i) {
                            submitForm.find("#faviconErr").text(msg.errors.favicon[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-siteSetting-logo')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Logo Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-quickSetting-siteSetting-logo .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-quickSetting-siteSetting-logo'),
                data = '';

            if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the current default will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#bigLogo').closest('.set-validation').find('img').attr('src', data.bigLogo);
                id.find('#smallLogo').closest('.set-validation').find('img').attr('src', data.smallLogo);
                id.find('#favicon').closest('.set-validation').find('img').attr('src', data.favicon);
            } else if (type == 'info') {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#bigLogo img').attr('src', data.bigLogo);
                id.find('#smallLogo img').attr('src', data.smallLogo);
                id.find('#favicon img').attr('src', data.favicon);
            } else if (type == 'setPermission') {
                data = JSON.parse($(this).attr('data-array'));
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: "Are you sure to create permission set against of all side nav, of this particular role type '" + data.name + "'",
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else {}
        });


        //---- ( Alert Type Save ) ----//
        $("#saveAlertTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveAlertTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Alert Type Update ) ----//
        $("#updateAlertTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAlertTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Alert Type Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-quickSetting-customizedAlert-alertType .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-quickSetting-customizedAlert-alertType'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
            } else {}
        });


        //---- ( Alert For Save ) ----//
        $("#saveAlertForForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveAlertForBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.alertType, function (i) {
                            submitForm.find("#alertTypeErr").text(msg.errors.alertType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertFor')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Alert For Update ) ----//
        $("#updateAlertForForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAlertForBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.alertType, function (i) {
                            submitForm.find("#alertTypeErr").text(msg.errors.alertType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertFor')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Alert For Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-quickSetting-customizedAlert-alertFor .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-quickSetting-customizedAlert-alertFor'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find("#alertType option[data-name='" + data.alertType.name + "']").prop("selected", true).trigger('change');
            } else {}
        });


        //---- ( Alert Template Save ) ----//
        $("#saveAlertTemplateForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveAlertTemplateBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.alertType, function (i) {
                            submitForm.find("#alertTypeErr").text(msg.errors.alertType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.alertFor, function (i) {
                            submitForm.find("#alertForErr").text(msg.errors.alertFor[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.heading, function (i) {
                            submitForm.find("#headingErr").text(msg.errors.heading[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.content, function (i) {
                            submitForm.find("#contentErr").text(msg.errors.content[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {},
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertTemplate')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Alert Template Update ) ----//
        $("#updateAlertTemplateForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAlertTemplateBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.alertType, function (i) {
                            submitForm.find("#alertTypeErr").text(msg.errors.alertType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.alertFor, function (i) {
                            submitForm.find("#alertForErr").text(msg.errors.alertFor[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.heading, function (i) {
                            submitForm.find("#headingErr").text(msg.errors.heading[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.content, function (i) {
                            submitForm.find("#contentErr").text(msg.errors.content[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertTemplate')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Alert Template Status, Edit, Detail ) ----//
        $('body').delegate('#adminRelated-quickSetting-customizedAlert-alertTemplate .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#adminRelated-quickSetting-customizedAlert-alertTemplate'),
                data = '',
                html = '';

            if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#heading').val(data.heading);
                id.find('#content').summernote('code', data.content);
                id.find("#alertType option[data-name='" + data.alertType.name + "']").prop("selected", true).trigger('change');
                setTimeout(() => {
                    id.find("#alertFor2 option[data-name='" + data.alertFor.name + "']").prop("selected", true).trigger('change');
                }, 1000)
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#alertType').text(data.alertType.name);
                id.find('#alertFor').text(data.alertFor.name);
                id.find('#heading').text(data.heading);
                id.find('#content').html(data.content);
                if (data.variable.length <= 0) {
                    id.find('#variable').html('<span>No variable found</span>');
                } else {
                    html += '<div class="variable">'
                    data.variable.forEach((val) => {
                        html += '<span class="variableItem" data-variable="' + val + '">' + val.toUpperCase().replace(/[\[\~\]\!]/g, '') + '</span>'
                    })
                    html += '</div>'
                    id.find('#variable').html('').append(html);
                }
            }
        });
        /*--========================= ( Quick Setting END ) =========================--*/




        /*--========================= ( Property Related START ) =========================--*/
        //---- ( Property Attribute Save ) ----//
        $("#savePropertyAttributeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#savePropertyAttributeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.type, function (i) {
                            submitForm.find("#typeErr").text(msg.errors.type[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-propertyAttribute')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Property Attribute Update ) ----//
        $("#updatePropertyAttributeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updatePropertyAttributeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.type, function (i) {
                            submitForm.find("#typeErr").text(msg.errors.type[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-propertyAttribute')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Property Attribute Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-propertyAttribute .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-propertyAttribute'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#about').val(data.about);
                id.find("#type2").val(data.customizeInText.type.raw).trigger('change');
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#about').text(data.about);
                id.find('#type').text(data.customizeInText.type.formatted);
            }
        });


        //---- ( Property Type Save ) ----//
        $("#savePropertyTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#savePropertyTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-propertyType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Property Type Update ) ----//
        $("#updatePropertyTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updatePropertyTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-propertyType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Property Type Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-propertyType .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-propertyType'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#about').val(data.about);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#about').text(data.about);
            }
        });


        //---- ( Broad Type Save ) ----//
        $("#saveBroadTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveBroadTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-manageBroad-broadType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Broad Type Update ) ----//
        $("#updateBroadTypeForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateBroadTypeBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-manageBroad-broadType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Broad Type Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-manageBroad-broadType .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-manageBroad-broadType'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#about').val(data.about);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#name').text(data.name);
                id.find('#about').text(data.about);
            }
        });


        //---- ( Assign Broad Save ) ----//
        $("#saveAssignBroadForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveAssignBroadBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.broadType, function (i) {
                            submitForm.find("#broadTypeErr").text(msg.errors.broadType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-manageBroad-assignBroad')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Assign Broad Update ) ----//
        $("#updateAssignBroadForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAssignBroadBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.broadType, function (i) {
                            submitForm.find("#broadTypeErr").text(msg.errors.broadType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-manageBroad-assignBroad')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Assign Broad Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-manageBroad-assignBroad .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-manageBroad-assignBroad'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find("#propertyType2 option[data-name='" + data.propertyType.name + "']").prop("selected", true).trigger('change');
                id.find("#broadType2 option[data-name='" + data.broadType.name + "']").prop("selected", true).trigger('change');
                id.find('#about').val(data.about);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#propertyType').text(data.propertyType.name);
                id.find('#broadType').text(data.broadType.name);
                id.find('#about').text(data.about);
            }
        });


        //---- ( Manage Category Save ) ----//
        $("#saveManageCategoryForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveManageCategoryBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subCategory, function (i) {
                            submitForm.find("#subCategoryErr").text(msg.errors.subCategory[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('.propertyRelated-propertyCategory-manageCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Manage Category Update ) ----//
        $("#updateManageCategoryForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateManageCategoryBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subCategory, function (i) {
                            submitForm.find("#subCategoryErr").text(msg.errors.subCategory[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('.propertyRelated-propertyCategory-manageCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Manage Category Status, Edit, Detail ) ----//
        $('body').delegate('.propertyRelated-propertyCategory-manageCategory .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('.propertyRelated-propertyCategory-manageCategory'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                if (data.type == 'MAIN') {
                    id.find('#name').val(data.name);
                }
                if (data.type == 'SUB') {
                    id.find("#mainCategory2 option[data-name='" + data.mainCategory.name + "']").prop("selected", true).trigger('change');
                    id.find('#name').val(data.name);
                }
                if (data.type == 'NESTED') {
                    id.find("#mainCategory2 option[data-name='" + data.mainCategory.name + "']").prop("selected", true).trigger('change');
                    setTimeout(function () {
                        id.find("#subCategory2 option[data-name='" + data.subCategory.name + "']").prop("selected", true).trigger('change');
                    }, 1000)
                    id.find('#name').val(data.name);
                }
                id.find('#about').val(data.about);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#subCategory, #nestedCategory').closest('.col-12').hide();
                if (data.type == 'MAIN') {
                    id.find('#mainCategory').closest('.col-12').show();
                    id.find('#mainCategory').text(data.name);
                }
                if (data.type == 'SUB') {
                    id.find('#mainCategory, #subCategory').closest('.col-12').show();
                    id.find('#mainCategory').text(data.mainCategory.name);
                    id.find('#subCategory').text(data.name);
                }
                if (data.type == 'NESTED') {
                    id.find('#mainCategory, #subCategory, #nestedCategory').closest('.col-12').show();
                    id.find('#mainCategory').text(data.mainCategory.name);
                    id.find('#subCategory').text(data.subCategory.name);
                    id.find('#nestedCategory').text(data.name);
                }
                id.find('#about').text(data.about);
            }
        });


        //---- ( Assign Category Save ) ----//
        $("#saveAssignCategoryForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#saveAssignCategoryBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.assignBroad, function (i) {
                            submitForm.find("#assignBroadErr").text(msg.errors.assignBroad[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-propertyCategory-assignCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Save',
                                disabled: false
                            }
                        }
                    })
                }
            });
        });

        //---- ( Assign Category Update ) ----//
        $("#updateAssignCategoryForm").submit(function (event) {
            let submitForm = $(this),
                submitBtn = $(this).find('#updateAssignCategoryBtn'),
                formData = new FormData(this);

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: formData,
                type: $(this).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        reset: {
                            resetValidation: {}
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    window.commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: false
                        },
                        toaster: {
                            dataPass: {
                                title: msg.title,
                                msg: msg.msg,
                                type: msg.type
                            }
                        },
                        submitBtnState: {
                            dataPass: {
                                text: 'Update',
                                disabled: false
                            }
                        }
                    })
                    if (msg.status == 0) {
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.assignBroad, function (i) {
                            submitForm.find("#assignBroadErr").text(msg.errors.assignBroad[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(window.errorClassList).addClass('invalid-input');
                        });
                    } else {
                        window.commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            resetForm: {
                                inputField: {}
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#propertyRelated-propertyCategory-assignCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    window.commonAction({
                        loader: {
                            isSet: false
                        },
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        toaster: {
                            dataPass: {
                                title: textStatus,
                                msg: error,
                                type: textStatus
                            }
                        },
                    })
                }
            });
        });

        //---- ( Assign Category Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-propertyCategory-assignCategory .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-propertyCategory-assignCategory'),
                data = '';

            if (type == 'status') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the status wil change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'delete') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'delete',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action data will be deleted permanently!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'default') {
                window.commonMethod({
                    type: 'common',
                    action: action,
                    method: 'patch',
                    targetTableId: targetTableId,
                    swalData: {
                        title: 'Are you sure?',
                        text: 'By this action the data default state will change!',
                        icon: 'warning',
                        confirmButtonText: 'Yes, do it!',
                        cancelButtonText: 'No, cancel',
                    }
                })
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#id').val(data.id);
                id.find("#mainCategory2 option[data-name='" + data.mainCategory.name + "']").prop("selected", true).trigger('change');
                id.find("#propertyType2 option[data-name='" + data.assignBroad.propertyType.name + "']").prop("selected", true).trigger('change');
                setTimeout(function () {
                    id.find("#assignBroad2 option[data-name='" + data.assignBroad.broadType.name + "']").prop("selected", true).trigger('change');
                }, 1000)
                id.find('#about').val(data.about);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#mainCategory').text(data.mainCategory.name);
                id.find('#propertyType').text(data.assignBroad.propertyType.name);
                id.find('#assignBroad').text(data.assignBroad.broadType.name);
                id.find('#about').text(data.about);
            }
        });
        /*--========================= ( Property Related END ) =========================--*/

    })
})(jQuery);
