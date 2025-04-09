$(document).ready(function () {
    $('#con-add-modal, #con-edit-modal').on("hidden.bs.modal", function () {

        $(this).find('.dropify-clear').trigger('click');
        $(this).find('select').val(['']).trigger('change');
        $(this).find('form')[0].reset();
        // $(this).find('textarea').summernote('reset');

        $("#saveLogoForm, #updateLogoForm").find("#alert").css('display', 'none');
        $('#saveLogoForm, #updateLogoForm').find("#bigLogoErr, #smallLogoErr, #favIconErr").text('');

        $("#saveSocialLinksForm, #updateSocialLinksForm").find("#alert").css('display', 'none');
        $('#saveSocialLinksForm, #updateSocialLinksForm').find("#titleErr, #iconErr, #linkErr").text('');

        $("#saveUnitsForm, #updateUnitsForm").find("#alert").css('display', 'none');
        $('#saveUnitsForm, #updateUnitsForm').find("#nameErr").text('');

        $("#saveCategoryForm, #updateCategoryForm").find("#alert").css('display', 'none');
        $('#saveCategoryForm, #updateCategoryForm').find("#nameErr").text('');

        $("#saveProductImageForm, #updateProductImageForm").find("#alert").css('display', 'none');
        $('#saveProductImageForm, #updateProductImageForm').find("#fileErr").text('');

        $("#saveFaqForm, #updateFaqForm").find("#alert").css('display', 'none');
        $('#saveFaqForm, #updateFaqForm').find("#questionErr, #answerErr").text('');

        $("#updateDisplayProductForm").find("#alert").css('display', 'none');
        $('#updateDisplayProductForm').find("#featuredErr, #topTrendingErr, #hotDealsErr").text('');

        $("#updateStatusForm").find("#alert").css('display', 'none');
        $('#updateStatusForm').find("#statusErr, #reasonErr").text('');
    });
});