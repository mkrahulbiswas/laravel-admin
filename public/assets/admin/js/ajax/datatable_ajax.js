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
        $('#adminRelated-rolePermission-manageRole-mainRole').DataTable({
            processing: true,
            serverSide: true,
            ajax: "main-role/ajaxGetList",
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
            ajax: "main-role/ajaxGetList/?roleMainId=" + $('#managePanel-manageAccess-permissionRoleMain').attr('data-id'),
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                data: 'permission',
                orderable: false,
            }]
        });

        /*------( Role Sub Listing )--------*/
        $('#adminRelated-rolePermission-manageRole-subRole').DataTable({
            processing: true,
            serverSide: true,
            ajax: "sub-role/ajaxGetList",
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
            ajax: "sub-role/ajaxGetList/?roleSubId=" + $('#managePanel-manageAccess-permissionRoleSub').attr('data-id'),
            language: {
                searchPlaceholder: "None"
            },
            columns: [{
                data: 'permission',
                orderable: false,
            }]
        });


        /*------( Logo Listing )--------*/
        $('#managePanel-quickSettings-logo').DataTable({
            processing: true,
            serverSide: true,
            ajax: "logo/ajaxGetList",
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
                    data: "bigLogo"
                },
                {
                    data: "smallLogo"
                },
                {
                    data: "favicon",
                },
                {
                    data: "default",
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        /*--========================= ( Manage Panel END ) =========================--*/



        /*--========================= ( Property Related START ) =========================--*/
        /*------( Property Attribute Listing )--------*/
        $('#propertyRelated-propertyAttribute').DataTable({
            processing: true,
            serverSide: true,
            ajax: "property-attribute/ajaxGetList",
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
                    data: "about"
                },
                {
                    data: "type"
                },
                {
                    data: "statInfo"
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Property Type Listing )--------*/
        $('#propertyRelated-propertyType').DataTable({
            processing: true,
            serverSide: true,
            ajax: "property-type/ajaxGetList",
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
                    data: "about"
                },
                {
                    data: "statInfo"
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Broad Types Listing )--------*/
        $('#propertyRelated-manageBroad-broadType').DataTable({
            processing: true,
            serverSide: true,
            ajax: "broad-type/ajaxGetList",
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
                    data: "about"
                },
                {
                    data: "customizeInText",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.status.custom).text();
                    }
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Assign Broad Listing )--------*/
        $('#propertyRelated-manageBroad-assignBroad').DataTable({
            processing: true,
            serverSide: true,
            ajax: "assign-broad/ajaxGetList",
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
                    data: "propertyType",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.name).text();
                    }
                },
                {
                    data: "broadType",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.name).text();
                    }
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

        /*------( Mange Category Listing )--------*/
        $('#propertyRelated-propertyCategory-manageCategory-main').DataTable({
            processing: true,
            serverSide: true,
            ajax: "manage-category/ajaxGetList?type=" + $('#propertyRelated-propertyCategory-manageCategory-main').attr('data-type'),
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
                    data: "about"
                },
                {
                    data: "customizeInText",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.status.custom).text();
                    }
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#propertyRelated-propertyCategory-manageCategory-sub').DataTable({
            processing: true,
            serverSide: true,
            ajax: "manage-category/ajaxGetList?type=" + $('#propertyRelated-propertyCategory-manageCategory-sub').attr('data-type'),
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
                    data: "mainCategory",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.name).text();
                    }
                },
                {
                    data: "name"
                },
                {
                    data: "customizeInText",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.status.custom).text();
                    }
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#propertyRelated-propertyCategory-manageCategory-nested').DataTable({
            processing: true,
            serverSide: true,
            ajax: "manage-category/ajaxGetList?type=" + $('#propertyRelated-propertyCategory-manageCategory-nested').attr('data-type'),
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
                    data: "mainCategory",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.name).text();
                    }
                },
                {
                    data: "subCategory",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.name).text();
                    }
                },
                {
                    data: "name"
                },
                {
                    data: "customizeInText",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.status.custom).text();
                    }
                },
                {
                    data: 'action',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        /*------( Assign Category Listing )--------*/
        $('#propertyRelated-propertyCategory-assignCategory').DataTable({
            processing: true,
            serverSide: true,
            ajax: "assign-category/ajaxGetList",
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
                    data: "mainCategory",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.name).text();
                    }
                },
                {
                    data: "assignBroad",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.broadType.name).text();
                    }
                },
                {
                    data: "assignBroad",
                    render: function (data, type, row) {
                        return $('<div/>').html(data.propertyType.name).text();
                    }
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
        /*--========================= ( Property Related END ) =========================--*/

    });

})(jQuery);
