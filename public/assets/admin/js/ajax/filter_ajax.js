(function ($) {

    $(function () {

        function commonAction(data) {
            let targetForm = (data.targetId != undefined) ? data.targetId.submitForm : '',
                actionType = (data.targetId != undefined) ? data.targetId.actionType : '';

            if (data.resetFormFields != undefined) {
                if (data.resetFormFields.selectPicker != undefined) {
                    targetForm.find('.selectPicker').selectpicker('val', '');
                }
                if (data.resetFormFields.selectTwo != undefined) {
                    targetForm.find('.selectTwo').val(['']).trigger('change');
                    // targetForm.find('.selectTwo').select2('reset');
                }
            }

            if (data.filterApply != undefined) {
                let numberOfFilter = 0;
                $.each(targetForm.serializeArray(), function (i, field) {
                    if (field.name != '_token' && field.value != '') {
                        numberOfFilter += 1;
                    }
                })
                if (actionType == 'Reload') {
                    $('#filter-applied-count').addClass('d-none').text('')
                } else {
                    $('#filter-applied-count').removeClass('d-none').text((numberOfFilter == 0) ? '' : numberOfFilter)
                }
            }

            if (data.dataTable != undefined) {
                if (data.dataTable.load != undefined) {
                    data.dataTable.load.targetId.DataTable().ajax.url(data.dataTable.load.url).load();
                }
            }
        }

        /*--========================= ( Manage Nav START ) =========================--*/
        //------ ( Nav Type )
        $('#filterNavTypeForm').find('#statusFilter, .filterNavTypeBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageNav-navType'),

                status = formId.find("#statusFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status;
            if ($(this).attr('title') == 'Reload') {
                commonAction({
                    targetId: {
                        submitForm: formId,
                    },
                    resetFormFields: {
                        selectPicker: {},
                        selectTwo: {},
                    }
                })
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '';
            }
            commonAction({
                targetId: {
                    submitForm: formId,
                    actionType: $(this).attr('title'),
                },
                dataTable: {
                    load: {
                        targetId: dataTableId,
                        url: newUrl,
                    }
                },
                filterApply: {}
            })
        });

        //------ ( Nav Main )
        $('#filterNavMainForm').find('#navTypeFilter, #statusFilter, .filterNavMainBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageNav-navMain'),

                status = formId.find("#statusFilter").val(),
                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&navType=" + navType;
            if ($(this).attr('title') == 'Reload') {
                commonAction({
                    targetId: {
                        submitForm: formId,
                    },
                    resetFormFields: {
                        selectPicker: {},
                        selectTwo: {},
                    }
                })
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&navType=" + '';
            }
            commonAction({
                targetId: {
                    submitForm: formId,
                    actionType: $(this).attr('title'),
                },
                dataTable: {
                    load: {
                        targetId: dataTableId,
                        url: newUrl,
                    }
                },
                filterApply: {}
            })
        });

        //------ ( Nav Sub )
        $('#filterNavSubForm').find('#navTypeFilter, #navMainFilter, #statusFilter, .filterNavSubBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageNav-navSub'),

                status = formId.find("#statusFilter").val(),
                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                navMain = (formId.find("#navMainFilter").val() == '' || formId.find("#navMainFilter").val() == null) ? '' : formId.find("#navMainFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&navType=" + navType + "&navMain=" + navMain;
            if ($(this).attr('title') == 'Reload') {
                commonAction({
                    targetId: {
                        submitForm: formId,
                    },
                    resetFormFields: {
                        selectPicker: {},
                        selectTwo: {},
                    }
                })
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&navType=" + '' + "&navMain=" + '';
            }
            commonAction({
                targetId: {
                    submitForm: formId,
                    actionType: $(this).attr('title'),
                },
                dataTable: {
                    load: {
                        targetId: dataTableId,
                        url: newUrl,
                    }
                },
                filterApply: {}
            })
        });

        //------ ( Nav Nested )
        $('#filterNavNestedForm').find('#navTypeFilter, #navMainFilter, #navSubFilter, #statusFilter, .filterNavNestedBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageNav-navNested'),

                status = formId.find("#statusFilter").val(),
                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                navMain = (formId.find("#navMainFilter").val() == '' || formId.find("#navMainFilter").val() == null) ? '' : formId.find("#navMainFilter").val(),
                navSub = (formId.find("#navSubFilter").val() == '' || formId.find("#navSubFilter").val() == null) ? '' : formId.find("#navSubFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&navType=" + navType + "&navMain=" + navMain + "&navSub=" + navSub;
            if ($(this).attr('title') == 'Reload') {
                commonAction({
                    targetId: {
                        submitForm: formId,
                    },
                    resetFormFields: {
                        selectPicker: {},
                        selectTwo: {},
                    }
                })
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&navType=" + '' + "&navMain=" + '' + "&navSub=" + '';
            }
            commonAction({
                targetId: {
                    submitForm: formId,
                    actionType: $(this).attr('title'),
                },
                dataTable: {
                    load: {
                        targetId: dataTableId,
                        url: newUrl,
                    }
                },
                filterApply: {}
            })
        });

        //------ ( Role Main )
        $('#filterRoleMainForm').find('#statusFilter, .filterRoleMainBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageAccess-roleMain'),

                status = formId.find("#statusFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status;
            if ($(this).attr('title') == 'Reload') {
                commonAction({
                    targetId: {
                        submitForm: formId,
                    },
                    resetFormFields: {
                        selectPicker: {},
                        selectTwo: {},
                    }
                })
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '';
            }
            commonAction({
                targetId: {
                    submitForm: formId,
                    actionType: $(this).attr('title'),
                },
                dataTable: {
                    load: {
                        targetId: dataTableId,
                        url: newUrl,
                    }
                },
                filterApply: {}
            })
        });
        /*--========================= ( Manage Nav START ) =========================--*/

    });

})(jQuery);
