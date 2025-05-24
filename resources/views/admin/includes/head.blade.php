<meta charset="utf-8" />
<title>{{ $reqData['appName'] }} Admin</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />
<!-- App favicon -->
<link rel="shortcut icon" href="{{ $reqData['favIcon'] }}">







@php
    $url = url()->current();
    $data = explode('/', $url);
@endphp


@if (in_array('pdf', $data) || in_array('print', $data))
    <link href="{{ asset('assets/admin/css/custom.scss') }}" rel="stylesheet" type="text/css" />
@else
    <?php
    /*
    <!-- ( Viewer JS Master ) -->
    <link href="{{ asset('assets/admin/plugins/viewerjs-master/css/viewer.css') }}" rel="stylesheet">

    <!-- ( Lightbox2 ) -->
    <link href="{{ asset('assets/plugins/lightbox2/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- ( Jquery Toast ) -->
    <link href="{{ asset('assets/plugins/toast/jquery.toast.min.css') }}" rel="stylesheet">

    <!-- ( Picker-Keep Color Picker ) -->
    <link href="{{ asset('assets/plugins/pickrKeep-colourPicker/css/classic.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/pickrKeep-colourPicker/css/monolith.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/pickrKeep-colourPicker/css/nano.min.css') }}" rel="stylesheet" type="text/css">

    <!-- ( Notify JS ) -->
    <link href="{{ asset('assets/plugins/notifyjs/css/notify-metro.css') }}" rel="stylesheet" type="text/css" />

    <!-- ( Animate ) -->
    <link href="{{ asset('assets/plugins/animate/css/animate.min.css') }}" rel="stylesheet" />

    <!-- ( Jquery UI ) -->
    <link href="{{ asset('assets/plugins/jquery-ui/css/jquery-ui.min.css') }}" rel="stylesheet" />

    <!-- ( Jquery Mobile ) -->
    <link href="{{ asset('assets/plugins/jquery-mobile/css/jquery.mobile-1.4.5.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/admin/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>
    <link href="{{ asset('assets/admin/plugins/morris/morris.css') }}" rel="stylesheet">

    <!--Multi Tag CSS-->
    <link href="{{ asset('assets/admin/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />


    <!--Date Range Picker-->
    <link href="{{ asset('assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!--Date Picker-->
    <link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />

    <!--venobox lightbox for show gallery pics-->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/magnific-popup/css/magnific-popup.css') }}" />

    <!-- X-editable css -->
    <link type="text/css" href="{{ asset('assets/admin/plugins/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
    */
    ?>




    <!-- Layout config Js -->
    <script src="{{ asset('assets/admin/js/layout.js') }}"></script>

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- custom Css-->
    <link href="{{ asset('assets/admin/css/custom.scss') }}" rel="stylesheet" type="text/css" />

    <!-- ( Sweet Alart 2 ) -->
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- ( Bootstrap Select Dropdown ) -->
    <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />

    <!-- ( Select2 CDN ) -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    @if ($checkOne == 'loginPage')
    @else
        <!-- jsvectormap css -->
        <link href="{{ asset('assets/plugins/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="{{ asset('assets/plugins/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <!--Choices css-->
        <link href="{{ asset('assets/plugins/choices-js/choices.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- ( Jquery Toast ) -->
        <link href="{{ asset('assets/plugins/toast/jquery.toast.min.css') }}" rel="stylesheet">

        <!-- ( Dropify File Selector ) -->
        <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- ( Summernote Editor ) -->
        <link href="{{ asset('assets/plugins/summernote/css/summernote.min.css') }}" rel="stylesheet" />
        {{-- <link href="{{ asset('assets/plugins/summernote/css/summernote-bs4.min.css') }}" rel="stylesheet" /> --}}
        <link href="{{ asset('assets/plugins/summernote/css/summernote-lite.min.css') }}" rel="stylesheet" />

        <!-- ( Datatble ) -->
        <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    @endif


    <style type="text/css">
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            /*#f5f8fa;*/
            z-index: 9998;
            text-align: center
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%
        }
    </style>

    <style>
        .PermiAll {
            display: flex;
            flex-direction: row;
            width: 300px;
            /* float: right; */
            justify-content: space-between;
            background-color: #d9d9d9;
            padding: 5px 15px 5px 5px;
            cursor: pointer;
        }

        .PermiAll label {
            padding: 0;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            pointer-events: none;
        }

        .PermiAll input {
            align-self: center;
            pointer-events: none;
        }
    </style>
@endif
