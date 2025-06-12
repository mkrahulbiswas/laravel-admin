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



        /*--========================= ( Navigation & Access START ) =========================--*/
        //------ ( Nav Type )
        $('#filterNavTypeForm').find('#statusFilter, .filterNavTypeBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-navigationAccess-manageSideNav-navType'),

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

        //------ ( Main Nav )
        $('#filterMainNavForm').find('#navTypeFilter, #statusFilter, .filterMainNavBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-navigationAccess-manageSideNav-mainNav'),

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

        //------ ( Sub Nav )
        $('#filterSubNavForm').find('#navTypeFilter, #mainNavFilter, #statusFilter, .filterSubNavBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-navigationAccess-manageSideNav-subNav'),

                status = formId.find("#statusFilter").val(),
                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                mainNav = (formId.find("#mainNavFilter").val() == '' || formId.find("#mainNavFilter").val() == null) ? '' : formId.find("#mainNavFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&navType=" + navType + "&mainNav=" + mainNav;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&navType=" + '' + "&mainNav=" + '';
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

        //------ ( Nested Nav )
        $('#filterNestedNavForm').find('#navTypeFilter, #mainNavFilter, #subNavFilter, #statusFilter, .filterNestedNavBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-navigationAccess-manageSideNav-nestedNav'),

                status = formId.find("#statusFilter").val(),
                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                mainNav = (formId.find("#mainNavFilter").val() == '' || formId.find("#mainNavFilter").val() == null) ? '' : formId.find("#mainNavFilter").val(),
                subNav = (formId.find("#subNavFilter").val() == '' || formId.find("#subNavFilter").val() == null) ? '' : formId.find("#subNavFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&navType=" + navType + "&mainNav=" + mainNav + "&subNav=" + subNav;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&navType=" + '' + "&mainNav=" + '' + "&subNav=" + '';
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
        /*--========================= ( Navigation & Access END ) =========================--*/


        /*--========================= ( Role & Permission START ) =========================--*/
        //------ ( Main Role )
        $('#filterMainRoleForm').find('#statusFilter, .filterMainRoleBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-rolePermission-manageRole-mainRole'),

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

        //------ ( Permission Main Role )
        $('#filterPermissionMainRoleForm').find('#navTypeFilter, #mainNavFilter, #subNavFilter, .filterPermissionMainRoleBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageAccess-permissionMainRole'),

                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                mainNav = (formId.find("#mainNavFilter").val() == '' || formId.find("#mainNavFilter").val() == null) ? '' : formId.find("#mainNavFilter").val(),
                subNav = (formId.find("#subNavFilter").val() == '' || formId.find("#subNavFilter").val() == null) ? '' : formId.find("#subNavFilter").val(),
                mainRoleId = $('#managePanel-manageAccess-permissionMainRole').attr('data-id'),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?mainRoleId=" + mainRoleId + "&navType=" + navType + "&mainNav=" + mainNav + "&subNav=" + subNav;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?mainRoleId=" + mainRoleId + "&navType=" + '' + "&mainNav=" + '' + "&subNav=" + '';
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

        //------ ( Sub Role )
        $('#filterSubRoleForm').find('#statusFilter, #mainRoleFilter, .filterSubRoleBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-rolePermission-manageRole-subRole'),

                status = formId.find("#statusFilter").val(),
                mainRole = (formId.find("#mainRoleFilter").val() == '' || formId.find("#mainRoleFilter").val() == null) ? '' : formId.find("#mainRoleFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&mainRole=" + mainRole;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&mainRole=" + '';
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

        //------ ( Permission Sub Role )
        $('#filterPermissionSubRoleForm').find('#navTypeFilter, #mainNavFilter, #subNavFilter, .filterPermissionSubRoleBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#managePanel-manageAccess-permissionSubRole'),

                navType = (formId.find("#navTypeFilter").val() == '' || formId.find("#navTypeFilter").val() == null) ? '' : formId.find("#navTypeFilter").val(),
                mainNav = (formId.find("#mainNavFilter").val() == '' || formId.find("#mainNavFilter").val() == null) ? '' : formId.find("#mainNavFilter").val(),
                subNav = (formId.find("#subNavFilter").val() == '' || formId.find("#subNavFilter").val() == null) ? '' : formId.find("#subNavFilter").val(),
                subRoleId = $('#managePanel-manageAccess-permissionSubRole').attr('data-id'),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?subRoleId=" + subRoleId + "&navType=" + navType + "&mainNav=" + mainNav + "&subNav=" + subNav;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?subRoleId=" + subRoleId + "&navType=" + '' + "&mainNav=" + '' + "&subNav=" + '';
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
        /*--========================= ( Role & Permission END ) =========================--*/



        /*--========================= ( Quick Setting START ) =========================--*/
        //------ ( Alert For )
        $('#filterAlertForForm').find('#alertTypeFilter, #statusFilter, .filterAlertForBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = $('#adminRelated-quickSetting-customizedAlert-alertFor'),

                alertType = formId.find("#alertTypeFilter").val(),
                status = formId.find("#statusFilter").val(),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?alertType=" + alertType + "&status=" + status;
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
                newUrl = action[action.length - 2] + "/ajaxGetList?alertType=" + '' + "&status=" + '';
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
        /*--========================= ( Quick Setting END ) =========================--*/



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

        //------ ( Manage Category )
        $('.filterManageCategoryForm').find('#statusFilter, #mainCategoryFilter, #subCategoryFilter, .filterManageCategoryBtn').on('change click', function () {
            var formId = $(this).closest('form'),
                dataTableId = '',

                status = formId.find("#statusFilter").val(),
                mainCategory = (formId.find("#mainCategoryFilter").val() == '' || formId.find("#mainCategoryFilter").val() == null) ? '' : formId.find("#mainCategoryFilter").val(),
                subCategory = (formId.find("#subCategoryFilter").val() == '' || formId.find("#subCategoryFilter").val() == null) ? '' : formId.find("#mainCategoryFilter").val(),
                type = formId.attr('data-type'),

                action = $(this).closest('form').attr('action').split('/'),
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + status + "&mainCategory=" + mainCategory + "&subCategory=" + subCategory + "&type=" + type;

            if (formId.attr('data-type') == 'MAIN') {
                dataTableId = $('#propertyRelated-propertyCategory-manageCategory-main')
            } else if (formId.attr('data-type') == 'SUB') {
                dataTableId = $('#propertyRelated-propertyCategory-manageCategory-sub')
            } else {
                dataTableId = $('#propertyRelated-propertyCategory-manageCategory-nested')
            }
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
                newUrl = action[action.length - 2] + "/ajaxGetList?status=" + '' + "&mainCategory=" + '' + "&subCategory=" + '' + "&type=" + type;
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
