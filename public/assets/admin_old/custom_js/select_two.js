$(document).ready(function () {

    var pathArray = window.location.pathname.split('/');
    if (jQuery.inArray("table", pathArray) >= 1 && jQuery.inArray("appearance", pathArray) >= 1) {
        $('.advance-select-table-fontType').select2({
            tags: false,
            placeholder: "Select Font Type"
        });

        $('.advance-select-table-fontStyle').select2({
            tags: false,
            placeholder: "Select Font Style"
        });

        $('.advance-select-table-fontWeight').select2({
            tags: false,
            placeholder: "Select Font Weight"
        });

        $('.advance-select-table-fontSize').select2({
            tags: false,
            placeholder: "Select Font Size"
        });


        $('.advance-select-table-decorationType').select2({
            tags: false,
            placeholder: "Select Type"
        });

        $('.advance-select-table-decorationStyle').select2({
            tags: false,
            placeholder: "Select Style"
        });

        $('.advance-select-table-decorationSize').select2({
            tags: false,
            placeholder: "Select Size"
        });
    } else if (jQuery.inArray("loader", pathArray) >= 1) {
        $('.advance-select-loaderType').select2({
            tags: false,
            placeholder: "Select Loader For"
        });
    } else if (jQuery.inArray("setup-admin", pathArray) >= 1) {
        $('.advance-select-mainMenu').select2({
            tags: false,
            placeholder: "Select Main Menu"
        });
    } else {
        $('.advance-select-client').select2({
            tags: false,
            placeholder: "Select Client"
        });
        $('.advance-select-category').select2({
            tags: false,
            placeholder: "Select Category"
        });
        $('.advance-select-units').select2({
            tags: false,
            placeholder: "Select Units"
        });
        $('.advance-select-status').select2({
            tags: false,
            placeholder: "Select Status"
        });
        $('.advance-select-payMode').select2({
            tags: false,
            placeholder: "Select Pay Mode"
        });
    }

});
