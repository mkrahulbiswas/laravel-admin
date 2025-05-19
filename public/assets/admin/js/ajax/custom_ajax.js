(function ($) {

    $(function () {
        var pathArray = window.location.pathname.split('/'),
            submitForm, submitBtn, id = '',
            errorClassList = '.form-control, .select2-container--default .select2-selection--single';

        function commonAction(data) {
            let targetForm = (data.targetId != undefined) ? data.targetId.submitForm : '',
                targetBtn = (data.targetId != undefined) ? data.targetId.submitBtn : '';

            if (data.afterSuccess != undefined) {
                if (data.afterSuccess.resetForm == true) {
                    targetForm[0].reset();
                }
                if (data.afterSuccess.hideModal == true) {
                    targetForm.closest('.con-common-modal').modal('hide');
                }
            }

            if (data.dataTable != undefined) {
                if (data.dataTable.reload != undefined) {
                    data.dataTable.reload.targetId.DataTable().ajax.reload(null, false);
                }
            }

            if (data.loader != undefined) {
                if (data.loader.isSet == true) {
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

            if (data.resetValidation != undefined) {
                targetForm.find(".validation-error").text('');
                targetForm.find(errorClassList).removeClass('valid-input invalid-input');
            }

            if (data.submitBtnState != undefined) {
                targetBtn.attr("disabled", data.submitBtnState.dataPass.disabled).find('span').text(data.submitBtnState.dataPass.text);
            }

            if (data.toaster != undefined) {
                $.toast({
                    heading: (data.toaster.dataPass.title == undefined) ? 'NA' : data.toaster.dataPass.title,
                    text: (data.toaster.dataPass.msg == undefined) ? 'NA' : data.toaster.dataPass.msg,
                    showHideTransition: 'slide',
                    icon: (data.toaster.dataPass.type == undefined) ? 'warning' : data.toaster.dataPass.type,
                    hideAfter: 10000,
                    stack: 3,
                    position: 'top-right',
                });
            }

            if (data.swal != undefined) {
                Swal.fire({
                    ...data.swal
                });
            }
        }

        function commonMethod(data) {
            if (data.type == 'common') {
                Swal.fire({
                    title: data.swalData.title,
                    text: data.swalData.text,
                    icon: data.swalData.icon,
                    showCancelButton: true,
                    confirmButtonText: data.swalData.confirmButtonText,
                    cancelButtonText: data.swalData.cancelButtonText,
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: data.action,
                            type: 'get',
                            dataType: 'json',
                            beforeSend: function () {
                                commonAction({
                                    loader: {
                                        isSet: true
                                    }
                                })
                            },
                            success: function (msg) {
                                commonAction({
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
                                })
                                if (msg.status == 1) {
                                    commonAction({
                                        dataTable: {
                                            reload: {
                                                targetId: data.targetTableId
                                            }
                                        }
                                    })
                                }
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            }
        }


        /*--========================= ( USER START ) =========================--*/
        //====Save Sub Admin====//
        $("#saveAdminForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveAdminBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('save');

                    $("#fileErr, #nameErr, #emailErr, #phoneErr, #restaurantErr, #passwordErr, #confirmPasswordErr, #roleErr, #addressErr").text('');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]);
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]);
                        });
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]);
                        });
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                        });
                        $.each(msg.errors.password, function (i) {
                            submitForm.find("#passwordErr").text(msg.errors.password[i]);
                        });
                        $.each(msg.errors.confirmPassword, function (i) {
                            submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]);
                        });
                        $.each(msg.errors.role, function (i) {
                            submitForm.find("#roleErr").text(msg.errors.role[i]);
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]);
                        });
                        $.each(msg.errors.restaurant, function (i) {
                            submitForm.find("#restaurantErr").text(msg.errors.restaurant[i]);
                        });
                    } else if (msg.status == 1) {
                        toaster(msg.title, msg.msg, msg.type);
                        submitForm[0].reset();
                        submitForm.find('select').val(['']).trigger('change');
                        submitForm.find('.dropify-clear').trigger('click');
                    }
                }
            });
        });

        //====Update Sub Admin====//
        $("#updateAdminForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveAdminBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('Update');

                    $("#fileErr, #nameErr, #emailErr, #phoneErr, #passwordErr, #confirmPasswordErr, #roleErr, #addressErr, #orgNameErr, #orgAddressErr").text('');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]);
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]);
                        });
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]);
                        });
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                        });
                        $.each(msg.errors.password, function (i) {
                            submitForm.find("#passwordErr").text(msg.errors.password[i]);
                        });
                        $.each(msg.errors.confirmPassword, function (i) {
                            submitForm.find("#confirmPasswordErr").text(msg.errors.confirmPassword[i]);
                        });
                        $.each(msg.errors.role, function (i) {
                            submitForm.find("#roleErr").text(msg.errors.role[i]);
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]);
                        });
                        $.each(msg.errors.orgName, function (i) {
                            submitForm.find("#orgNameErr").text(msg.errors.orgName[i]);
                        });
                        $.each(msg.errors.orgAddress, function (i) {
                            submitForm.find("#orgAddressErr").text(msg.errors.orgAddress[i]);
                        });
                        $.each(msg.errors.orgEmail, function (i) {
                            submitForm.find("#orgEmailErr").text(msg.errors.orgEmail[i]);
                        });
                        $.each(msg.errors.orgPhone, function (i) {
                            submitForm.find("#orgPhoneErr").text(msg.errors.orgPhone[i]);
                        });
                    } else if (msg.status == 1) {
                        toaster(msg.title, msg.msg, msg.type);
                    }
                }
            });
        });

        //====Status / Delete Sub Admin====//
        $('body').delegate('#users-admin-listing .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                id = $(this).attr('data-id'),
                action = $(this).attr('data-action'),
                reloadDatatable = $('#users-admin-listing').DataTable();
            if (type == 'status') {

                if ($(this).attr('data-status') == 'block') {
                    var res = confirm('Do you really want to block?');
                    if (res === false) {
                        return;
                    }
                } else {
                    var res = confirm('Do you really want to unblock?');
                    if (res === false) {
                        return;
                    }
                }

                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            $("#alert").removeClass("alert-success").addClass("alert-danger");
                            $("#alert").css("display", "block");
                            $("#validationAlert").html(msg.msg);
                        } else {
                            $("#alert").removeClass("alert-danger").addClass("alert-success");
                            $("#alert").css("display", "block");
                            $("#validationAlert").html(msg.msg);

                            reloadDatatable.ajax.reload(null, false);
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
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            toaster(msg.title, msg.msg, msg.type);
                        } else {
                            toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });
            } else {

            }
        });
        /*--========================= ( USER END ) =========================--*/




        /*--========================= ( Setup Admin START ) =========================--*/
        //---- ( Nav Type Save ) ----//
        $("#saveNavTypeForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveNavTypeBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navType')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Type Update ) ----//
        $("#updateNavTypeForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateNavTypeBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navType')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Type Status, Edit, Detail ) ----//
        $('body').delegate('#managePanel-manageNav-navType .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageNav-navType'),
                data = '';

            if (type == 'status') {
                commonMethod({
                    type: 'common',
                    action: action,
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
                commonMethod({
                    type: 'common',
                    action: action,
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


        //---- ( Nav Main Save ) ----//
        $("#saveNavMainForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveNavMainBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Main Update ) ----//
        $("#updateNavMainForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateNavMainBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Main Access ) ----//
        $("#accessNavMainForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#accessNavMainBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Main Status, Edit, Detail ) ----//
        $('body').delegate('#managePanel-manageNav-navMain .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageNav-navMain'),
                data = '';

            if (type == 'status') {
                commonMethod({
                    type: 'common',
                    action: action,
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
                commonMethod({
                    type: 'common',
                    action: action,
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
                if (data.extraData.hasNavSub > 0) {
                    commonAction({
                        swal: {
                            position: 'center-center',
                            icon: 'warning',
                            title: 'Oops....!',
                            html: 'There some sub nav found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.navSubRoute + '">sub nav</a>',
                            showConfirmButton: false,
                            timer: 10000
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


        //---- ( Nav Sub Save ) ----//
        $("#saveNavSubForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveNavSubBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.navMain, function (i) {
                            submitForm.find("#navMainErr").text(msg.errors.navMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navSub')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Sub Update ) ----//
        $("#updateNavSubForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateNavSubBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.navMain, function (i) {
                            submitForm.find("#navMainErr").text(msg.errors.navMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navSub')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Sub Access ) ----//
        $("#accessNavSubForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#accessNavSubBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navSub')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Sub Status, Edit, Detail ) ----//
        $('body').delegate('#managePanel-manageNav-navSub .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageNav-navSub'),
                data = '';

            if (type == 'status') {
                commonMethod({
                    type: 'common',
                    action: action,
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
                commonMethod({
                    type: 'common',
                    action: action,
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
                    id.find("#navMain2 option[data-name='" + data.navMain.name + "']").prop("selected", true).trigger('change');
                }, 1000);
            } else if (type == 'access') {
                data = JSON.parse($(this).attr('data-array'));
                if (data.extraData.hasNavNested > 0) {
                    commonAction({
                        swal: {
                            position: 'center-center',
                            icon: 'warning',
                            title: 'Oops....!',
                            html: 'There some nested nav found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.navNestedRoute + '">nested nav</a>',
                            showConfirmButton: false,
                            timer: 10000
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
                id.find('#navMain').text(data.navMain.name);
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


        //---- ( Nav Nested Save ) ----//
        $("#saveNavNestedForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveNavNestedBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.navMain, function (i) {
                            submitForm.find("#navMainErr").text(msg.errors.navMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.navSub, function (i) {
                            submitForm.find("#navSubErr").text(msg.errors.navSub[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navNested')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Nested Update ) ----//
        $("#updateNavNestedForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateNavNestedBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#navTypeErr").text(msg.errors.navType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.navMain, function (i) {
                            submitForm.find("#navMainErr").text(msg.errors.navMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.navSub, function (i) {
                            submitForm.find("#navSubErr").text(msg.errors.navSub[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.name, function (i) {
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.icon, function (i) {
                            submitForm.find("#iconErr").text(msg.errors.icon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navNested')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Nested Access ) ----//
        $("#accessNavNestedForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#accessNavNestedBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageNav-navNested')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Nav Nested Status, Edit, Detail ) ----//
        $('body').delegate('#managePanel-manageNav-navNested .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageNav-navNested'),
                data = '';

            if (type == 'status') {
                commonMethod({
                    type: 'common',
                    action: action,
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
                commonMethod({
                    type: 'common',
                    action: action,
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
                    id.find("#navMain2 option[data-name='" + data.navMain.name + "']").prop("selected", true).trigger('change');
                }, 1000);
                setTimeout(() => {
                    id.find("#navSub2 option[data-name='" + data.navSub.name + "']").prop("selected", true).trigger('change');
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
                id.find('#navMain').text(data.navMain.name);
                id.find('#navSub').text(data.navSub.name);
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


        //---- ( Main Menu, Sub Menu Orders Update ) ----//
        $("#updateArrangeOrderForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateArrangeOrderBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('Update');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                    } else {
                        toaster(msg.title, msg.msg, msg.type);
                        // console.log(msg.msg);
                    }
                }
            });
        });


        //---- ( Role Main Save ) ----//
        $("#saveRoleMainForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveRoleMainBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-roleMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Role Main Update ) ----//
        $("#updateRoleMainForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateRoleMainBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-roleMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Permission Role Main Update ) ----//
        $("#updatePermissionRoleMainForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updatePermissionRoleMainBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                        //     submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        // });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-permissionRoleMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Role Main Status, Edit, Detail ) ----//
        $('body').delegate('#managePanel-manageAccess-roleMain .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageAccess-roleMain'),
                data = '';

            if (type == 'status') {
                commonMethod({
                    type: 'common',
                    action: action,
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
                commonMethod({
                    type: 'common',
                    action: action,
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
                console.log(data);
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
                commonAction({
                    swal: {
                        position: 'center-center',
                        icon: 'warning',
                        title: 'Oops....!',
                        html: 'There some sub role found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.roleSubRoute + '">sub role</a>',
                        showConfirmButton: false,
                        timer: 10000
                    },
                })
            } else {}
        });


        //---- ( Role Sub Save ) ----//
        $("#saveRoleSubForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveRoleSubBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.roleMain, function (i) {
                            submitForm.find("#roleMainErr").text(msg.errors.roleMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else if (msg.status == 1) {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-roleSub')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Role Sub Update ) ----//
        $("#updateRoleSubForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateRoleSubBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                            submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.roleMain, function (i) {
                            submitForm.find("#roleMainErr").text(msg.errors.roleMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.description, function (i) {
                            submitForm.find("#descriptionErr").text(msg.errors.description[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-roleSub')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Permission Role Sub Update ) ----//
        $("#updatePermissionRoleSubForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updatePermissionRoleSubBtn');

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
                    commonAction({
                        targetId: {
                            submitForm: submitForm,
                            submitBtn: submitBtn,
                        },
                        loader: {
                            isSet: true
                        },
                        resetValidation: {},
                        submitBtnState: {
                            dataPass: {
                                text: 'Please wait...',
                                disabled: true
                            }
                        }
                    })
                },
                success: function (msg) {
                    commonAction({
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
                        //     submitForm.find("#nameErr").text(msg.errors.name[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        // });
                    } else {
                        commonAction({
                            targetId: {
                                submitForm: submitForm,
                                submitBtn: submitBtn,
                            },
                            afterSuccess: {
                                hideModal: true,
                                resetForm: true,
                            },
                            dataTable: {
                                reload: {
                                    targetId: $('#managePanel-manageAccess-permissionRoleMain')
                                }
                            }
                        })
                    }
                }
            });
        });

        //---- ( Role Sub Status, Edit, Detail ) ----//
        $('body').delegate('#managePanel-manageAccess-roleSub .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageAccess-roleSub'),
                data = '';

            if (type == 'status') {
                commonMethod({
                    type: 'common',
                    action: action,
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
                commonMethod({
                    type: 'common',
                    action: action,
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
                id.find("#roleMain option[data-name='" + data.roleMain.name + "']").prop("selected", true).trigger('change');
            } else if (type == 'info') {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#roleMain').text(data.roleMain.name);
                id.find('#name').text(data.name);
                id.find('#description').text(data.description);
            } else {}
        });
        /*--========================= ( Setup Admin END ) =========================--*/




        /*--========================= ( Setting START ) =========================--*/
        //---- ( Logo Add ) ----//
        $('#saveLogoForm').submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveLogoBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('save');

                    submitForm.find("#bigLogoErr").text('');
                    submitForm.find("#smallLogoErr").text('');
                    submitForm.find("#favIconErr").text('');

                    if (msg.status == 0) {
                        submitForm.find("#alert").removeClass("alert-success").addClass("alert-danger");
                        submitForm.find("#alert").css("display", "block");
                        submitForm.find("#validationAlert").html(msg.msg);

                        $.each(msg.errors.bigLogo, function (i) {
                            submitForm.find("#bigLogoErr").text(msg.errors.bigLogo[i]);
                        });
                        $.each(msg.errors.smallLogo, function (i) {
                            submitForm.find("#smallLogoErr").text(msg.errors.smallLogo[i]);
                        });
                        $.each(msg.errors.favIcon, function (i) {
                            submitForm.find("#favIconErr").text(msg.errors.favIcon[i]);
                        });

                    } else {
                        submitForm.find("#alert").removeClass("alert-danger").addClass("alert-success");
                        submitForm.find("#alert").css("display", "block");
                        submitForm.find("#validationAlert").html(msg.msg);

                        setTimeout(function () {
                            submitForm.find("#alert").css('display', 'none');
                        }, 2000);

                        setTimeout(function () {
                            submitForm.find('.dropify-clear').trigger('click');
                            $('#cms-logo-listing').DataTable().ajax.reload(null, false);
                        }, 1000);
                    }
                }
            });
        });

        //---- ( Logo Update ) ----//
        $("#updateLogoForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateLogoBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('update');

                    submitForm.find("#bigLogoErr").text('');
                    submitForm.find("#smallLogoErr").text('');
                    submitForm.find("#favIconErr").text('');

                    if (msg.status == 0) {
                        submitForm.find("#alert").removeClass("alert-success").addClass("alert-danger");
                        submitForm.find("#alert").css("display", "block");
                        submitForm.find("#validationAlert").html(msg.msg);

                        $.each(msg.errors.bigLogo, function (i) {
                            submitForm.find("#bigLogoErr").text(msg.errors.bigLogo[i]);
                        });
                        $.each(msg.errors.smallLogo, function (i) {
                            submitForm.find("#smallLogoErr").text(msg.errors.smallLogo[i]);
                        });
                        $.each(msg.errors.favIcon, function (i) {
                            submitForm.find("#favIconErr").text(msg.errors.favIcon[i]);
                        });

                    } else {
                        submitForm.find("#alert").removeClass("alert-danger").addClass("alert-success");
                        submitForm.find("#alert").css("display", "block");
                        submitForm.find("#validationAlert").html(msg.msg);

                        setTimeout(function () {
                            submitForm.find("#alert").css('display', 'none');
                        }, 2000);

                        setTimeout(function () {
                            $('#cms-logo-listing').DataTable().ajax.reload(null, false);
                        }, 1000);
                    }
                }
            });
        });

        //---- ( Logo Status ) ----//
        $('body').delegate('#cms-logo-listing .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                res = '',
                action = $(this).attr('data-action'),
                reloadDatatable = $('#cms-logo-listing').DataTable();
            if (type == 'status') {

                if ($(this).attr('data-status') == 'block') {
                    res = confirm('Do you really want to block?');
                    if (res === false) {
                        return;
                    }
                } else {
                    res = confirm('Do you really want to unblock?');
                    if (res === false) {
                        return;
                    }
                }

                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            $("#alert").removeClass("alert-success").addClass("alert-danger");
                            $("#alert").css("display", "block");
                            $("#validationAlert").html(msg.msg);
                        } else {
                            $("#alert").removeClass("alert-danger").addClass("alert-success");
                            $("#alert").css("display", "block");
                            $("#validationAlert").html(msg.msg);

                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });
            } else if (type == 'delete') {

                if ($(this).attr('data-status') == 'block') {
                    res = confirm('Do you really want to block?');
                    if (res === false) {
                        return;
                    }
                } else {
                    res = confirm('Do you really want to unblock?');
                    if (res === false) {
                        return;
                    }
                }

                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            $("#alert").removeClass("alert-success").addClass("alert-danger");
                            $("#alert").css("display", "block");
                            $("#validationAlert").html(msg.msg);
                        } else {
                            $("#alert").removeClass("alert-danger").addClass("alert-success");
                            $("#alert").css("display", "block");
                            $("#validationAlert").html(msg.msg);

                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });
            } else if (type == 'edit') {
                $('#con-edit-modal').modal('show');
                dataArray = JSON.parse($(this).attr('data-array'));
                $('#con-edit-modal #id').val(dataArray.id);
                $('#con-edit-modal .bigLogo').attr('src', dataArray.bigLogo);
                $('#con-edit-modal .smallLogo').attr('src', dataArray.smallLogo);
                $('#con-edit-modal .favIcon').attr('src', dataArray.favIcon);
            } else {

            }
        });
        /*--========================= ( Setting END ) =========================--*/




        /*--========================= ( CMS START ) =========================--*/
        //====Save Banner====//
        $("#saveBannerForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveBannerBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('save');

                    submitForm.find("#fileErr, #forErr").text('');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]);
                        });
                        $.each(msg.errors.for, function (i) {
                            submitForm.find("#forErr").text(msg.errors.for[i]);
                        });
                    } else if (msg.status == 1) {
                        toaster(msg.title, msg.msg, msg.type);
                        submitForm[0].reset();
                        submitForm.find('select').val(['']).trigger('change');
                        submitForm.find('.dropify-clear').trigger('click');
                        $('#cms-banner-listing').DataTable().ajax.reload(null, false);
                    }
                }
            });
        });

        //====Update Banner====//
        $("#updateBannerForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#updateBannerBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('Update');

                    submitForm.find("#fileErr, #forErr").text('');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]);
                        });
                        $.each(msg.errors.for, function (i) {
                            submitForm.find("#forErr").text(msg.errors.for[i]);
                        });
                    } else if (msg.status == 1) {
                        toaster(msg.title, msg.msg, msg.type);
                        $('#cms-banner-listing').DataTable().ajax.reload(null, false);
                    }
                }
            });
        });

        //====Status / Delete Banner====//
        $('body').delegate('#cms-banner-listing .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                reloadDatatable = $('#cms-banner-listing').DataTable();
            if (type == 'status') {

                if ($(this).attr('data-status') == 'block') {
                    var res = confirm('Do you really want to block?');
                    if (res === false) {
                        return;
                    }
                } else {
                    var res = confirm('Do you really want to unblock?');
                    if (res === false) {
                        return;
                    }
                }

                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            toaster(msg.title, msg.msg, msg.type);
                        } else {
                            toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
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
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            toaster(msg.title, msg.msg, msg.type);
                        } else {
                            toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });
            } else if (type == 'edit') {
                id = $('#con-edit-modal');
                id.modal('show');

                dataArray = JSON.parse($(this).attr('data-array'));

                id.find('#id').val(dataArray.id);
                id.find('#for').val([dataArray.for]).trigger('change');
                id.find('img').attr('src', dataArray.image);

            } else {
                id = $('#con-info-modal');
                id.modal('show');

                dataArray = JSON.parse($(this).attr('data-array'));

                id.find('#name').text(dataArray.name);
                id.find('#description').text(dataArray.description);

            }
        });


        //==== (Status / Delete Contact Enquiry) ====//
        $('body').delegate('#cms-contactEnquiry-listing .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                reloadDatatable = $('#cms-contactEnquiry-listing').DataTable();
            if (type == 'delete') {
                res = confirm('Do you really want to delete?');
                if (res === false) {
                    return;
                }

                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            toaster(msg.title, msg.msg, msg.type);
                        } else {
                            toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });
            } else {
                id = $('#con-info-modal');
                id.modal('show');

                dataArray = JSON.parse($(this).attr('data-array'));

                id.find('#name').text(dataArray.name);
                id.find('#email').text(dataArray.email);
                id.find('#phone').text(dataArray.phone);
                id.find('#date').text(dataArray.date);
                id.find('#content').text(dataArray.content);

            }
        });


        //==== ( About Us ) ====//
        $("#updateAboutUsForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#updateAboutUsBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('Update');

                    submitForm.find("#fileErr, #titleErr, #contentErr").text('');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                        $.each(msg.errors.title, function (i) {
                            submitForm.find("#titleErr").text(msg.errors.title[i]);
                        });
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]);
                        });
                        $.each(msg.errors.content, function (i) {
                            submitForm.find("#contentErr").text(msg.errors.content[i]);
                        });
                    } else if (msg.status == 1) {
                        toaster(msg.title, msg.msg, msg.type);
                    }
                }
            });
        });


        //==== ( Contact Us ) ====//
        $("#updateContactUsForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#updateContactUsBtn');

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
                    loader(1);
                    submitBtn.attr("disabled", "disabled").find('span').text('Please wait...');
                },
                success: function (msg) {
                    loader(0);
                    submitBtn.attr("disabled", false).find('span').text('Update');

                    submitForm.find("#phoneErr, #emailErr, #googleMapErr, #addressErr").text('');

                    if (msg.status == 0) {
                        toaster(msg.title, msg.msg, msg.type);
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                        });
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]);
                        });
                        $.each(msg.errors.googleMap, function (i) {
                            submitForm.find("#googleMapErr").text(msg.errors.googleMap[i]);
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]);
                        });
                    } else if (msg.status == 1) {
                        toaster(msg.title, msg.msg, msg.type);
                    }
                }
            });
        });
        /*--========================= ( CMS END ) =========================--*/
    });

})(jQuery);
