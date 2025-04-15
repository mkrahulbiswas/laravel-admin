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
        $('.filter-table-data-btn').click(function () {
            let targetId = $(this),
                filterClass = targetId.closest(mainPageContent).find('.filter-table-data-main');
            if (filterClass.attr('data-filterStatus') === "0") {
                filterClass.attr('data-filterStatus', '1').fadeIn(1000);
            } else {
                filterClass.attr('data-filterStatus', '0').fadeOut(500);
            }
        })
        $('.filter-table-data-close-btn').click(function () {
            $('.filter-table-data-btn').trigger('click')
        })



        $('body').delegate('.tableActionButton .actionButtonOpen .buttonOpenToggle', 'click', function () {
            let targetId = $(this)
            $('.tableActionButton .actionButtonOpen .buttonOpenToggle')
                .not(targetId)
                .closest('.tableActionButton')
                .attr('data-isOpen', false)
                .css({
                    'border-bottom-left-radius': '0.25rem',
                    'border-bottom-right-radius': '0.25rem'
                })
                .find('.actionButtonInner')
                .css({
                    'top': '60px',
                    'opacity': '0',
                    'pointer-events': 'none',
                })
                .closest('.tableActionButton')
                .find('.buttonOpenToggle a i').attr('class', 'mdi mdi mdi-menu-open')

            if ($(targetId).closest('.tableActionButton').attr('data-isOpen') === "true") {
                $(targetId).find('a i')
                    .attr('class', 'mdi mdi mdi-menu-open')
                    .closest('.tableActionButton')
                    .attr('data-isOpen', false)
                    .css({
                        'border-bottom-left-radius': '0.25rem',
                        'border-bottom-right-radius': '0.25rem'
                    })
                    .find('.actionButtonInner')
                    .css({
                        'top': '60px',
                        'opacity': '0',
                        'pointer-events': 'none',
                    })
            } else {
                $(targetId).find('a i')
                    .attr('class', 'mdi mdi-close-box-multiple')
                    .closest('.tableActionButton')
                    .attr('data-isOpen', true)
                    .css({
                        'border-bottom-left-radius': '0px',
                        'border-bottom-right-radius': '0px'
                    })
                    .find('.actionButtonInner')
                    .css({
                        'top': '40px',
                        'opacity': '1',
                        'pointer-events': 'auto',
                    })
            }
        })

    });

})(jQuery);
