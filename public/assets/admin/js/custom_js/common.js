(function ($) {
    $(function () {
        callOnModalClose()
        callSelectPicker()
        callSelect2()
    });
})(jQuery);


function callOnModalClose() {
    $('.con-add-modal, .con-edit-modal').on("hidden.bs.modal", function () {
        $(this).find('form')[0].reset();
        $(this).find('.dropify-clear').trigger('click');
        $(this).find('.selectTwo').val('').trigger('change');
        $(this).find('.selectPicker').selectpicker('val', '');
        // $(this).find('textarea').summernote('reset');
        $(this).find('.form-control, .select2-container--default .select2-selection--single').removeClass('valid-input invalid-input');
        let ids = '#saveNavTypeForm, #updateNavTypeForm, #saveNavMainForm, #updateNavMainForm, #saveNavSubForm, #updateNavSubForm, #saveNavNestedForm, #updateNavNestedForm';
        $(ids).find(".validation-error").text('');
        $(this).find('.selectTwo').select2('reset');
    });
}

function callSelectPicker() {
    $('.selectPicker').selectpicker();
}

function callSelect2() {
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

    $('.select2-roleMain').select2({
        tags: false,
        placeholder: "Select Role Main"
    });
    $('.select2-roleMain-addModal').select2({
        tags: false,
        placeholder: "Select Role Main",
        dropdownParent: $('#con-add-modal')
    });
    $('.select2-roleMain-editModal').select2({
        tags: false,
        placeholder: "Select Role Main",
        dropdownParent: $('#con-edit-modal')
    });
}
