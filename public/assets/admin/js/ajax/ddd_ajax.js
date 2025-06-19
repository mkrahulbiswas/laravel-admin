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
                var html = '<option value="">Select main nav</option>';
                $('.mainNavDDD').text('');
                if ($(this).val() == '') {
                    $('.mainNavDDD').append(html);
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
                                $('.mainNavDDD').append(html);
                            } else {
                                $.each(msg.data.mainNav, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.mainNavDDD').append(html);
                            }
                        }
                    });
                }
            }
        });

        $('.mainNavDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select sub nav</option>';
                $('.subNavDDD').text('');
                if ($(this).val() == '') {
                    $('.subNavDDD').append(html);
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
                                $('.subNavDDD').append(html);
                            } else {
                                $.each(msg.data.subNav, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.subNavDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Manage Nav END ) =========================--*/

        /*--========================= ( Manage Access START ) =========================--*/
        $('.mainRoleDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select sub role</option>';
                $('.subRoleDDD').text('');
                if ($(this).val() == '') {
                    $('.subRoleDDD').append(html);
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
                                $('.subRoleDDD').append(html);
                            } else {
                                $.each(msg.data.subRole, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.subRoleDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Manage Access END ) =========================--*/

        /*--========================= ( Customized Alert START ) =========================--*/
        $('.alertTypeDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select alert for</option>';
                $('.alertForDDD').text('');
                if ($(this).val() == '') {
                    $('.alertForDDD').append(html);
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
                                $('.alertForDDD').append(html);
                            } else {
                                $.each(msg.data.alertFor, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.alertForDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Customized Alert END ) =========================--*/

        /*--========================= ( Property Related START ) =========================--*/
        $('.propertyTypeDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select sub role</option>';
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

        $('.mainCategoryDDD').change(function () {
            if ($(this).attr('data-action') != undefined) {
                var html = '<option value="">Select sub role</option>';
                $('.subCategoryDDD').text('');
                if ($(this).val() == '') {
                    $('.subCategoryDDD').append(html);
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
                                $('.subCategoryDDD').append(html);
                            } else {
                                $.each(msg.data.mainCategory, function (key, value) {
                                    html += '<option value="' + value['id'] + '" data-name="' + value['name'] + '">' + value['name'] + '</option>'
                                });
                                $('.subCategoryDDD').append(html);
                            }
                        }
                    });
                }
            }
        });
        /*--========================= ( Property Related END ) =========================--*/

    });

})(jQuery);
