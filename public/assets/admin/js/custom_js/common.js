(function ($) {
    $(function () {
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
    });
})(jQuery);


function initCallOnModalClose() {
    $('.con-add-modal, .con-edit-modal, .con-access-modal').on("hidden.bs.modal", function () {
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
            'saveNavMainForm', 'updateNavMainForm',
            'saveNavSubForm', 'updateNavSubForm',
            'saveNavNestedForm', 'updateNavNestedForm',
            'savePropertyAttributeForm', 'updatePropertyAttributeForm',
            'savePropertyTypeForm', 'updatePropertyTypeForm',
            'saveMainRoleForm', 'updateMainRoleForm',
            'saveSubRoleForm', 'updateSubRoleForm',
        ];
        var idArrayToString = '#' + idArray.join(', #');
        $(idArrayToString).find(".validation-error").text('');
        $(this).find('.selectTwo').select2('reset');
    });
}

function initCallSelectPicker() {
    $('.selectPicker').selectpicker();
}

function initCallSelect2() {
    $('.select2-navType').select2({
        tags: false,
        placeholder: "Select Nav Type"
    });
    $('.select2-navType-addModal').select2({
        tags: false,
        placeholder: "Select Nav Type",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-navType-editModal').select2({
        tags: false,
        placeholder: "Select Nav Type",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-navMain').select2({
        tags: false,
        placeholder: "Select Nav Main"
    });
    $('.select2-navMain-addModal').select2({
        tags: false,
        placeholder: "Select Nav Main",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-navMain-editModal').select2({
        tags: false,
        placeholder: "Select Nav Main",
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

    $('.select2-navSub').select2({
        tags: false,
        placeholder: "Select Nav Sub"
    });
    $('.select2-navSub-addModal').select2({
        tags: false,
        placeholder: "Select Nav Sub",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-navSub-editModal').select2({
        tags: false,
        placeholder: "Select Nav Sub",
        dropdownParent: $('#con-edit-modal')
    });

    $('.select2-navNested').select2({
        tags: false,
        placeholder: "Select Nav Nested"
    });
    $('.select2-navNested-addModal').select2({
        tags: false,
        placeholder: "Select Nav Nested",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-navNested-editModal').select2({
        tags: false,
        placeholder: "Select Nav Nested",
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
