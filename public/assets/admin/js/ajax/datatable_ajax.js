(function ($) {

    $(function () {
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

        /*------( Nav Type Listing )--------*/
        $('#managePanel-manageNav-navType').DataTable({
            processing: true,
            serverSide: true,
            ajax: "nav-type/ajaxGetList",
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "uniqueId"
                },
                {
                    data: "name"
                },
                {
                    data: "icon"
                },
                {
                    data: "description",
                },
                {
                    data: "status",
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Nav Main Listing )--------*/
        $('#managePanel-manageNav-navMain').DataTable({
            processing: true,
            serverSide: true,
            ajax: "nav-main/ajaxGetList",
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "uniqueId"
                },
                {
                    data: "navType"
                },
                {
                    data: "name"
                },
                {
                    data: "icon"
                },
                {
                    data: "status",
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Nav Sub Listing )--------*/
        $('#managePanel-manageNav-navSub').DataTable({
            processing: true,
            serverSide: true,
            ajax: "nav-sub/ajaxGetList",
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "uniqueId"
                },
                {
                    data: "navType"
                },
                {
                    data: "navMain"
                },
                {
                    data: "name"
                },
                {
                    data: "icon"
                },
                {
                    data: "status",
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Nav Nested Listing )--------*/
        $('#managePanel-manageNav-navNested').DataTable({
            processing: true,
            serverSide: true,
            ajax: "nav-nested/ajaxGetList",
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "uniqueId"
                },
                {
                    data: "navType"
                },
                {
                    data: "navMain"
                },
                {
                    data: "navSub"
                },
                {
                    data: "name"
                },
                {
                    data: "icon"
                },
                {
                    data: "status",
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
        /*--========================= ( CMS END ) =========================--*/

    });

})(jQuery);
