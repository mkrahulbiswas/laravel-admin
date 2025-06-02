(function ($) {

    $(function () {
        var pathArray = window.location.pathname.split('/'),
            submitForm, submitBtn, id = '',
            errorClassList = '.form-control, .select2-container--default .select2-selection--single, .dropify-wrapper, .note-editor';

        function commonAction(data) {
            let targetForm = (data.targetId != undefined) ? data.targetId.submitForm : '',
                targetBtn = (data.targetId != undefined) ? data.targetId.submitBtn : '';

            if (data.afterSuccess != undefined) {
                if (data.afterSuccess.resetForm == true) {
                    targetForm[0].reset();
                    targetForm.find('.dropify-clear').trigger('click')
                    targetForm.find('.summernote').summernote('reset');
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
                if (data.swal.type == 'basic') {
                    Swal.fire({
                        ...data.swal.props
                    });
                }
                if (data.swal.type == 'confirm') {
                    Swal.fire({
                        ...data.swal.props
                    }).then((result) => {
                        if (result.isConfirmed) {
                            return true
                        }
                        return false
                    });
                }
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
                            type: data.method,
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
                            },
                            error: function (xhr, textStatus, error) {
                                commonAction({
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
                    } else if (result.dismiss === Swal.DismissReason.cancel) {

                    }
                })
            }
        }


        /*--========================= ( Manage Users START ) =========================--*/
        //---- ( Admin Users Save ) ----//
        $("#saveAdminUsersForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveAdminUsersBtn');

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
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.roleMain, function (i) {
                            submitForm.find("#roleMainErr").text(msg.errors.roleMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.roleSub, function (i) {
                            submitForm.find("#roleSubErr").text(msg.errors.roleSub[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.pinCode, function (i) {
                            submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.state, function (i) {
                            submitForm.find("#stateErr").text(msg.errors.state[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.country, function (i) {
                            submitForm.find("#countryErr").text(msg.errors.country[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateAdminUsersBtn');

            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: new FormData(this),
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
                        $.each(msg.errors.email, function (i) {
                            submitForm.find("#emailErr").text(msg.errors.email[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.phone, function (i) {
                            submitForm.find("#phoneErr").text(msg.errors.phone[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.roleMain, function (i) {
                            submitForm.find("#roleMainErr").text(msg.errors.roleMain[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.roleSub, function (i) {
                            submitForm.find("#roleSubErr").text(msg.errors.roleSub[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.pinCode, function (i) {
                            submitForm.find("#pinCodeErr").text(msg.errors.pinCode[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.state, function (i) {
                            submitForm.find("#stateErr").text(msg.errors.state[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.country, function (i) {
                            submitForm.find("#countryErr").text(msg.errors.country[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.address, function (i) {
                            submitForm.find("#addressErr").text(msg.errors.address[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.file, function (i) {
                            submitForm.find("#fileErr").text(msg.errors.file[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                commonMethod({
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
                commonMethod({
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




        /*--========================= ( Manage Panel START ) =========================--*/
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
        $('body').delegate('#managePanel-manageNav-navType .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-manageNav-navType'),
                data = '';

            if (type == 'status') {
                commonMethod({
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
                commonMethod({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                commonMethod({
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
                if (data.extraData.hasNavSub > 0) {
                    commonAction({
                        swal: {
                            type: 'basic',
                            props: {
                                position: 'center-center',
                                icon: 'warning',
                                title: 'Oops....!',
                                html: 'There some sub nav found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.navSubRoute + '">sub nav</a>',
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                commonMethod({
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
                    id.find("#navMain2 option[data-name='" + data.navMain.name + "']").prop("selected", true).trigger('change');
                }, 1000);
            } else if (type == 'access') {
                data = JSON.parse($(this).attr('data-array'));
                if (data.extraData.hasNavNested > 0) {
                    commonAction({
                        swal: {
                            type: 'basic',
                            props: {
                                position: 'center-center',
                                icon: 'warning',
                                title: 'Oops....!',
                                html: 'There some nested nav found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.navNestedRoute + '">nested nav</a>',
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                commonMethod({
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


        //---- ( Arrange Nav Update ) ----//
        $("#updateArrangeNavForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updateArrangeNavBtn');

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

                    } else {
                        window.location.reload();
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                commonMethod({
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
                        type: 'basic',
                        props: {
                            position: 'center-center',
                            icon: 'warning',
                            title: 'Oops....!',
                            html: 'There some sub role found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.roleSubRoute + '">sub role</a>',
                            showConfirmButton: false,
                            timer: 10000
                        }
                    },
                })
            } else if (type == 'setPermission') {
                data = JSON.parse($(this).attr('data-array'));
                commonMethod({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                                    targetId: $('#managePanel-manageAccess-permissionRoleSub')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                commonMethod({
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
                id.find("#roleMain option[data-name='" + data.roleMain.name + "']").prop("selected", true).trigger('change');
            } else if (type == 'info') {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                id.find('#roleMain').text(data.roleMain.name);
                id.find('#name').text(data.name);
                id.find('#description').text(data.description);
            } else if (type == 'setPermission') {
                data = JSON.parse($(this).attr('data-array'));
                commonMethod({
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


        //---- ( Logo Save ) ----//
        $("#saveLogoForm").submit(function (event) {

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
                        $.each(msg.errors.bigLogo, function (i) {
                            submitForm.find("#bigLogoErr").text(msg.errors.bigLogo[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.smallLogo, function (i) {
                            submitForm.find("#smallLogoErr").text(msg.errors.smallLogo[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.favicon, function (i) {
                            submitForm.find("#faviconErr").text(msg.errors.favicon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#managePanel-quickSettings-logo')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                        $.each(msg.errors.bigLogo, function (i) {
                            submitForm.find("#bigLogoErr").text(msg.errors.bigLogo[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.smallLogo, function (i) {
                            submitForm.find("#smallLogoErr").text(msg.errors.smallLogo[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.favicon, function (i) {
                            submitForm.find("#faviconErr").text(msg.errors.favicon[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#managePanel-quickSettings-logo')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
        $('body').delegate('#managePanel-quickSettings-logo .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#managePanel-quickSettings-logo'),
                data = '';

            if (type == 'default') {
                commonMethod({
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
                commonMethod({
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
                commonMethod({
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
        /*--========================= ( Manage Panel END ) =========================--*/




        /*--========================= ( Property Related START ) =========================--*/
        //---- ( Property Attributes Save ) ----//
        $("#savePropertyAttributesForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#savePropertyAttributesBtn');

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
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.type, function (i) {
                            submitForm.find("#typeErr").text(msg.errors.type[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-propertyAttributes')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

        //---- ( Property Attributes Update ) ----//
        $("#updatePropertyAttributesForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updatePropertyAttributesBtn');

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
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.type, function (i) {
                            submitForm.find("#typeErr").text(msg.errors.type[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-propertyAttributes')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

        //---- ( Property Attributes Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-propertyAttributes .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-propertyAttributes'),
                data = '';

            if (type == 'status') {
                commonMethod({
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
                commonMethod({
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
                commonMethod({
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
                console.log(data);
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#about').val(data.about);
                id.find("#type2").val(data.customizeInText.type.raw).trigger('change');
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                console.log(data);
                id.find('#name').text(data.name);
                id.find('#about').text(data.about);
                id.find('#type').text(data.customizeInText.type.formatted);
            }
        });


        //---- ( Property Types Save ) ----//
        $("#savePropertyTypesForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#savePropertyTypesBtn');

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
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-propertyTypes')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

        //---- ( Property Types Update ) ----//
        $("#updatePropertyTypesForm").submit(function (event) {
            submitForm = $(this);
            submitBtn = $(this).find('#updatePropertyTypesBtn');

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
                        $.each(msg.errors.about, function (i) {
                            submitForm.find("#aboutErr").text(msg.errors.about[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-propertyTypes')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

        //---- ( Property Types Status, Edit, Detail ) ----//
        $('body').delegate('#propertyRelated-propertyTypes .actionDatatable', 'click', function () {
            var type = $(this).attr('data-type'),
                action = $(this).attr('data-action'),
                targetTableId = $('#propertyRelated-propertyTypes'),
                data = '';

            if (type == 'status') {
                commonMethod({
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
                commonMethod({
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
                commonMethod({
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
                console.log(data);
                id.find('#id').val(data.id);
                id.find('#name').val(data.name);
                id.find('#about').val(data.about);
            } else {
                id = $('#con-info-modal');
                id.modal('show');
                data = JSON.parse($(this).attr('data-array'));
                console.log(data);
                id.find('#name').text(data.name);
                id.find('#about').text(data.about);
            }
        });
        /*--========================= ( Property Related END ) =========================--*/

    })
})(jQuery);
