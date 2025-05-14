(function ($) {

    $('#pageLoader').fadeOut(500);
    $('#internalLoader').fadeOut(500);

    $(function () {

        var pathArray = window.location.pathname.split('/'),
            date = new Date();

        // $('.date-picker-month').datepicker({
        //     format: "mm-yyyy",
        //     viewMode: "months",
        //     minViewMode: "months",
        //     autoclose: true,
        // });

        // $('.date-picker-year').datepicker({
        //     format: "yyyy",
        //     viewMode: "years",
        //     minViewMode: "years",
        //     autoclose: true,
        // });

        // $('.date-picker').datepicker({
        //     // format: 'M dd, yyyy',
        //     format: 'dd-mm-yyyy',
        //     autoclose: true,
        // });

        // $('.date-range-picker').daterangepicker({
        //     autoclose: true,
        //     format: 'dd-mm-yyyy',
        //     defaultViewDate: 'today'
        // });

        // $('.time-picker').timepicker({
        //     autoclose: true,
        //     defaultTime: false,
        // });

        // $('.date-range-picker').val(['']).trigger('change');

        // const viewer = new Viewer($('.image'), {
        //     inline: true,
        //     viewed() {
        //         viewer.zoomTo(1);
        //     },
        // });

        let mainPageContent = $('.main-page-content');
        $('.tdFilterBtn').click(function () {
            let targetId = $(this),
                filterClass = targetId.closest(mainPageContent).find('.tdFilterMain');
            if (filterClass.attr('data-filterStatus') === "0") {
                filterClass.attr('data-filterStatus', '1').fadeIn(1000);
            } else {
                filterClass.attr('data-filterStatus', '0').fadeOut(500);
            }
        })
        $('.tdFilterCloseBtn').click(function () {
            $('.tdFilterBtn').trigger('click')
        })



        $('body').delegate('.tdAction .tdActionButton .tdActionButtonToggle', 'click', function () {
            let targetId = $(this)
            $('.tdAction .tdActionButton .tdActionButtonToggle')
                .not(targetId)
                .closest('.tdAction')
                .attr('data-isOpen', false)
                .css({
                    'border-bottom-left-radius': '0.25rem',
                    'border-bottom-right-radius': '0.25rem'
                })
                .find('.tdActionInner')
                .css({
                    'top': '60px',
                    'opacity': '0',
                    'pointer-events': 'none',
                })
                .closest('.tdAction')
                .find('.tdActionButtonToggle a i').attr('class', 'mdi mdi mdi-menu-open')

            if ($(targetId).closest('.tdAction').attr('data-isOpen') === "true") {
                $(targetId).find('a i')
                    .attr('class', 'mdi mdi mdi-menu-open')
                    .closest('.tdAction')
                    .attr('data-isOpen', false)
                    .css({
                        'border-bottom-left-radius': '0.25rem',
                        'border-bottom-right-radius': '0.25rem'
                    })
                    .find('.tdActionInner')
                    .css({
                        'top': '60px',
                        'opacity': '0',
                        'pointer-events': 'none',
                    })
            } else {
                $(targetId).find('a i')
                    .attr('class', 'mdi mdi-close-box-multiple')
                    .closest('.tdAction')
                    .attr('data-isOpen', true)
                    .css({
                        'border-bottom-left-radius': '0px',
                        'border-bottom-right-radius': '0px'
                    })
                    .find('.tdActionInner')
                    .css({
                        'top': '40px',
                        'opacity': '1',
                        'pointer-events': 'auto',
                    })
            }
        })

        $('body').delegate('.npGo span', 'click', function () {
            let targetId = $(this)
            $(targetId).closest('.npGo').fadeOut(500)
            lc_switch('.lcSwitch')
        })

    });

})(jQuery);
