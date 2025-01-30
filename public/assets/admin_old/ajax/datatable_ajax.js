$(document).ready(function () {

    if (location.hostname === "localhost") {
        var baseUrl = "http://localhost/Saheti/admin/";
    } else if (location.hostname === "192.168.0.125") {
        var baseUrl = "http://192.168.0.125/Saheti/admin/";
    } else if (location.hostname === "intelligentappsolutionsdemo.com") {
        var baseUrl = 'http://intelligentappsolutionsdemo.com/current-project/website/Saheti/admin/';
    }

    // Responsive Datatable
    $('#responsive-datatable-one, #stockManagement-mainStock-listing, #responsive-datatable').DataTable();
    $('.responsive-datatable-custom').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false
    });

    $('.responsive-datatable-productSale').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
    });



    /*--========================= ( USER START ) =========================--*/
    /*------( Users Admin Listing )--------*/
    $('#users-admin-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "sub-admins/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            }, {
                "data": "name",
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "role"
            },
            {
                "data": "status",
            },
            {
                "data": "image",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Client )--------*/
    $('#users-client-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "client/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "image",
            },
            {
                "data": "name",
            },
            {
                "data": "phone"
            },
            {
                "data": "email"
            },
            {
                "data": "status"
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
    /*--========================= ( USER END ) =========================--*/



    /*--========================= ( SETUP ADMIN START ) =========================--*/
    /*------( Role Listing )--------*/
    $('#setupAdmin-role-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "roles/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "role"
            },
            {
                "data": "description"
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Permission Listing )--------*/
    $('#setupAdmin-permission-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "ajaxGetList",
        searching: false,
        paging: false,
        info: false,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "module_name"
            },
            {
                "data": "sub_module_name"
            },
            {
                "data": "accessItem"
            },
            {
                "data": "addAction"
            },
            {
                "data": "editAction"
            },
            {
                "data": "deleteAction"
            },
            {
                "data": "detailsAction"
            },
            {
                "data": "statusAction"
            },
            {
                "data": "otherAction"
            }
        ]
    });

    /*------( Main Menu Listing )--------*/
    $('#setupAdmin-mainMenu-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "side-nav-bar/main-menu/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "name"
            },
            {
                "data": "icon"
            },
            {
                "data": "createAt"
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Sub Menu Listing )--------*/
    $('#setupAdmin-subMenu-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "side-nav-bar/sub-menu/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "mainMenu"
            },
            {
                "data": "name"
            },
            {
                "data": "createAt"
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
    /*--========================= ( SETUP ADMIN END ) =========================--*/



    /*--========================= ( CMS START ) =========================--*/
    /*------( Feedback Listing )--------*/
    $('#cms-feedback-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "feedback/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "name",
            },
            {
                "data": "type",
            },
            {
                "data": "message",
            },
            {
                "data": "date",
            },
            {
                "data": "isRead",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Banner Listing )--------*/
    $('#cms-banner-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "banner/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "banner",
            },
            {
                "data": "for"
            },
            {
                "data": "status"
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Contact Enquiry )--------*/
    $('#cms-contactEnquiry-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "contact-enquiry/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "name",
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "date"
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });


    /*------( FAQ Listing )--------*/
    $('#cms-faq-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "faq/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "question",
            },
            {
                "data": "answer",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
    /*--========================= ( CMS END ) =========================--*/



    /*--========================= ( SETTING START ) =========================--*/
    //--Email Template
    $('#setting-emailTemplate-listing').DataTable({
        "processing": true,
        "serverSide": true,

        // scrollX: true,
        // scrollY: 500,
        // scrollCollapse: true,
        // responsive: false,
        // colReorder: false,

        // "autoWidth": false,
        // "columns": [{
        //         "width": "20%"
        //     },
        //     {
        //         "width": "80%"
        //     },
        // ],

        "ajax": "email-template/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "subject",
            },
            {
                "data": "slug",
            },
            {
                "data": "variable",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Social Links Listing )--------*/
    $('#setting-socialLinks-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "social-links/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "title",
            },
            {
                "data": "icon",
            },
            {
                "data": "link",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Logo Listing )------*/
    $('#cms-logo-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "logo/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "bigLogo",
            },
            {
                "data": "smallLogo",
            },
            {
                "data": "favIcon",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false,
            }
        ]
    });

    /*------( Units Listing )--------*/
    $('#setting-units-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "units/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "name",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
    /*--========================= ( SETTING END ) =========================--*/



    /*--========================= ( Manage Product START ) =========================--*/
    /*------( Category Listing )--------*/
    $('#manageProduct-category-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "category/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "name",
            },
            {
                "data": "display",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Product Listing )--------*/
    $('#manageProduct-product-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "product/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "image",
            },
            {
                "data": "name",
            },
            {
                "data": "price",
                "render": function (data, type, row) {
                    return $('<div/>').html(data.toFixed(2)).text();
                }
            },
            {
                "data": "display",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    /*------( Product Image Listing )--------*/
    $('#manageProduct-productImage-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "image/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                "data": "image",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
    /*--========================= ( Manage Product END ) =========================--*/



    /*--========================= ( Manage Orders START ) =========================--*/
    /*------( Orders Listing )--------*/
    $('#manageOrders-orders-listing').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "orders/ajaxGetList",
        "language": {
            "searchPlaceholder": "None"
        },
        "columns": [{
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            // {
            //     "data": "price",
            //     "render": function (data, type, row) {
            //         return $('<div/>').html(data.toFixed(2)).text();
            //     }
            // },
            {
                "data": "uniqueId",
            },{
                "data": "totalItem",
            },
            {
                "data": "payMode",
            },
            {
                "data": "orderDate",
            },
            {
                "data": "status",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
    /*--========================= ( Manage Orders END ) =========================--*/

});