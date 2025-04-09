$('document').ready(function () {
    var pathArray = window.location.pathname.split('/'),
        submitForm, submitBtn, id = '';


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

    function toaster(title, msg, type) {
        $.toast({
            heading: title,
            text: msg,
            showHideTransition: 'slide',
            icon: type,
            hideAfter: 10000,
            stack: 3,
            position: 'top-right',
        });
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


    //==== (Save Client) ====//
    $("#saveClientForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveClientBtn');

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

                $("#nameErr, #phoneErr, #emailErr, #fileErr, #addressErr, #businessNameErr, #businessEmailErr, #businessAddressErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.phone, function (i) {
                        submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                    });
                    $.each(msg.errors.email, function (i) {
                        submitForm.find("#emailErr").text(msg.errors.email[i]);
                    });
                    $.each(msg.errors.file, function (i) {
                        submitForm.find("#fileErr").text(msg.errors.file[i]);
                    });
                    $.each(msg.errors.address, function (i) {
                        submitForm.find("#addressErr").text(msg.errors.address[i]);
                    });
                    $.each(msg.errors.businessName, function (i) {
                        submitForm.find("#businessNameErr").text(msg.errors.businessName[i]);
                    });
                    $.each(msg.errors.businessEmail, function (i) {
                        submitForm.find("#businessEmailErr").text(msg.errors.businessEmail[i]);
                    });
                    $.each(msg.errors.businessAddress, function (i) {
                        submitForm.find("#businessAddressErr").text(msg.errors.businessAddress[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm.find('.dropify-clear').trigger('click');
                    submitForm[0].reset();
                    submitForm.find('.date-picker').datepicker('update', '');
                }
            }
        });
    });

    //==== (Update Client) ====//
    $("#updateClientForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateClientBtn');

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

                $("#nameErr, #phoneErr, #emailErr, #fileErr, #addressErr, #businessNameErr, #businessEmailErr, #businessAddressErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.phone, function (i) {
                        submitForm.find("#phoneErr").text(msg.errors.phone[i]);
                    });
                    $.each(msg.errors.email, function (i) {
                        submitForm.find("#emailErr").text(msg.errors.email[i]);
                    });
                    $.each(msg.errors.file, function (i) {
                        submitForm.find("#fileErr").text(msg.errors.file[i]);
                    });
                    $.each(msg.errors.address, function (i) {
                        submitForm.find("#addressErr").text(msg.errors.address[i]);
                    });
                    $.each(msg.errors.businessName, function (i) {
                        submitForm.find("#businessNameErr").text(msg.errors.businessName[i]);
                    });
                    $.each(msg.errors.businessEmail, function (i) {
                        submitForm.find("#businessEmailErr").text(msg.errors.businessEmail[i]);
                    });
                    $.each(msg.errors.businessAddress, function (i) {
                        submitForm.find("#businessAddressErr").text(msg.errors.businessAddress[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                }
            }
        });
    });

    //==== (Status / Delete Client) ====// 
    $('body').delegate('#users-client-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            id = $(this).attr('data-id'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#users-client-listing').DataTable();
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




    /*--========================= ( Setting START ) =========================--*/
    //---- ( Save Social Links ) ----//
    $("#saveSocialLinksForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveSocialLinksBtn');

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
                submitBtn.attr("disabled", false).find('span').text('Save');

                submitForm.find("#titleErr, #iconErr, #linkErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.title, function (i) {
                        submitForm.find("#titleErr").text(msg.errors.title[i]);
                    });
                    $.each(msg.errors.icon, function (i) {
                        submitForm.find("#iconErr").text(msg.errors.icon[i]);
                    });
                    $.each(msg.errors.link, function (i) {
                        submitForm.find("#linkErr").text(msg.errors.link[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    submitForm.find('select').val(['']).trigger('change');
                    submitForm.find('.dropify-clear').trigger('click');
                    $('#setting-socialLinks-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Update Social Links ) ----//
    $("#updateSocialLinksForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateSocialLinksBtn');

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

                submitForm.find("#titleErr, #iconErr, #linkErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.title, function (i) {
                        submitForm.find("#titleErr").text(msg.errors.title[i]);
                    });
                    $.each(msg.errors.icon, function (i) {
                        submitForm.find("#iconErr").text(msg.errors.icon[i]);
                    });
                    $.each(msg.errors.link, function (i) {
                        submitForm.find("#linkErr").text(msg.errors.link[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#setting-socialLinks-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Status / Delete Social Links ) ----//
    $('body').delegate('#setting-socialLinks-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#setting-socialLinks-listing').DataTable();
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
            id.find('#title').val(dataArray.title);
            id.find('#icon').val(dataArray.icon);
            id.find('img').attr('src', dataArray.image);
            id.find('#link').val(dataArray.link);

        } else {
            id = $('#con-detail-modal');
            id.modal('show');

            dataArray = JSON.parse($(this).attr('data-array'));

            id.find('#name').text(dataArray.name);
            id.find('#description').text(dataArray.description);

        }
    });


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


    //====Save Units====//
    $("#saveUnitsForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveUnitsBtn');

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

                submitForm.find("#nameErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    $('#setting-units-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //====Update Units====//
    $("#updateUnitsForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateUnitsBtn');

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

                submitForm.find("#nameErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#setting-units-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //====Status / Delete Units====// 
    $('body').delegate('#setting-units-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#setting-units-listing').DataTable();
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
            id.find('#name').val(dataArray.name);

        } else {

        }
    });
    /*--========================= ( Setting END ) =========================--*/




    /*--========================= ( Manage Product START ) =========================--*/
    //---- ( Save Category ) ----//
    $("#saveCategoryForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveCategoryBtn');

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

                submitForm.find("#nameErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    $('#manageProduct-category-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Update Category ) ----//
    $("#updateCategoryForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateCategoryBtn');

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

                submitForm.find("#nameErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#manageProduct-category-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Status / Delete Category ) ----//
    $('body').delegate('#manageProduct-category-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#manageProduct-category-listing').DataTable();
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
        } else if (type == 'display') {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.value) {
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
                }
            })
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
            id.find('#name').val(dataArray.name);

        } else {

        }
    });



    //---- ( Save Product ) ----//
    $("#saveProductForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveProductBtn');

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

                submitForm.find("#nameErr, #unitsErr, #categoryErr, #priceErr, #discountErr, #priceAfterDiscountErr, #gstErr, #priceAfterGstErr, #quantityErr, #payModeErr, #fileErr, #descriptionErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.units, function (i) {
                        submitForm.find("#unitsErr").text(msg.errors.units[i]);
                    });
                    $.each(msg.errors.category, function (i) {
                        submitForm.find("#categoryErr").text(msg.errors.category[i]);
                    });
                    $.each(msg.errors.price, function (i) {
                        submitForm.find("#priceErr").text(msg.errors.price[i]);
                    });
                    $.each(msg.errors.discount, function (i) {
                        submitForm.find("#discountErr").text(msg.errors.discount[i]);
                    });
                    $.each(msg.errors.priceAfterDiscount, function (i) {
                        submitForm.find("#priceAfterDiscountErr").text(msg.errors.priceAfterDiscount[i]);
                    });
                    $.each(msg.errors.gst, function (i) {
                        submitForm.find("#gstErr").text(msg.errors.gst[i]);
                    });
                    $.each(msg.errors.priceAfterGst, function (i) {
                        submitForm.find("#priceAfterGstErr").text(msg.errors.priceAfterGst[i]);
                    });
                    $.each(msg.errors.quantity, function (i) {
                        submitForm.find("#quantityErr").text(msg.errors.quantity[i]);
                    });
                    $.each(msg.errors.payMode, function (i) {
                        submitForm.find("#payModeErr").text(msg.errors.payMode[i]);
                    });
                    $.each(msg.errors.file, function (i) {
                        submitForm.find("#fileErr").text(msg.errors.file[i]);
                    });
                    $.each(msg.errors.description, function (i) {
                        submitForm.find("#descriptionErr").text(msg.errors.description[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    submitForm.find('.dropify-clear').trigger('click');
                    submitForm.find('#description').summernote('reset');
                    submitForm.find('select').val(['']).trigger('change');
                }
            }
        });
    });

    //---- ( Update Product ) ----//
    $("#updateProductForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateProductBtn');

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

                submitForm.find("#nameErr, #unitsErr, #categoryErr, #priceErr, #discountErr, #priceAfterDiscountErr, #gstErr, #priceAfterGstErr, #quantityErr, #payModeErr, #fileErr, #descriptionErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.units, function (i) {
                        submitForm.find("#unitsErr").text(msg.errors.units[i]);
                    });
                    $.each(msg.errors.category, function (i) {
                        submitForm.find("#categoryErr").text(msg.errors.category[i]);
                    });
                    $.each(msg.errors.price, function (i) {
                        submitForm.find("#priceErr").text(msg.errors.price[i]);
                    });
                    $.each(msg.errors.discount, function (i) {
                        submitForm.find("#discountErr").text(msg.errors.discount[i]);
                    });
                    $.each(msg.errors.priceAfterDiscount, function (i) {
                        submitForm.find("#priceAfterDiscountErr").text(msg.errors.priceAfterDiscount[i]);
                    });
                    $.each(msg.errors.gst, function (i) {
                        submitForm.find("#gstErr").text(msg.errors.gst[i]);
                    });
                    $.each(msg.errors.priceAfterGst, function (i) {
                        submitForm.find("#priceAfterGstErr").text(msg.errors.priceAfterGst[i]);
                    });
                    $.each(msg.errors.quantity, function (i) {
                        submitForm.find("#quantityErr").text(msg.errors.quantity[i]);
                    });
                    $.each(msg.errors.payMode, function (i) {
                        submitForm.find("#payModeErr").text(msg.errors.payMode[i]);
                    });
                    $.each(msg.errors.file, function (i) {
                        submitForm.find("#fileErr").text(msg.errors.file[i]);
                    });
                    $.each(msg.errors.description, function (i) {
                        submitForm.find("#descriptionErr").text(msg.errors.description[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                }
            }
        });
    });

    //---- ( Update Display Product ) ----//
    $("#updateDisplayProductForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateDisplayProductBtn');

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

                submitForm.find("#featuredErr, #topTrendingErr, #hotDealsErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.featured, function (i) {
                        submitForm.find("#featuredErr").text(msg.errors.featured[i]);
                    });
                    $.each(msg.errors.topTrending, function (i) {
                        submitForm.find("#topTrendingErr").text(msg.errors.topTrending[i]);
                    });
                    $.each(msg.errors.hotDeals, function (i) {
                        submitForm.find("#hotDealsErr").text(msg.errors.hotDeals[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                }

                $('#manageProduct-product-listing').DataTable().ajax.reload(null, false);
            }
        });
    });

    //---- ( Status / Delete Product ) ----//
    $('body').delegate('#manageProduct-product-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#manageProduct-product-listing').DataTable();
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
        } else if (type == 'display') {
            let id = $('#con-edit-modal');
            id.modal('show');

            dataArray = JSON.parse($(this).attr('data-array'));

            id.find('#id').val(dataArray.id);
            id.find('#featured').val(dataArray.featured).trigger('change');
            id.find('#topTrending').val(dataArray.topTrending).trigger('change');
            id.find('#hotDeals').val(dataArray.hotDeals).trigger('change');
        } else if (type == 'delete') {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.value) {
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
                }
            })
        } else if (type == 'edit') {
            let id = $('#con-edit-modal');
            id.modal('show');

            dataArray = JSON.parse($(this).attr('data-array'));

            id.find('#id').val(dataArray.id);
            id.find('#name').val(dataArray.name);
        } else {

        }
    });


    //---- ( Save Product Image ) ----//
    $("#saveProductImageForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveProductImageBtn');

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

                submitForm.find("#fileErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.file, function (i) {
                        submitForm.find("#fileErr").text(msg.errors.file[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#manageProduct-productImage-listing').DataTable().ajax.reload(null, false);
                    submitForm.find('.dropify-clear').trigger('click');
                }
            }
        });
    });

    //---- ( Status / Delete Product ) ----//
    $('body').delegate('#manageProduct-productImage-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#manageProduct-productImage-listing').DataTable();
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
        } else {

        }
    });
    /*--========================= ( Manage Product END ) =========================--*/




    /*--========================= ( Manage Orders START ) =========================--*/
    //---- ( Update Status ) ----//
    $("#updateStatusForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateStatusBtn');

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

                submitForm.find("#statusErr, #reasonErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.status, function (i) {
                        submitForm.find("#statusErr").text(msg.errors.status[i]);
                    });
                    $.each(msg.errors.reason, function (i) {
                        submitForm.find("#reasonErr").text(msg.errors.reason[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                }

                $('#manageOrders-orders-listing').DataTable().ajax.reload(null, false);
            }
        });
    });

    //---- ( Status / Delete Orders ) ----//
    $('body').delegate('#manageOrders-orders-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#manageOrders-orders-listing').DataTable();
        if (type == 'status') {
            let id = $('#con-edit-modal');
            id.modal('show');

            dataArray = JSON.parse($(this).attr('data-array'));

            id.find('#id').val(dataArray.id);
            id.find('#status').val(dataArray.status).trigger('change');
            id.find('#reason').val(dataArray.reason);
        } else {

        }
    });
    /*--========================= ( Manage Orders END ) =========================--*/




    /*--========================= ( Dashboard START ) =========================--*/
    //---- ( Status / Delete Product Info ) ----//
    $("#detailProductInfoForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#detailProductInfoBtn');

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
                submitBtn.attr("disabled", false).find('span').text('Get Info');

                $("#productErr, #imeiErr").text('');

                var html = '';

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.product, function (i) {
                        submitForm.find("#productErr").text(msg.errors.product[i]);
                    });
                    $.each(msg.errors.imei, function (i) {
                        submitForm.find("#imeiErr").text(msg.errors.imei[i]);
                    });
                } else if (msg.status == 1) {
                    html += '<div class="widget-bg-color-icon card-box">';
                    html += '<div class="row">';
                    html += '<div class="col-md-12" style="padding: 5px 0;">';
                    html += '<span><b>Brand/Model: </b></span>';
                    html += '<span>' + msg.data.product + '</span>';
                    html += '</div>';
                    html += '<div class="col-md-12" style="padding: 5px 0;">';
                    html += '<span><b>Price(D): </b></span>';
                    html += '<span>' + msg.data.dummyPrice + '</span>';
                    html += '</div>';
                    html += '<div class="col-md-12" style="padding: 5px 0;">';
                    html += '<span><b>IMEI: </b></span>';
                    html += '<span>' + msg.data.imei + '</span>';
                    html += '</div>';
                    html += '<div class="col-md-12" style="padding: 5px 0;">';
                    html += '<span><b>Dealer: </b></span>';
                    html += '<span>' + msg.data.dealer + '</span>';
                    html += '</div>';
                    html += '<div class="col-md-12" style="padding: 5px 0;">';
                    html += '<span><b>Variant: </b></span>';
                    html += '<span>' + msg.data.variant + '</span>';
                    html += '</div>';
                    html += '<div class="col-md-12" style="padding: 5px 0;">';
                    html += '<span><b>Sell To: </b></span>';
                    html += '<span>' + msg.data.saleTo + '</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    toaster(msg.title, msg.msg, msg.type);

                    setTimeout(function () {
                        Swal.fire({
                            title: "<i>Detail View</i>",
                            html: html,
                            confirmButtonText: "Close",
                            buttons: true,
                            icon: 'success',
                        });
                    }, 1000);
                }
            }
        });
    });
    /*--========================= ( Dashboard END ) =========================--*/




    /*--========================= ( Setup Admin START ) =========================--*/
    //---- ( Role Add ) ----//
    $('#saveRoleForm').submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveRoleBtn');

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
                submitBtn.attr("disabled", false).find('span').text('Save');
                submitForm.find("#roleErr, #descriptionErr").text('');

                if (msg.status == 0) {
                    $.each(msg.errors.role, function (i) {
                        submitForm.find("#roleErr").text(msg.errors.role[i]);
                    });
                    $.each(msg.errors.description, function (i) {
                        submitForm.find("#descriptionErr").text(msg.errors.description[i]);
                    });
                    toaster(msg.title, msg.msg, msg.type);
                } else {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    $('#setupAdmin-role-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Role Update ) ----//
    $("#updateRoleForm").submit(function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateRoleBtn');

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

                submitForm.find("#roleErr, #descriptionErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.role, function (i) {
                        submitForm.find("#roleErr").text(msg.errors.role[i]);
                    });
                    $.each(msg.errors.description, function (i) {
                        submitForm.find("#descriptionErr").text(msg.errors.description[i]);
                    });

                } else {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#setupAdmin-role-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Role Status, Edit, Detail ) ----//
    $('body').delegate('#setupAdmin-role-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            res = '',
            action = $(this).attr('data-action'),
            reloadDatatable = $('#setupAdmin-role-listing').DataTable(),
            data = '';

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
            data = JSON.parse($(this).attr('data-array'));
            id.find('#id').val(data.id);
            id.find('#role').val(data.role);
            id.find('#description').val(data.description);
        } else {
            id = $('#con-detail-modal');
            id.modal('show');
            data = JSON.parse($(this).attr('data-array'));
            id.find('#role').text(data.role);
            id.find('#description').text(data.description);
        }
    });


    //---- ( Permission Update ) ----//
    $("#updatePermissionForm").submit(function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updatePermissionBtn');

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
                    $('#setupAdmin-permission-listing').DataTable().ajax.reload(null, false);
                    setTimeout(() => {
                        $('.checkbox').lc_switch();
                    }, 3000);
                }
            }
        });
    });


    //---- ( Main Menu Add ) ----//
    $('#saveMainMenuForm').submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveMainMenuBtn');

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
                submitBtn.attr("disabled", false).find('span').text('Save');
                submitForm.find("#nameErr, #iconErr").text('');

                if (msg.status == 0) {
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.icon, function (i) {
                        submitForm.find("#iconErr").text(msg.errors.icon[i]);
                    });
                    toaster(msg.title, msg.msg, msg.type);
                } else {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    $('#setupAdmin-mainMenu-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Main Menu Update ) ----//
    $("#updateMainMenuForm").submit(function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateMainMenuBtn');

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

                submitForm.find("#nameErr, #iconErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.icon, function (i) {
                        submitForm.find("#iconErr").text(msg.errors.icon[i]);
                    });
                } else {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#setupAdmin-mainMenu-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Main Menu Status, Edit, Detail ) ----//
    $('body').delegate('#setupAdmin-mainMenu-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            res = '',
            action = $(this).attr('data-action'),
            reloadDatatable = $('#setupAdmin-mainMenu-listing').DataTable(),
            data = '';

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
            id = $('#con-edit-modal-mainMenu');
            id.modal('show');
            data = JSON.parse($(this).attr('data-array'));
            id.find('#id').val(data.id);
            id.find('#name').val(data.name);
            id.find('#icon').val(data.icon);
        } else {}
    });


    //---- ( Sub Menu Add ) ----//
    $('#saveSubMenuForm').submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveSubMenuBtn');

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
                submitBtn.attr("disabled", false).find('span').text('Save');
                submitForm.find("#mainMenuErr, #nameErr, #addActionErr, #editActionErr, #detailsActionErr, #deleteActionErr, #statusActionErr, #otherActionErr").text('');

                if (msg.status == 0) {
                    $.each(msg.errors.mainMenu, function (i) {
                        submitForm.find("#mainMenuErr").text(msg.errors.mainMenu[i]);
                    });
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.addAction, function (i) {
                        submitForm.find("#addActionErr").text(msg.errors.addAction[i]);
                    });
                    $.each(msg.errors.editAction, function (i) {
                        submitForm.find("#editActionErr").text(msg.errors.editAction[i]);
                    });
                    $.each(msg.errors.detailsAction, function (i) {
                        submitForm.find("#detailsActionErr").text(msg.errors.detailsAction[i]);
                    });
                    $.each(msg.errors.deleteAction, function (i) {
                        submitForm.find("#deleteActionErr").text(msg.errors.deleteAction[i]);
                    });
                    $.each(msg.errors.statusAction, function (i) {
                        submitForm.find("#statusActionErr").text(msg.errors.statusAction[i]);
                    });
                    $.each(msg.errors.otherAction, function (i) {
                        submitForm.find("#otherActionErr").text(msg.errors.otherAction[i]);
                    });
                    toaster(msg.title, msg.msg, msg.type);
                } else {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    submitForm.find('select').val(['']).trigger('change');
                    $('#setupAdmin-subMenu-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Sub Menu Update ) ----//
    $("#updateSubMenuForm").submit(function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateSubMenuBtn');

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

                submitForm.find("#nameErr, #iconErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.name, function (i) {
                        submitForm.find("#nameErr").text(msg.errors.name[i]);
                    });
                    $.each(msg.errors.icon, function (i) {
                        submitForm.find("#iconErr").text(msg.errors.icon[i]);
                    });
                } else {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#setupAdmin-subMenu-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //---- ( Sub Menu Status, Edit, Detail ) ----//
    $('body').delegate('#setupAdmin-subMenu-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            res = '',
            action = $(this).attr('data-action'),
            reloadDatatable = $('#setupAdmin-subMenu-listing').DataTable(),
            data = '';

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
            id = $('#con-edit-modal-subMenu');
            id.modal('show');
            data = JSON.parse($(this).attr('data-array'));
            id.find('#id').val(data.id);
            id.find('#mainMenu').val(data.mainMenuId).trigger('change');
            id.find('#name').val(data.name);
            id.find('#addAction').val(data.addAction).trigger('change');
            id.find('#editAction').val(data.editAction).trigger('change');
            id.find('#detailsAction').val(data.detailsAction).trigger('change');
            id.find('#deleteAction').val(data.deleteAction).trigger('change');
            id.find('#statusAction').val(data.statusAction).trigger('change');
            id.find('#otherAction').val(data.otherAction).trigger('change');
        } else {
            id = $('#con-detail-modal-subMenu');
            id.modal('show');
            data = JSON.parse($(this).attr('data-array'));
            console.log(data);
            id.find('#mainMenu').text(data.mainMenu);
            id.find('#subMenu').text(data.name);
            id.find('#link').text(data.linkTo);
            id.find('#lastSegment').text(data.lastSegment);
            id.find('#addAction').html((data.addAction == 0) ? '<span class="text-danger">NO</span>' : '<span class="text-success">YES</span>');
            id.find('#editAction').html((data.editAction == 0) ? '<span class="text-danger">NO</span>' : '<span class="text-success">YES</span>');
            id.find('#detailsAction').html((data.detailsAction == 0) ? '<span class="text-danger">NO</span>' : '<span class="text-success">YES</span>');
            id.find('#deleteAction').html((data.deleteAction == 0) ? '<span class="text-danger">NO</span>' : '<span class="text-success">YES</span>');
            id.find('#statusAction').html((data.statusAction == 0) ? '<span class="text-danger">NO</span>' : '<span class="text-success">YES</span>');
            id.find('#otherAction').html((data.otherAction == 0) ? '<span class="text-danger">NO</span>' : '<span class="text-success">YES</span>');
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
    /*--========================= ( Setup Admin END ) =========================--*/





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
            id = $('#con-detail-modal');
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
            id = $('#con-detail-modal');
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


    //==== ( Return Refund ) ====//
    $("#updateReturnRefundForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateReturnRefundBtn');

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

                submitForm.find("#returnErr, #refundErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.return, function (i) {
                        submitForm.find("#returnErr").text(msg.errors.return[i]);
                    });
                    $.each(msg.errors.refund, function (i) {
                        submitForm.find("#refundErr").text(msg.errors.refund[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                }
            }
        });
    });



    //==== ( Save Faq ) ====//
    $("#saveFaqForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#saveFaqBtn');

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

                submitForm.find("#questionErr, #answerErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.question, function (i) {
                        submitForm.find("#questionErr").text(msg.errors.question[i]);
                    });
                    $.each(msg.errors.answer, function (i) {
                        submitForm.find("#answerErr").text(msg.errors.answer[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    submitForm[0].reset();
                    $('#cms-faq-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //==== ( Update Faq ) ====//
    $("#updateFaqForm").submit(function (event) {

        submitForm = $(this);
        submitBtn = $(this).find('#updateFaqBtn');

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

                submitForm.find("#questionErr, #answerErr").text('');

                if (msg.status == 0) {
                    toaster(msg.title, msg.msg, msg.type);
                    $.each(msg.errors.question, function (i) {
                        submitForm.find("#questionErr").text(msg.errors.question[i]);
                    });
                    $.each(msg.errors.answer, function (i) {
                        submitForm.find("#answerErr").text(msg.errors.answer[i]);
                    });
                } else if (msg.status == 1) {
                    toaster(msg.title, msg.msg, msg.type);
                    $('#cms-faq-listing').DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    //==== ( Status / Delete Faq ) ====// 
    $('body').delegate('#cms-faq-listing .actionDatatable', 'click', function () {
        var type = $(this).attr('data-type'),
            action = $(this).attr('data-action'),
            reloadDatatable = $('#cms-faq-listing').DataTable();
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
            id.find('#question').val(dataArray.question);
            id.find('#answer').val(dataArray.answer);

        } else {
            id = $('#con-detail-modal');
            id.modal('show');

            dataArray = JSON.parse($(this).attr('data-array'));

            id.find('#question').text(dataArray.question);
            id.find('#answer').text(dataArray.answer);

        }
    });
    /*--========================= ( CMS END ) =========================--*/
});