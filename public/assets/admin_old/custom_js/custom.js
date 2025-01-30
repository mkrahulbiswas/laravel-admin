$(document).ready(function () {

    var pathArray = window.location.pathname.split('/'),
        date = new Date();

    // $("#board").select2({
    //   	tags: false,
    //   	placeholder: "Select Board"
    // });

    $('.date-picker-month').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
    });

    $('.date-picker-year').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
    });

    $('.date-picker').datepicker({
        // format: 'M dd, yyyy',
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    $('.date-range-picker').daterangepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        defaultViewDate: 'today'
    });

    $('.time-picker').timepicker({
        autoclose: true,
        defaultTime: false,
    });

    $('.date-range-picker').val(['']).trigger('change');



    // const viewer = new Viewer($('.image'), {
    //     inline: true,
    //     viewed() {
    //         viewer.zoomTo(1);
    //     },
    // });



    /*-------Add Role--------*/
    $('#AddRole #role_id').change(function () {
        $('#AddRole #role').val($(this).children('option:selected').text());
    });


    $('#saveStandardInstructionsForm, #updateStandardInstructionsForm, #saveMainStockForm, #saveMainStockBtn, #saveStockRequestForm, #updateStockRequestForm').find('#item').change(function () {
        $(this).closest('form').find('#typeOfUnits').val($(this).find('option:selected').attr('data-unit'));
    });



    /*---- ( Product Management Start ) ----*/
    var id = $('#saveProductForm, #updateProductForm');
    id.find('#discount, #price, #gst').on('keyup change', function () {
        var targetId = $(this).closest('form'),
            price = parseFloat((targetId.find('#price').val() == null || targetId.find('#price').val() == '') ? 0 : targetId.find('#price').val()),
            discount = parseFloat((targetId.find('#discount').val() == null || targetId.find('#discount').val() == '') ? 0 : targetId.find('#discount').val()),
            gst = parseFloat((targetId.find('#gst').val() == null || targetId.find('#gst').val() == '') ? 0 : targetId.find('#gst').val()),
            priceAfterGst = 0,
            priceAfterDiscount = 0;

        priceAfterDiscount = price + discount;
        priceAfterGst = priceAfterDiscount + ((priceAfterDiscount * gst) / 100);
        targetId.find('#priceAfterDiscount').val(priceAfterDiscount)
        targetId.find('#priceAfterGst').val(priceAfterGst.toFixed(2))
    })
    /*---- ( Product Management End ) ----*/


    /*---- ( Orders Management Start ) ----*/
    var id = $('#updateStatusForm');
    id.find('#status').on('change', function () {
        var targetId = $(this).closest('form'),
            status = targetId.find('#status').val();

        if (status == 'REJECTED' || status == 'CANCELED') {
            targetId.find('#reason').closest('.form-group').css({
                'display': 'block'
            });
            targetId.find('#reason').closest('.form-group').val('');
        } else {
            targetId.find('#reason').closest('.form-group').css({
                'display': 'none'
            });
            targetId.find('#reason').closest('.form-group').val('');
        }
    })
    /*---- ( Orders Management End ) ----*/


    $('.mainPickUp .setWidthPickUp').css({
        "width": $('.mainPickUp .sibPickUp .middlePickUp .middleTablePickUp tfoot tr:nth-child(6) td .setWidthPickUp').width(),
        'display': "block"
    });

});