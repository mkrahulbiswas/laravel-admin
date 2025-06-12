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
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subRole, function (i) {
                            submitForm.find("#subRoleErr").text(msg.errors.subRole[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subRole, function (i) {
                            submitForm.find("#subRoleErr").text(msg.errors.subRole[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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




        /*--========================= ( Navigation & Access START ) =========================--*/
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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-navType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-navType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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


        //---- ( Main Nav Save ) ----//
        $("#saveMainNavForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveMainNavBtn');

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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-mainNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateMainNavBtn');

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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-mainNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#accessMainNavBtn');

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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-mainNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                if (data.extraData.hasSubNav > 0) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#saveSubNavBtn');

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
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-subNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateSubNavBtn');

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
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-subNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#accessSubNavBtn');

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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-subNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                    id.find("#mainNav2 option[data-name='" + data.mainNav.name + "']").prop("selected", true).trigger('change');
                }, 1000);
            } else if (type == 'access') {
                data = JSON.parse($(this).attr('data-array'));
                if (data.extraData.hasNestedNav > 0) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#saveNestedNavBtn');

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
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subNav, function (i) {
                            submitForm.find("#subNavErr").text(msg.errors.subNav[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-nestedNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateNestedNavBtn');

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
                        $.each(msg.errors.mainNav, function (i) {
                            submitForm.find("#mainNavErr").text(msg.errors.mainNav[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subNav, function (i) {
                            submitForm.find("#subNavErr").text(msg.errors.subNav[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-nestedNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#accessNestedNavBtn');

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
                                    targetId: $('#adminRelated-navigationAccess-manageSideNav-nestedNav')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateArrangeSideNavBtn');

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

            submitForm = $(this);
            submitBtn = $(this).find('#saveMainRoleBtn');

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
                                    targetId: $('#adminRelated-rolePermission-manageRole-mainRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateMainRoleBtn');

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
                                    targetId: $('#adminRelated-rolePermission-manageRole-mainRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updatePermissionMainRoleBtn');

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
                                    targetId: $('#managePanel-manageAccess-permissionMainRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                            html: 'There some sub role found, please set permission from <a class="linkHrefRoute" href="' + data.extraData.subRoleRoute + '">sub role</a>',
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


        //---- ( Sub Role Save ) ----//
        $("#saveSubRoleForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveSubRoleBtn');

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
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#adminRelated-rolePermission-manageRole-subRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateSubRoleBtn');

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
                        $.each(msg.errors.mainRole, function (i) {
                            submitForm.find("#mainRoleErr").text(msg.errors.mainRole[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#adminRelated-rolePermission-manageRole-subRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updatePermissionSubRoleBtn');

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
                                    targetId: $('#managePanel-manageAccess-permissionSubRole')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
        /*--========================= ( Role & Permission END ) =========================--*/



        /*--========================= ( Quick Setting START ) =========================--*/
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
                                    targetId: $('#adminRelated-quickSetting-siteSetting-logo')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
                                    targetId: $('#adminRelated-quickSetting-siteSetting-logo')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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


        //---- ( Alert Type Save ) ----//
        $("#saveAlertTypeForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#saveAlertTypeBtn');

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
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateAlertTypeBtn');

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
                                    targetId: $('#adminRelated-quickSetting-customizedAlert-alertType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            } else {}
        });
        /*--========================= ( Quick Setting END ) =========================--*/




        /*--========================= ( Property Related START ) =========================--*/
        //---- ( Property Attribute Save ) ----//
        $("#savePropertyAttributeForm").submit(function (event) {

            submitForm = $(this);
            submitBtn = $(this).find('#savePropertyAttributeBtn');

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
                                    targetId: $('#propertyRelated-propertyAttribute')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updatePropertyAttributeBtn');

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
                                    targetId: $('#propertyRelated-propertyAttribute')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#savePropertyTypeBtn');

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
                                    targetId: $('#propertyRelated-propertyType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updatePropertyTypeBtn');

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
                                    targetId: $('#propertyRelated-propertyType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#saveBroadTypeBtn');

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
                                    targetId: $('#propertyRelated-manageBroad-broadType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateBroadTypeBtn');

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
                                    targetId: $('#propertyRelated-manageBroad-broadType')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#saveAssignBroadBtn');

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
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.broadType, function (i) {
                            submitForm.find("#broadTypeErr").text(msg.errors.broadType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-manageBroad-assignBroad')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateAssignBroadBtn');

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
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.broadType, function (i) {
                            submitForm.find("#broadTypeErr").text(msg.errors.broadType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-manageBroad-assignBroad')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#saveManageCategoryBtn');

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
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subCategory, function (i) {
                            submitForm.find("#subCategoryErr").text(msg.errors.subCategory[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('.propertyRelated-propertyCategory-manageCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateManageCategoryBtn');

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
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.subCategory, function (i) {
                            submitForm.find("#subCategoryErr").text(msg.errors.subCategory[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('.propertyRelated-propertyCategory-manageCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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

            submitForm = $(this);
            submitBtn = $(this).find('#saveAssignCategoryBtn');

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
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.assignBroad, function (i) {
                            submitForm.find("#assignBroadErr").text(msg.errors.assignBroad[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-propertyCategory-assignCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
            submitForm = $(this);
            submitBtn = $(this).find('#updateAssignCategoryBtn');

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
                        $.each(msg.errors.mainCategory, function (i) {
                            submitForm.find("#mainCategoryErr").text(msg.errors.mainCategory[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.propertyType, function (i) {
                            submitForm.find("#propertyTypeErr").text(msg.errors.propertyType[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
                        });
                        $.each(msg.errors.assignBroad, function (i) {
                            submitForm.find("#assignBroadErr").text(msg.errors.assignBroad[i]).closest('.form-element').find(errorClassList).addClass('invalid-input');
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
                                    targetId: $('#propertyRelated-propertyCategory-assignCategory')
                                }
                            }
                        })
                    }
                },
                error: function (xhr, textStatus, error) {
                    commonAction({
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
