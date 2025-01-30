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

    function toaster(title, msg, type) {
        $.toast({
            heading: title,
            text: msg,
            showHideTransition: 'slide',
            icon: type,
            hideAfter: 10000,
            stack: 1,
            position: 'top-right',
        });
    }

    /*--========================= ( Customize Button START ) =========================--*/
    $('#filterCustomizeButtonForm').find('#buttonTypeFilter, #buttonStatusFilter, #buttonFromDateFilter, #buttonToDateFilter, .filterCustomizeButtonBtn').on('change click', function () {
        var formId = $('#filterCustomizeButtonForm'),
            dataTableId = $('#customizeAdmin-button-listing'),

            buttonType = $("#buttonTypeFilter").val(),
            buttonStatus = $("#buttonStatusFilter").val(),
            fromDate = $("#buttonFromDateFilter").val(),
            toDate = $("#buttonToDateFilter").val(),

            action = $(this).closest('form').attr('action').split('/'),
            newUrl = action[action.length - 3] + '/' + action[action.length - 2] + "/ajaxGetList?buttonType=" + buttonType + "&buttonStatus=" + buttonStatus + "&fromDate=" + fromDate + "&toDate=" + toDate;
        if ($(this).attr('title') == 'Reload') {
            $(this).closest(formId).find("#buttonFromDateFilter, #buttonToDateFilter, #buttonTypeFilter, #buttonStatusFilter").val(['']).trigger('change');
            newUrl = action[action.length - 3] + '/' + action[action.length - 2] + "/ajaxGetList?buttonType=" + '' + "&buttonStatus=" + '' + "&fromDate=" + '' + "&toDate=" + '';
            dataTableId.DataTable().ajax.url(newUrl).load();
        } else if ($(this).attr('title') == 'Search') {
            dataTableId.DataTable().ajax.url(newUrl).load();
        } else {
            dataTableId.DataTable().ajax.url(newUrl).load();
        }
    });
    /*--========================= ( Customize Button END ) =========================--*/



    /*--========================= ( CMS Management START ) =========================--*/
    //------ ( Banner )
    $('#filterBannerForm').find('#forFilter, .filterBannerBtn').on('change click', function () {
        var formId = $(this).closest('form'),
            dataTableId = $('#cms-banner-listing'),

            forBanner = $("#forFilter").val(),

            action = $(this).closest('form').attr('action').split('/'),
            newUrl = action[action.length - 2] + "/ajaxGetList?for=" + forBanner;
        if ($(this).attr('title') == 'Reload') {
            $(this).closest(formId).find("select").val(['']).trigger('change');
            newUrl = action[action.length - 2] + "/ajaxGetList?for=" + '';
            dataTableId.DataTable().ajax.url(newUrl).load();
        } else if ($(this).attr('title') == 'Search') {
            dataTableId.DataTable().ajax.url(newUrl).load();
        } else {
            dataTableId.DataTable().ajax.url(newUrl).load();
        }
    });
    /*--========================= ( CMS Management END ) =========================--*/



    /*--========================= ( CMS Manege Orders START ) =========================--*/
    //------ ( Orders )
    $('#filterOrdersForm').find('#payModeFilter, #statusFilter, .filterOrdersBtn').on('change click', function () {
        var formId = $(this).closest('form'),
            dataTableId = $('#manageOrders-orders-listing'),

            payMode = $("#payModeFilter").val(),
            status = $("#statusFilter").val(),

            action = $(this).closest('form').attr('action').split('/'),
            newUrl = action[action.length - 2] + "/ajaxGetList?payMode=" + payMode + "&status=" + status;
        if ($(this).attr('title') == 'Reload') {
            $(this).closest(formId).find("select").val(['']).trigger('change');
            newUrl = action[action.length - 2] + "/ajaxGetList?payMode=" + '' + "&status=" + '';
            dataTableId.DataTable().ajax.url(newUrl).load();
        } else if ($(this).attr('title') == 'Search') {
            dataTableId.DataTable().ajax.url(newUrl).load();
        } else {
            dataTableId.DataTable().ajax.url(newUrl).load();
        }
    });
    /*--========================= ( CMS Manege Orders END ) =========================--*/

});