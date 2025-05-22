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


        /*--========================= ( Manage Users START ) =========================--*/
        /*------( Users Admin Listing )--------*/
        $('#manageUsers-adminUsers').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "admin-users/ajaxGetList",
            "language": {
                "searchPlaceholder": "None"
            },
            "columns": [{
                    "data": "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "uniqueId",
                },
                {
                    "data": "name",
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
        /*--========================= ( Manage Users END ) =========================--*/



        /*--========================= ( Manage Panel START ) =========================--*/
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
                    data: "uniqueId",
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
                    data: "statInfo",
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
                    data: "statInfo",
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
                    data: "statInfo",
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        /*------( Role Main Listing )--------*/
        $('#managePanel-manageAccess-roleMain').DataTable({
            processing: true,
            serverSide: true,
            ajax: "role-main/ajaxGetList",
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
                    data: "description",
                },
                {
                    data: "statInfo",
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Permission Role Main Listing )--------*/
        $('#managePanel-manageAccess-permissionRoleMain').DataTable({
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            serverSide: true,
            ajax: "role-main/ajaxGetList/?roleMainId=" + $('#managePanel-manageAccess-permissionRoleMain').attr('data-id'),
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                data: 'permission',
                orderable: false,
            }]
        });

        /*------( Role Sub Listing )--------*/
        $('#managePanel-manageAccess-roleSub').DataTable({
            processing: true,
            serverSide: true,
            ajax: "role-sub/ajaxGetList",
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
                    data: "roleMain"
                },
                {
                    data: "name"
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

        /*------( Permission Role Sub Listing )--------*/
        $('#managePanel-manageAccess-permissionRoleSub').DataTable({
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            serverSide: true,
            ajax: "role-sub/ajaxGetList/?roleSubId=" + $('#managePanel-manageAccess-permissionRoleSub').attr('data-id'),
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                data: 'permission',
                orderable: false,
            }]
        });
        /*--========================= ( Manage Panel END ) =========================--*/



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
