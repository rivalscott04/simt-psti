<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }} | Sistem Informasi Monitoring Tugas</title>

    <link rel="icon" href="{{ asset('img/logo_unram.png')}}" />

    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/ionRangeSlider/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/codemirror/codemirror.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <link href="{{ url('css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
</head>

<body>
    @yield('pesan')

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element text-center">
                            <img alt="image" class="img-rounded" src="{{ asset('img/logo_unram.png')}}"
                                style="max-width: 75px" />
                            <br /><br />

                            <h4 class="block m-t-xs font-bold" style="color: aliceblue;" nowrap="">
                                {{$nama_pengguna}}
                            </h4>
                            <p class="text-muted text-xs block">
                                {{$role}}
                            </p>
                        </div>
                        <div class="logo-element">PSTI</div>
                    </li>
                    @yield('side-menu')
                </ul>
            </div>
        </nav>
        @yield('page-wrapper')
    </div>

    @yield('toast-notification')

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js')}}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js')}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- tambahan script Custom and plugin javascript untuk halaman statistik tugas -->
    <script src="{{ asset('js/plugins/wow/wow.min.js')}}"></script>

    <!-- JSKnob -->
    <script src="{{ asset('js/plugins/jsKnob/jquery.knob.js')}}"></script>

    <!-- Input Mask-->
    <script src="{{ asset('js/plugins/jqueryMask/jquery.mask.min.js')}}"></script>

    <!-- Data picker -->
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <!-- NouSlider -->
    <script src="{{ asset('js/plugins/nouslider/jquery.nouislider.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js')}}"></script>

    <!-- IonRangeSlider -->
    <script src="{{ asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js')}}"></script>

    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- MENU -->
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>

    <!-- Color picker -->
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js')}}"></script>

    <!-- Clock picker -->
    <script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}"></script>

    <!-- Image cropper -->
    <script src="{{ asset('js/plugins/cropper/cropper.min.js') }}"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

    <!-- Date range picker -->
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <!-- TouchSpin -->
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>

    <!-- Tags Input -->
    <script src="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <!-- Dual Listbox -->
    <script src="{{ asset('js/plugins/dualListbox/jquery.bootstrap-duallistbox.js')}}"></script>

    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

    <!-- BS custom file -->
    <script src="{{ asset('js/plugins/bs-custom-file/bs-custom-file-input.min.js') }}"></script>

    <!-- CodeMirror -->
    <script src="{{ asset('js/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/plugins/codemirror/mode/xml/xml.js') }}"></script>

    <!-- Sweet alert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- jquery UI -->
    <!-- <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script> -->

    <!-- Touch Punch - Touch Event Support for jQuery UI -->
    <script src="{{ asset('js/plugins/touchpunch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- FooTable -->
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    
    <!-- Tambahan buat penamaan file -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    @yield('isi-js')
    @yield('js-tambahan')
</body>

</html>