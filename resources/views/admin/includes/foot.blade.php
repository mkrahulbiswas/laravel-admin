<script>
    var resizefunc = [];
</script>

@php
    $url = url()->current();
    $data = explode('/', $url);
@endphp

@if (in_array('pdf', $data) || in_array('print', $data))
@else
    <?php
    /*
    <!-- ( lightbox2 ) -->
    {{-- <script src="{{asset('assets/plugins/lightbox2/js/lightbox.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/plugins/lightbox2/js/lightbox-plus-jquery.min.js')}}"></script> --}}

    <!-- ( Jquery Toast ) -->
    <script src="{{ asset('assets/plugins/toast/jquery.toast.min.js') }}"></script>

    <!-- ( Picker-Keep Color Picker js ) -->
    {{-- <script src="{{ asset('assets/plugins/pickrKeep-colourPicker/js/pickr.min.js') }}" type="text/javascript"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/pickrKeep-colourPicker/js/pickr.es5.min.js') }}" type="text/javascript"></script> --}}

    <!-- ( For Youtube Player ) -->
    {{-- <script src="https://www.youtube.com/iframe_api"></script> --}}

    <!-- ( Notify JS ) -->
    <script src="{{ asset('assets/plugins/notifyjs/js/notify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifyjs/js/notify-metro.js') }}"></script>

    <!-- ( Parsley Form Validator ) -->
    <script src="{{ asset('assets/plugins/parsleyjs/js/parsley.min.js') }}" type="text/javascript"></script>

    <!-- ( Anime Master ) -->
    <script src="{{ asset('assets/plugins/anime-master/js/anime.min.js') }}"></script>

    <!-- ( Gread View ) -->
    <script type="text/javascript" src="{{ asset('assets/plugins/isotope/js/isotope.pkgd.min.js') }}"></script>

    <!-- ( Jquery UI ) -->
    <script src="{{ asset('assets/plugins/jquery-ui/js/jquery-ui.min.js') }}" type="text/javascript"></script>

    <!-- ( Sortable ) -->
    <script src="{{ asset('assets/plugins/sortable/js/sortable.min.js') }}" type="text/javascript"></script>

    <!-- ( Jquery Mobile ) -->
    {{-- <script src="{{ asset('assets/plugins/jquery-mobile/js/jquery.mobile-1.4.5.min.js') }}" type="text/javascript"></script> --}}

    <!-- ( Marquee Master ) -->
    <script src="{{ asset('assets/plugins/marquee-master/jquery.marquee.min.js') }}" type="text/javascript"></script>

    {{-- <script src="{{ asset('assets/admin/js/popper.min.js') }}"></script> --}}
    <script src="{{ asset('assets/admin/js/detect.js') }}"></script>
    <script src="{{ asset('assets/admin/js/fastclick.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/admin/js/waves.js') }}"></script>
    <script src="{{ asset('assets/admin/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.scrollTo.min.js') }}"></script>

    <!-- ( For Dashboard ) -->
    <script src="{{ asset('assets/admin/plugins/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/counterup/jquery.counterup.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/admin/plugins/morris/morris.min.js') }}"></script> --}}
    <script src="{{ asset('assets/admin/plugins/raphael/raphael-min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/jquery-knob/jquery.knob.js') }}"></script>


    <script src="https://kit.fontawesome.com/328756d9d2.js" crossorigin="anonymous"></script>
    <!--End-->

    <!--Multi Tag JS-->
    <script src="{{ asset('assets/admin/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>

    <!--Date Time Picker-->
    <script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/admin/js/jquery.core.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.app.js') }}"></script>

    <!-- Date Time Picker Init -->
    <script src="{{ asset('assets/admin/paages/jquery.form-pickers.init.js') }}"></script>

    <!-- Custom Ajax -->
    <script src="{{ asset('assets/admin/ajax/common_ajax.js') }}"></script>

    <!--for show image gallary-->
    <script type="text/javascript" src="{{ asset('assets/admin/plugins/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>

    <!-- XEditable Plugin used in booking details page -->
    <script type="text/javascript" src="{{ asset('assets/admin/plugins/x-editable/js/bootstrap-editable.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/paages/jquery.xeditable.js') }}"></script>

    */
    ?>

    <!-- ( bootstrap ) -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- ( Jquery CDN ) -->
    <script src="{{ asset('assets/plugins/jquery/js/jquery.min.js') }}"></script>

    <!-- ( Sweet Alart 2 ) -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- ( Jquery Toast ) -->
    <script src="{{ asset('assets/plugins/toast/jquery.toast.min.js') }}"></script>

    <!-- ( Waves ) -->
    <script src="{{ asset('assets/plugins/waves/js/waves.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>

    <!-- ( Moment ) -->
    <script src="{{ asset('assets/plugins/moment/js/moment.min.js') }}"></script>

    <!-- ( Date Range Picker ) -->
    <script src="{{ asset('assets/plugins/daterangepicker/js/daterangepicker.js') }}"></script>

    <!-- ( Bootstrap Date picker ) -->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- ( Jquery Clock Time Picker ) -->
    <script src="{{ asset('assets/plugins/jquery-clock-timepicker/js/jquery-clock-timepicker.min.js') }}"></script>

    <!-- ( Bootstrap Select Dropdown ) -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>

    <!-- ( AOS ) -->
    <script src="{{ asset('assets/plugins/aos/js/aos.js') }}" type="text/javascript"></script>

    <!-- ( Select2 CDN ) -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>


    @if ($checkOne == 'loginPage')
        <!-- Custom JS -->
        <script src="{{ asset('assets/admin/js/custom_js/custom_login.js') }}"></script>

        <!--Custom Ajax-->
        <script src="{{ asset('assets/admin/js/ajax/custom_ajax_login.js') }}"></script>

        <!-- particles js -->
        <script src="{{ asset('assets/plugins/particles/particles.js') }}"></script>
    @else
        <!-- ( Datatble ) -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script> --}}
        <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.select.min.js') }}"></script>


        <!-- ( LC Switch CDN ) -->
        <script src="{{ asset('assets/plugins/LC-switch-master/lc_switch.js') }}" type="text/javascript"></script>

        <!-- ( Sortable ) -->
        <script src="{{ asset('assets/plugins/sortable/js/sortable.min.js') }}" type="text/javascript"></script>

        <!-- apexcharts -->
        <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Vector map-->
        <script src="{{ asset('assets/plugins/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jsvectormap/maps/world-merc.js') }}"></script>

        <!--Swiper slider js-->
        <script src="{{ asset('assets/plugins/swiper/swiper-bundle.min.js') }}"></script>

        <!--Choices Js-->
        <script src="{{ asset('assets/plugins/choices-js/choices.min.js') }}"></script>

        <!-- Dashboard init -->
        <script src="{{ asset('assets/admin/js/dashboard-ecommerce.init.js') }}"></script>

        <!-- ( Dropify File Selector ) -->
        <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}" type="text/javascript"></script>

        <!-- ( Summernote Editor ) -->
        <script src="{{ asset('assets/plugins/summernote/js/summernote.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/plugins/summernote/js/summernote-bs4.min.js') }}"></script> --}}
        <script src="{{ asset('assets/plugins/summernote/js/summernote-lite.min.js') }}"></script>

        <!-- prismjs plugin -->
        {{-- <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script> --}}

        <!-- App js -->
        <script src="{{ asset('assets/admin/js/app.js') }}"></script>


        <!-- Custom Ajax -->
        <script src="{{ asset('assets/admin/js/ajax/datatable_ajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/ajax/custom_ajax.js') }}" type="module"></script>
        <script src="{{ asset('assets/admin/js/ajax/filter_ajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/ajax/ddd_ajax.js') }}"></script>

        <!-- Custom JS -->
        <script src="{{ asset('assets/admin/js/custom_js/common.js') }}"></script>
        {{-- <script src="{{asset('assets/admin/custom_js/color_picker.js')}}"></script> --}}
        <script src="{{ asset('assets/admin/js/custom_js/sortable.js') }}"></script>
        <script src="{{ asset('assets/admin/js/custom_js/custom.js') }}"></script>
    @endif

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endif
