<script>
    var resizefunc = [];
</script>




@php
    $url = url()->current();
    $data = explode('/', $url);
@endphp

@if (in_array('pdf', $data) || in_array('print', $data))
@else
    <?php /* ?> ?>

    <!-- ( Bootstrap CDN ) -->
    {{-- <script src="{{ asset('assets/plugins/bootstrap/v4/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/bootstrap/v4.1/js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/bootstrap/v4.1/js/bootstrap.bundle.min.js') }}"></script>

    <!-- ( Select2 CDN ) -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>

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

    <!-- ( Datatble ) -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script><!-- aa --> --}}
    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.select.min.js') }}"></script>

    <!-- ( Notify JS ) -->
    <script src="{{ asset('assets/plugins/notifyjs/js/notify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifyjs/js/notify-metro.js') }}"></script>

    <!-- ( Parsley Form Validator ) -->
    <script src="{{ asset('assets/plugins/parsleyjs/js/parsley.min.js') }}" type="text/javascript"></script>

    <!-- ( Dropify File Selector ) -->
    <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}" type="text/javascript"></script>

    <!-- ( Summernote Editor ) -->
    <script src="{{ asset('assets/plugins/summernote/js/summernote.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/js/summernote-lite.min.js') }}"></script>

    <!-- ( Anime Master ) -->
    <script src="{{ asset('assets/plugins/anime-master/js/anime.min.js') }}"></script>

    <!-- ( Gread View ) -->
    <script type="text/javascript" src="{{ asset('assets/plugins/isotope/js/isotope.pkgd.min.js') }}"></script>

    <!-- ( Bootstrap Select Dropdown ) -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript">
    </script>

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
    <script src="{{ asset('assets/admin/js/dropify.js') }}"></script>

    <!-- ( For Dashboard ) -->
    <script src="{{ asset('assets/admin/plugins/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/counterup/jquery.counterup.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/admin/plugins/morris/morris.min.js') }}"></script> --}}
    <script src="{{ asset('assets/admin/plugins/raphael/raphael-min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/jquery-knob/jquery.knob.js') }}"></script>

    {{-- <script src="{{ asset('assets/admin/pages/jquery.dashboard.js') }}"></script> --}}

    <script src="https://kit.fontawesome.com/328756d9d2.js" crossorigin="anonymous"></script>
    <!--End-->

    <!--Check Box Js-->
    {{-- <script src="{{ asset('assets/admin/plugins/switchery/js/switchery.min.js') }}"></script> --}}
    {{-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}
    <!-- <script type="text/javascript" src="{{ asset('assets/admin/pages/jquery.form-advanced.init.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/admin/js/jquery.core.js') }}"></script> -->

    <!--Multi Tag JS-->
    <script src="{{ asset('assets/admin/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>

    <!--Date Time Picker-->
    <script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <!-- App js -->
    <script src="{{ asset('assets/admin/js/jquery.core.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.app.js') }}"></script>

    <!-- Date Time Picker Init -->
    <script src="{{ asset('assets/admin/pages/jquery.form-pickers.init.js') }}"></script>

    <!-- Custom Ajax -->
    <script src="{{ asset('assets/admin/ajax/common_ajax.js') }}"></script>

    <!--for show image gallary-->
    <script type="text/javascript"
        src="{{ asset('assets/admin/plugins/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>

    <!-- XEditable Plugin used in booking details page -->
    <script type="text/javascript" src="{{ asset('assets/admin/plugins/x-editable/js/bootstrap-editable.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/admin/pages/jquery.xeditable.js') }}"></script>

    <?pgp */ ?>


    <!-- ( Jquery CDN ) -->
    <script src="{{ asset('assets/plugins/jquery/js/jquery.min.js') }}"></script>

    <!-- ( Sweet Alart 2 ) -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- ( Jquery Toast ) -->
    <script src="{{ asset('assets/plugins/toast/jquery.toast.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>

    <!-- ( Bootstrap Select Dropdown ) -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>

    <!-- ( Select2 CDN ) -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>


    @if ($checkOne == 'loginPage')
        <!-- Custom JS -->
        <script src="{{ asset('assets/admin/js/custom_js/custom_login.js') }}"></script>

        <!--Custom Ajax-->
        <script src="{{ asset('assets/admin/js/ajax/custom_ajax_login.js') }}"></script>

        <!-- particles js -->
        <script src="{{ asset('assets/plugins/particles.js/particles.js') }}"></script>

        <!-- particles app js -->
        <script src="{{ asset('assets/admin/js/pages/particles.app.js') }}"></script>

        <!-- password-addon init -->
        <script src="{{ asset('assets/admin/js/pages/password-addon.init.js') }}"></script>
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

        <!--flatpickr Js-->
        <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>

        <!-- Dashboard init -->
        <script src="{{ asset('assets/admin/js/pages/dashboard-ecommerce.init.js') }}"></script>


        <!-- prismjs plugin -->
        {{-- <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script> --}}

        <!-- App js -->
        <script src="{{ asset('assets/admin/js/app.js') }}"></script>


        <!-- Custom Ajax -->
        <script src="{{ asset('assets/admin/js/ajax/datatable_ajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/ajax/custom_ajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/ajax/filter_ajax.js') }}"></script>
        <script src="{{ asset('assets/admin/js/ajax/ddd_ajax.js') }}"></script>

        <!-- Custom JS -->
        <script src="{{ asset('assets/admin/js/custom_js/common.js') }}"></script>
        {{-- <script src="{{asset('assets/admin/custom_js/color_picker.js')}}"></script> --}}
        {{-- <script src="{{ asset('assets/admin/js/custom_js/editor.js') }}"></script> --}}
        <script src="{{ asset('assets/admin/js/custom_js/sortable.js') }}"></script>
        <script src="{{ asset('assets/admin/js/custom_js/custom.js') }}"></script>
    @endif













    {{-- <script src="https://kit.fontawesome.com/af2e2dafde.js" crossorigin="anonymous"></script> --}}




    {{-- <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script> --}}



    {{-- <script>
        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this);
            $(".add-field", $(this)).click(function(e) {
                $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('')
                    .focus();
            });
            $('.multi-field .remove-field', $wrapper).click(function() {
                if ($('.multi-field', $wrapper).length > 1) $(this).parent('.multi-field').remove();
            });
        });
    </script> --}}

    <!--For Dashboard-->
    {{-- <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 100,
                time: 1200
            });
            $(".knob").knob();
        });
    </script> --}}


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    {{-- <script>
        $(document).ready(function() {

            $('#updatePermissionBtnTop').click(function() {
                $(this).closest('.row').find('form').trigger('submit');
            });

            $('.PermiAll').click(function() {
                $('#CheckAll').trigger('click');
            });

            setTimeout(() => {
                $('.checkbox').lc_switch();
            }, 3000);

            $('#CheckAll').change(function() {
                if ($(this).prop("checked") == true) {
                    $('.checkbox').lcs_on();
                    $('.checkbox').val(1);
                } else if ($(this).prop("checked") == false) {
                    $('.checkbox').val(0);
                    $('.checkbox').lcs_off();
                }
            });

            $('#updatePermissionForm').delegate('.lcs_switch', 'click', function() {
                var val = $(this).closest('.lcs_wrap').find('.checkbox').val();
                if (val == 1) {
                    $(this).closest('.lcs_wrap').find('.checkbox').val(0);
                } else {
                    $(this).closest('.lcs_wrap').find('.checkbox').val(1);
                }
            });

        });
    </script> --}}

@endif
