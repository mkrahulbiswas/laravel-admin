(function ($) {
    $(function () {
        callOnModalClose()
        callSelectPicker()
        callSelect2()
        lcSwitch()
        dropify()
        summernote()
        waves()
    });
})(jQuery);


function callOnModalClose() {
    $('.con-add-modal, .con-edit-modal, .con-access-modal').on("hidden.bs.modal", function () {
        $(this).find('form')[0].reset();
        $(this).find('[type="checkbox"]').attr('checked', false);
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

    $('.select2-roleSub').select2({
        tags: false,
        placeholder: "Select Role Sub"
    });
}

function lcSwitch() {
    $('body').delegate('.npGo span', 'click', function () {
        let targetId = $(this)
        $(targetId).closest('.npGo').fadeOut(500)
        lc_switch('.lcSwitch')
    })

    $('.PermiAll').click(function () {
        $('#CheckAll').trigger('click');
    });

    $('#CheckAll').change(function () {
        if ($(this).prop("checked") == true) {
            lcs_on('.lcSwitch');
            $('.lcSwitch').val(1);
        } else if ($(this).prop("checked") == false) {
            $('.lcSwitch').val(0);
            lcs_off('.lcSwitch');
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
}

function dropify() {
    $('.dropify').dropify();
}

function summernote() {
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

function waves() {
    Waves.init()
}
