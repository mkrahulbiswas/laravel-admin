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
                                $.each(msg.data.navMain.navMain, function (key, value) {
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
                                $.each(msg.data.navSub.navSub, function (key, value) {
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

    });

})(jQuery);
