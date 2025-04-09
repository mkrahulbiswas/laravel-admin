$('document').ready(function () {

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

    /*--========================= ( Item START ) =========================--*/
    $('.productDDD').change(function () {
        var html = '<option value="">Select IMEI</option>';
        $('.imeiDDD').text('');
        if ($(this).val() == '') {
            $('.imeiDDD').append(html);
        } else {
            $.ajax({
                url: $(this).attr('data-action') + '/' + $(this).val(),
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                    loader(1);
                },
                success: function (msg) {
                    loader(0);
                    if (msg.status == 0) {
                        $('.imeiDDD').append(html);
                    } else {
                        $.each(msg.data, function (key, value) {
                            html += '<option value="' + value['id'] + '" data-purchasePrice="' + value['purchasePrice'] + '">' + value['imei'] + '</option>'
                        });
                        $('.imeiDDD').append(html);
                    }
                }
            });
        }
    });
    /*--========================= ( Item END ) =========================--*/

    /*--========================= ( Sales Entry START ) =========================--*/
    $('.clientFilterDDD').change(function () {
        var html = '<option value="">Select IMEI</option>';
        $('.salesEntryDDD').text('');
        if ($(this).val() == '') {
            $('.salesEntryDDD').append(html);
        } else {
            $.ajax({
                url: $(this).attr('data-action') + '/' + $(this).val(),
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                    loader(1);
                },
                success: function (msg) {
                    loader(0);
                    if (msg.status == 0) {
                        $('.salesEntryDDD').append(html);
                    } else {
                        $.each(msg.data, function (key, value) {
                            html += '<option value="' + value['id'] + '">' + value['uniqueId'] + '</option>'
                        });
                        $('.salesEntryDDD').append(html);
                    }
                }
            });
        }
    });
    /*--========================= ( Sales Entry END ) =========================--*/

});
