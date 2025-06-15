(function ($) {

    $('#pageLoader').fadeOut(500);
    $('#internalLoader').fadeOut(500);

    $(function () {

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

        $('body').delegate('#updateAdminUsersForm #mainRole, #saveAdminUsersForm #mainRole', 'change', function () {
            let targetId = $(this);
            if (targetId.find(':selected').attr('data-exist') > 0) {
                targetId.closest('form').find('#subRole').closest('.form-element').fadeIn(500);
            } else {
                targetId.closest('form').find('#subRole').closest('.form-element').fadeOut(500);
            }
        })



        $('body').delegate('#permissionCheckAll', 'click', function () {
            if ($(this).attr("data-type") == 'none') {
                $(this).attr("data-type", 'all').text('Check none')
                lcs_on('.lcSwitch');
                $('.lcSwitch').val(1);
            } else if ($(this).attr("data-type") == 'all') {
                $(this).attr("data-type", 'none').text('Check all')
                $('.lcSwitch').val(0);
                lcs_off('.lcSwitch');
            } else {
                $(this).attr("data-type", 'some')
            }
        });

        $('body').delegate('.lcs_switch', 'click', function () {
            var val = $(this).closest('.lcs_wrap').find('.lcSwitch').val();
            if (val == 1) {
                $(this).closest('.lcs_wrap').find('.lcSwitch').val(0);
            } else {
                $(this).closest('.lcs_wrap').find('.lcSwitch').val(1);
            }
        });

        $('body').delegate('#variable .variableItem', 'click', function () {
            var text = $(this).attr('data-variable');
            navigator.clipboard.writeText(text)
            $.toast({
                heading: 'Copied successfully.',
                text: 'Clicked text "' + text + '" copied successfully.',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 3000,
                stack: 0,
                position: 'top-right',
            });
        });
    });

})(jQuery);
