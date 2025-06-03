(function ($) {

    $(function () {

        function commonAction(data) {
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

            if (data.swal != undefined) {
                if (data.swal.type == 'basic') {
                    Swal.fire({
                        ...data.swal.props
                    });
                }
            }
        }

        /*--========================= ( Manage Nav START ) =========================--*/
        $('.navTypeDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select Nav Main</option>';
                $('.navMainDDD').text('');
                if ($(this).val() == '') {
                    $('.navMainDDD').append(html);
                } else {
                    $.ajax({
                        url: $(this).attr('data-action') + '/' + $(this).val(),
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
                                }
                            })
                            if (msg.status == 0) {
                                $('.navMainDDD').append(html);
                            } else {
                                $.each(msg.data.navMain, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.navMainDDD').append(html);
                            }
                        }
                    });
                }
            }
        });

        $('.navMainDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select Nav Sub</option>';
                $('.navSubDDD').text('');
                if ($(this).val() == '') {
                    $('.navSubDDD').append(html);
                } else {
                    $.ajax({
                        url: $(this).attr('data-action') + '/' + $(this).val(),
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
                                }
                            })
                            if (msg.status == 0) {
                                $('.navSubDDD').append(html);
                            } else {
                                $.each(msg.data.navSub, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.navSubDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Manage Nav END ) =========================--*/

        /*--========================= ( Manage Access START ) =========================--*/
        $('.roleMainDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select Role Sub</option>';
                $('.roleSubDDD').text('');
                if ($(this).val() == '') {
                    $('.roleSubDDD').append(html);
                } else {
                    $.ajax({
                        url: $(this).attr('data-action') + '/' + $(this).val(),
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
                                }
                            })
                            if (msg.status == 0) {
                                $('.roleSubDDD').append(html);
                            } else {
                                $.each(msg.data.roleSub, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.roleSubDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Manage Access END ) =========================--*/

        /*--========================= ( Property Related START ) =========================--*/
        $('.propertyTypeDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select Role Sub</option>';
                $('.assignBroadDDD').text('');
                if ($(this).val() == '') {
                    $('.assignBroadDDD').append(html);
                } else {
                    $.ajax({
                        url: $(this).attr('data-action') + '/' + $(this).val(),
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
                                }
                            })
                            if (msg.status == 0) {
                                $('.assignBroadDDD').append(html);
                            } else if (msg.status == 2) {
                                commonAction({
                                    swal: {
                                        type: 'basic',
                                        props: {
                                            position: 'center-center',
                                            icon: 'warning',
                                            title: 'Oops....!',
                                            html: 'You have not assign any broad with the selected property type. To set <a class="linkHrefRoute" href="' + msg.redirectTo + '">click me</a>',
                                            showConfirmButton: false,
                                            timer: 10000
                                        }
                                    },
                                })
                            } else {
                                $.each(msg.data.assignBroad, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['broadType']['name'] + '">' + value['broadType']['name'] + '</option>'
                                });
                                $('.assignBroadDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Property Related END ) =========================--*/

    });

})(jQuery);
