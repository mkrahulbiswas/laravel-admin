(function ($) {
    $(function () {
        initCommonMethod()
        initSortable()
        initDraggable()
        initCallOnModalClose()
        initCallSelectPicker()
        initCallSelect2()
        initLcSwitch()
        initDropify()
        initSummernote()
        initWaves()
        initDatePicker()
        initDateRangePicker()
        initTimePicker()
        initIntlTelInput()
    });
})(jQuery);


function initCommonMethod() {
    window.pathArray = window.location.pathname.split('/');
    window.errorClassList = '.form-control, .select2-container--default .select2-selection--single, .dropify-wrapper, .note-editor';
    window.commonAction = function commonAction(data) {
        let targetForm = (data.targetId != undefined) ? data.targetId.submitForm : '',
            targetBtn = (data.targetId != undefined) ? data.targetId.submitBtn : '',
            actionType = (data.targetId != undefined) ? data.targetId.actionType : '';

        if (data.afterSuccess != undefined) {
            if (data.afterSuccess.resetForm == true) {
                targetForm[0].reset();
                targetForm.find('.dropify-clear').trigger('click')
                targetForm.find('.summernote').summernote('reset');
            }
            if (data.afterSuccess.hideModal == true) {
                targetForm.closest('.con-common-modal').modal('hide');
            }
        }

        if (data.dataTable != undefined) {
            if (data.dataTable.reload != undefined) {
                data.dataTable.reload.targetId.DataTable().ajax.reload(null, false);
            }
            if (data.dataTable.load != undefined) {
                data.dataTable.load.targetId.DataTable().ajax.url(data.dataTable.load.url).load();
            }
        }

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

        if (data.resetValidation != undefined) {
            targetForm.find(".validation-error").text('');
            targetForm.find(errorClassList).removeClass('valid-input invalid-input');
        }

        if (data.submitBtnState != undefined) {
            targetBtn.attr("disabled", data.submitBtnState.dataPass.disabled).find('span').text(data.submitBtnState.dataPass.text);
        }

        if (data.toaster != undefined) {
            $.toast({
                heading: (data.toaster.dataPass.title == undefined) ? 'NA' : data.toaster.dataPass.title,
                text: (data.toaster.dataPass.msg == undefined) ? 'NA' : data.toaster.dataPass.msg,
                showHideTransition: 'slide',
                icon: (data.toaster.dataPass.type == undefined) ? 'warning' : data.toaster.dataPass.type,
                hideAfter: 10000,
                stack: 3,
                position: 'top-right',
            });
        }

        if (data.swal != undefined) {
            if (data.swal.type == 'basic') {
                Swal.fire({
                    ...data.swal.props
                });
            }
            if (data.swal.type == 'confirm') {
                Swal.fire({
                    ...data.swal.props
                }).then((result) => {
                    if (result.isConfirmed) {
                        return true
                    }
                    return false
                });
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

        if (data.resetFormFields != undefined) {
            if (data.resetFormFields.selectPicker != undefined) {
                targetForm.find('.selectPicker').selectpicker('val', '');
            }
            if (data.resetFormFields.selectTwo != undefined) {
                targetForm.find('.selectTwo').val(null).trigger('change');
                // targetForm.find('.selectTwo').select2('reset');
            }
        }
    }
    window.commonMethod = function commonMethod(data) {
        if (data.type == 'common') {
            Swal.fire({
                title: data.swalData.title,
                text: data.swalData.text,
                icon: data.swalData.icon,
                showCancelButton: true,
                confirmButtonText: data.swalData.confirmButtonText,
                cancelButtonText: data.swalData.cancelButtonText,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: data.action,
                        type: data.method,
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
                                },
                                toaster: {
                                    dataPass: {
                                        title: msg.title,
                                        msg: msg.msg,
                                        type: msg.type
                                    }
                                },
                            })
                            if (msg.status == 1) {
                                commonAction({
                                    dataTable: {
                                        reload: {
                                            targetId: data.targetTableId
                                        }
                                    }
                                })
                            }
                        },
                        error: function (xhr, textStatus, error) {
                            commonAction({
                                loader: {
                                    isSet: false
                                },
                                targetId: {
                                    submitForm: submitForm,
                                    submitBtn: submitBtn,
                                },
                                toaster: {
                                    dataPass: {
                                        title: textStatus,
                                        msg: error,
                                        type: textStatus
                                    }
                                },
                            })
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {

                }
            })
        }
    }
}

function initCallOnModalClose() {
    $('.con-common-modal').on("hidden.bs.modal", function () {
        $(this).find('form')[0].reset();
        $(this).find('[type="checkbox"]').attr('checked', false);
        $(this).find('.dropify-clear').trigger('click');
        $(this).find('.selectTwo').val(null).trigger('change');
        $(this).find('.selectPicker').selectpicker('val', '');
        // $(this).find('textarea').summernote('reset');
        $(this).find('.form-control, .select2-container--default .select2-selection--single').removeClass('valid-input invalid-input');
        var idArray = [
            'saveAssignCategoryForm', 'updateAssignCategoryForm',
            'saveManageCategoryForm', 'updateManageCategoryForm',
            'saveAssignBroadForm', 'updateAssignBroadForm',
            'saveBroadTypeForm', 'updateBroadTypeForm',
            'saveLogoForm', 'updateLogoForm',
            'saveNavTypeForm', 'updateNavTypeForm',
            'saveMainNavForm', 'updateMainNavForm',
            'saveSubNavForm', 'updateSubNavForm',
            'saveNestedNavForm', 'updateNestedNavForm',
            'savePropertyAttributeForm', 'updatePropertyAttributeForm',
            'savePropertyTypeForm', 'updatePropertyTypeForm',
            'saveMainRoleForm', 'updateMainRoleForm',
            'saveSubRoleForm', 'updateSubRoleForm',
            'saveAlertTypeForm', 'updateAlertTypeForm',
            'saveAlertForForm', 'updateAlertForForm',
            'saveAlertTemplateForm', 'updateAlertTemplateForm',
            'resetAuthVerifyForm', 'resetAuthUpdateForm',
            'changeAuthSendForm', 'changeAuthVerifyForm',
        ];
        var idArrayToString = '#' + idArray.join(', #');
        $(idArrayToString).find(".validation-error").text('');
        $(this).find('.selectTwo').select2('reset');
    });
}

function initIntlTelInput() {
    let targetClass = document.querySelector(".intl-phone-basic");
    if (targetClass) {
        window.iti = window.intlTelInput(targetClass, {
            // allowDropdown: false,
            // autoPlaceholder: "off",
            containerClass: "intl-phone-full-width",
            // countryOrder: ["jp", "kr"],
            countrySearch: false,
            // customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            //   return "e.g. " + selectedCountryPlaceholder;
            // },
            // dropdownContainer: document.querySelector('#custom-container'),
            // excludeCountries: ["us"],
            // fixDropdownWidth: false,
            // formatAsYouType: false,
            // formatOnDisplay: false,
            // geoIpLookup: function(callback) {
            //   fetch("https://ipapi.co/json")
            //     .then(function(res) { return res.json(); })
            //     .then(function(data) { callback(data.country_code); })
            //     .catch(function() { callback(); });
            // },
            // hiddenInput: () => ({ phone: "phone_full", country: "country_code" }),
            // i18n: { 'de': 'Deutschland' },
            initialCountry: "in",
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"), // leading slash (and http-server) required for this to work in chrome
            // loadUtils: () => import("/utils.js"),
            // nationalMode: false,
            onlyCountries: ['us', 'in', 'ch', 'ca', 'do'],
            // placeholderNumberType: "MOBILE",
            // showFlags: false,
            // separateDialCode: true,
            // strictMode: true,
            // useFullscreenPopup: true,
            // validationNumberTypes: null,
        });
    }
}

function initCallSelectPicker() {
    $('.selectPicker').selectpicker();
}

function initCallSelect2() {
    $('.select2-navType').select2({
        tags: false,
        placeholder: "Select nav type"
    });
    $('.select2-navType-addModal').select2({
        tags: false,
        placeholder: "Select nav type",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-navType-editModal').select2({
        tags: false,
        placeholder: "Select nav type",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-alertFor').select2({
        tags: false,
        placeholder: "Select alert for"
    });
    $('.select2-alertFor-addModal').select2({
        tags: false,
        placeholder: "Select alert for",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-alertFor-editModal').select2({
        tags: false,
        placeholder: "Select alert for",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-mainNav').select2({
        tags: false,
        placeholder: "Select main nav"
    });
    $('.select2-mainNav-addModal').select2({
        tags: false,
        placeholder: "Select main nav",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-mainNav-editModal').select2({
        tags: false,
        placeholder: "Select main nav",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-propertyType').select2({
        tags: false,
        placeholder: "Select property type"
    });
    $('.select2-propertyType-addModal').select2({
        tags: false,
        placeholder: "Select property type",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-propertyType-editModal').select2({
        tags: false,
        placeholder: "Select property type",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-nestedCategory').select2({
        tags: false,
        placeholder: "Select nested category"
    });

    $('.select2-subCategory').select2({
        tags: false,
        placeholder: "Select sub category"
    });
    $('.select2-subCategory-addModal').select2({
        tags: false,
        placeholder: "Select sub category",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-subCategory-editModal').select2({
        tags: false,
        placeholder: "Select sub category",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-mainCategory').select2({
        tags: false,
        placeholder: "Select main category"
    });
    $('.select2-mainCategory-addModal').select2({
        tags: false,
        placeholder: "Select main category",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-mainCategory-editModal').select2({
        tags: false,
        placeholder: "Select main category",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-assignBroad').select2({
        tags: false,
        placeholder: "Select broad type"
    });
    $('.select2-assignBroad-addModal').select2({
        tags: false,
        placeholder: "Select broad type",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-assignBroad-editModal').select2({
        tags: false,
        placeholder: "Select broad type",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-broadType').select2({
        tags: false,
        placeholder: "Select broad type"
    });
    $('.select2-broadType-addModal').select2({
        tags: false,
        placeholder: "Select broad type",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-broadType-editModal').select2({
        tags: false,
        placeholder: "Select broad type",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-type').select2({
        tags: false,
        placeholder: "Select Type"
    });
    $('.select2-type-addModal').select2({
        tags: false,
        placeholder: "Select Type",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-type-editModal').select2({
        tags: false,
        placeholder: "Select Type",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-subNav').select2({
        tags: false,
        placeholder: "Select sub nav"
    });
    $('.select2-subNav-addModal').select2({
        tags: false,
        placeholder: "Select sub nav",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-subNav-editModal').select2({
        tags: false,
        placeholder: "Select sub nav",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-nestedNav').select2({
        tags: false,
        placeholder: "Select nested nav"
    });
    $('.select2-nestedNav-addModal').select2({
        tags: false,
        placeholder: "Select nested nav",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-nestedNav-editModal').select2({
        tags: false,
        placeholder: "Select nested nav",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-mainRole').select2({
        tags: false,
        placeholder: "Select main role"
    });
    $('.select2-mainRole-addModal').select2({
        tags: false,
        placeholder: "Select main role",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-mainRole-editModal').select2({
        tags: false,
        placeholder: "Select main role",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-subRole').select2({
        tags: false,
        placeholder: "Select sub role"
    });
}

function initLcSwitch() {
    $('body').delegate('.npGo span', 'click', function () {
        let targetId = $(this)
        $(targetId).closest('.npGo').fadeOut(500)
        lc_switch('.lcSwitch')
    })
}

function initDropify() {
    $('.dropify').dropify();
}

function initSummernote() {
    $('.sn-adminUser-about').summernote({
        height: 145,
        width: '100%',
        focus: false,
        placeholder: 'Paste content here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
        ]
    });
    $('.sn-alertTemplate-content').summernote({
        height: 145,
        width: '100%',
        focus: false,
        placeholder: 'Paste content here...',
    });
}

function initWaves() {
    Waves.init()
}

function initDatePicker() {
    $('.date-picker').datepicker({
        format: 'dd/mm/yyyy',
        // defaultViewDate: {
        //     year: moment().format('YYYY'),
        //     month: moment().format('MM'),
        //     day: moment().format('DD')
        // },
        autoclose: true,
    });
}

function initDateRangePicker() {
    $('.date-range-picker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
    });
}

function initTimePicker() {
    $('.time-picker').clockTimePicker({
        duration: true,
        durationNegative: true,
        precision: 5,
        i18n: {
            cancelButton: 'lol'
        },
        onAdjust: function (newVal, oldVal) {}
    });
}

function initDraggable() {
    // new DraggableNestableList("#myList");
}

function initSortable() {
    var nestedSortables = [].slice.call(document.querySelectorAll('.allNavCommon'));
    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65
        });
    }
}
