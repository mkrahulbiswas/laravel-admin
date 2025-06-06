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
                    targetForm.find('.selectTwo').val(null).trigger('change');
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

        /*--========================= ( Manage Users START ) =========================--*/
        //------ ( Admin Users )
        $('#filterAdminUsersForm').find('#statusFilter, .filterAdminUsersBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#manageUsers-adminUsers'),

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
        /*--========================= ( Manage Users END ) =========================--*/



        /*--========================= ( Manage Panel START ) =========================--*/
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

        //------ ( Permission Role Main )
        $('#filterPermissionRoleMainForm').find('#navTypeFilter, #navMainFilter, #navSubFilter, .filterPermissionRoleMainBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageAccess-permissionRoleMain'),

                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                navMain = (formId.find("#navMainFilter").val() == '' || formId.find("#navMainFilter").val() == null) ? '' : formId.find("#navMainFilter").val(),
                navSub = (formId.find("#navSubFilter").val() == '' || formId.find("#navSubFilter").val() == null) ? '' : formId.find("#navSubFilter").val(),
                roleMainId = $('#managePanel-manageAccess-permissionRoleMain').attr('data-id'),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?roleMainId=" + roleMainId + "&navType=" + navType + "&navMain=" + navMain + "&navSub=" + navSub;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?roleMainId=" + roleMainId + "&navType=" + '' + "&navMain=" + '' + "&navSub=" + '';
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

        //------ ( Role Sub )
        $('#filterRoleSubForm').find('#statusFilter, #roleMainFilter, .filterRoleSubBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageAccess-roleSub'),

                status = formId.find("#statusFilter").val(),
                roleMain = (formId.find("#roleMainFilter").val() == '' || formId.find("#roleMainFilter").val() == null) ? '' : formId.find("#roleMainFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&roleMain=" + roleMain;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&roleMain=" + '';
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

        //------ ( Permission Role Sub )
        $('#filterPermissionRoleSubForm').find('#navTypeFilter, #navMainFilter, #navSubFilter, .filterPermissionRoleSubBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageAccess-permissionRoleSub'),

                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                navMain = (formId.find("#navMainFilter").val() == '' || formId.find("#navMainFilter").val() == null) ? '' : formId.find("#navMainFilter").val(),
                navSub = (formId.find("#navSubFilter").val() == '' || formId.find("#navSubFilter").val() == null) ? '' : formId.find("#navSubFilter").val(),
                roleSubId = $('#managePanel-manageAccess-permissionRoleSub').attr('data-id'),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?roleSubId=" + roleSubId + "&navType=" + navType + "&navMain=" + navMain + "&navSub=" + navSub;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?roleSubId=" + roleSubId + "&navType=" + '' + "&navMain=" + '' + "&navSub=" + '';
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
        /*--========================= ( Manage Panel END ) =========================--*/



        /*--========================= ( Property Related START ) =========================--*/
        //------ ( Property Attribute )
        $('#filterPropertyAttributeForm').find('#statusFilter, #typeFilter, #defaultFilter, .filterPropertyAttributeBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#propertyRelated-propertyAttribute'),

                status = formId.find("#statusFilter").val(),
                type = formId.find("#typeFilter").val(),
                defaul = formId.find("#defaultFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&type=" + type + "&default=" + defaul;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&type=" + '' + "&default=" + '';
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

        //------ ( Property Type )
        $('#filterPropertyTypeForm').find('#statusFilter, #defaultFilter, .filterPropertyTypeBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#propertyRelated-propertyAttribute'),

                status = formId.find("#statusFilter").val(),
                defaul = formId.find("#defaultFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&default=" + defaul;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&default=" + '';
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

        //------ ( Broad Type )
        $('#filterBroadTypeForm').find('#statusFilter, .filterBroadTypeBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#propertyRelated-manageBroad-broadType'),

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

        //------ ( Assign Broad )
        $('#filterAssignBroadForm').find('#statusFilter, #defaultFilter, #propertyTypeFilter, #broadTypeFilter, .filterAssignBroadBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#propertyRelated-manageBroad-assignBroad'),

                status = formId.find("#statusFilter").val(),
                defaul = formId.find("#defaultFilter").val(),
                propertyType = formId.find("#propertyTypeFilter").val(),
                broadType = formId.find("#broadTypeFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&default=" + defaul + "&propertyType=" + propertyType + "&broadType=" + broadType;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&default=" + '' + "&propertyType=" + '' + "&broadType=" + '';
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

        //------ ( Main Category )
        $('#filterMainCategoryForm').find('#statusFilter, .filterMainCategoryBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('.propertyRelated-propertyCategory-manageCategory'),

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

        //------ ( Assign Category )
        $('#filterAssignCategoryForm').find('#statusFilter, #defaultFilter, #mainCategoryFilter, #propertyTypeFilter, #assignBroadFilter, .filterAssignCategoryBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#propertyRelated-propertyCategory-assignCategory'),

                status = formId.find("#statusFilter").val(),
                defaul = formId.find("#defaultFilter").val(),
                mainCategory = formId.find("#mainCategoryFilter").val(),
                propertyType = formId.find("#propertyTypeFilter").val(),
                assignBroad = formId.find("#assignBroadFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&default=" + defaul + "&mainCategory=" + mainCategory + "&propertyType=" + propertyType + "&assignBroad=" + assignBroad;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&default=" + '' + "&mainCategory=" + '' + "&propertyType=" + '' + "&assignBroad=" + '';
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
        /*--========================= ( Property Related END ) =========================--*/
    });

})(jQuery);
