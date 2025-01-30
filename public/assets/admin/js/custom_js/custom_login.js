$(document).ready(function () {


    /*-------Admin Login Page Related------*/
    $('.btnClickEventDo').click(function () {
        var check = $(this).closest('form').attr('id');
        $(this).closest('form')[0].reset();
        if (check == 'checkLoginForm') {
            $('#checkLoginForm, #resetPasswordForm').closest('.wrapper-page').hide();
            $('#forgotPasswordForm').closest('.wrapper-page').show();
        } else {
            $('#resetPasswordForm, #forgotPasswordForm').closest('.wrapper-page').hide();
            $('#checkLoginForm').closest('.wrapper-page').show();
        }
    });


});
