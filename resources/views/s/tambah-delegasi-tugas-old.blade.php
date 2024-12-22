<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Advanced Form Elements</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="../css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="../css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="../css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="../css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="../css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">
    <link href="../css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="../css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="../css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="../css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="../css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    <link href="../css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="../css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="../css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="../css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">


</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element text-center">
                            <img alt="image" class="img-rounded" src="../img/logo_unram.png" style="max-width: 75px" />
                            <br /><br />

                            <h4 class="block m-t-xs font-bold" style="color: aliceblue;" nowrap="">
                                NAMA
                            </h4>
                            <p class="text-muted text-xs block">
                                Sekprodi
                            </p>
                        </div>
                        <div class="logo-element">PSTI</div>
                    </li>
                    <li class="active">
                        <a href="/s/delegasi-tugas"><i class="fa fa-list-alt"></i>
                            <span class="nav-label">Delegasi Tugas</span></a>
                    </li>
                    <li>
                        <a href="/s/tugas-masuk"><i class="fa fa-envelope"></i>
                            <span class="nav-label">Tugas Masuk</span></a>
                    </li>
                    <li>
                        <a href="/s/tugas"><i class="fa fa-file-o"></i>
                            <span class="nav-label">Tugas</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href=""><i
                                class="fa fa-bars"></i>
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="/login" style="padding-right: 20px;">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Tambah Delegasi Tugas</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/s/delegasi-tugas">Delegasi Tugas</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Tambah</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox ">
                            <div class="ibox-title back-change">
                                <h5>Tambah Delegasi Tugas</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="ibox-content">
                                <form action="/s/tambah-delegasi-tugas" enctype="multipart/form-data" method="post"
                                    class="form-horizontal">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 label1" for="tujuan">
                                                    Tujuan *
                                                </label>
                                                <div class="col-sm-8">
                                                    <label>
                                                        <input type="radio" class="radio-inline icheck" name="role"
                                                            value="Kalab">
                                                        <b>Kalab</b>
                                                    </label>
                                                    &nbsp;
                                                    <label>
                                                        <input type="radio" class="radio-inline icheck" name="role"
                                                            value="AdHoc">
                                                        <b>AdHoc</b>
                                                    </label>
                                                    &nbsp;
                                                    <label>
                                                        <input type="radio" class="radio-inline icheck" name="role"
                                                            value="Dosen">
                                                        <b>Dosen</b>
                                                    </label>
                                                    &nbsp;
                                                    <label>
                                                        <input type="radio" class="radio-inline icheck" name="role"
                                                            value="Staf">
                                                        <b>Staf</b>
                                                    </label>
                                                    <br><br>
                                                    <select id="select2" class="select2_demo_3 form-control">
                                                        <!-- Opsi akan ditambahkan melalui JavaScript -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row"> <label class="col-sm-4 label1" for="perihal">
                                                    Perihal * </label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="perihal" rows="5"
                                                        name="perihal"></textarea>
                                                    <small class="text-muted"> <b>Keterangan Tugas</b> </small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 label1" for="tenggat_waktu_jam"> Waktu * </label>
                                                <div class="col-sm-8 col-md-5">
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                        <input type="text" class="form-control" value="">
                                                        <span class="input-group-addon">
                                                            <span>WITA</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row"> <label class="col-sm-4 label1"
                                                    for="tenggat_waktu_tanggal">
                                                    Tanggal *</label>
                                                <div class="col-sm-8 col-md-5">
                                                    <div class="form-group" id="data_1">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span><input type="text"
                                                                class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row"> <label class="col-sm-4 label1" for="url"> URL
                                                </label>
                                                <div class="col-sm-8"> <input type="text" id="url" class="form-control"
                                                        value="">
                                                    <small class="text-muted"> <b>Jika ada link tambahan terkait tugas
                                                        (opsional)</b></small>
                                                </div>
                                            </div>
                                            <div class="form-group row"> <label class="col-sm-4 label1" for="lampiran">
                                                    Lampiran </label>
                                                <div class="col-sm-8">
                                                    <input type="file" id="ta_laporan" name="ta_laporan"
                                                        accept=".pdf,.doc,.docx,.zip" class="form-control">
                                                    <small class="text-muted"> <b>Opsional</b> </small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-success btn-outline" type="submit" name="__save"
                                            value="__save">
                                            <i class="fa fa-send-o"></i> &nbsp;Simpan dan Ajukan
                                        </button>
                                        <br>
                                        <br>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- JSKnob -->
    <script src="../js/plugins/jsKnob/jquery.knob.js"></script>

    <!-- Input Mask-->
    <script src="../js/plugins/jqueryMask/jquery.mask.min.js"></script>

    <!-- Data picker -->
    <script src="../js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- NouSlider -->
    <script src="../js/plugins/nouslider/jquery.nouislider.min.js"></script>

    <!-- Switchery -->
    <script src="../js/plugins/switchery/switchery.js"></script>

    <!-- IonRangeSlider -->
    <script src="../js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

    <!-- iCheck -->
    <script src="../js/plugins/iCheck/icheck.min.js"></script>

    <!-- MENU -->
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Color picker -->
    <script src="../js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <!-- Clock picker -->
    <script src="../js/plugins/clockpicker/clockpicker.js"></script>

    <!-- Image cropper -->
    <script src="../js/plugins/cropper/cropper.min.js"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="../js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Select2 -->
    <script src="../js/plugins/select2/select2.full.min.js"></script>

    <!-- TouchSpin -->
    <script src="../js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Tags Input -->
    <script src="../js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Dual Listbox -->
    <script src="../js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>

    <script>
        $(document).ready(function () {

            $('.tagsinput').tagsinput({
                tagClass: 'label label-primary'
            });

            var $image = $(".image-crop > img")
            var $cropped = $($image).cropper({
                aspectRatio: 1.618,
                preview: ".img-preview",
                done: function (data) {
                    // Output the result data for cropping image.
                }
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function () {
                    var fileReader = new FileReader(),
                        files = this.files,
                        file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#download").click(function (link) {
                link.target.href = $cropped.cropper('getCroppedCanvas', { width: 620, height: 520 }).toDataURL("image/png").replace("image/png", "application/octet-stream");
                link.target.download = 'cropped.png';
            });


            $("#zoomIn").click(function () {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function () {
                $image.cropper("zoom", -0.1);
            });

            $("#rotateLeft").click(function () {
                $image.cropper("rotate", 45);
            });

            $("#rotateRight").click(function () {
                $image.cropper("rotate", -45);
            });

            $("#setDrag").click(function () {
                $image.cropper("setDragMode", "crop");
            });

            var mem = $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            var yearsAgo = new Date();
            yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

            $('#selector').datepicker('setDate', yearsAgo);


            $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy"
            });

            $('#data_3 .input-group.date').datepicker({
                startView: 2,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#data_4 .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
            });

            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            // var elem = document.querySelector('.js-switch');
            // var switchery = new Switchery(elem, { color: '#1AB394' });

            // var elem_2 = document.querySelector('.js-switch_2');
            // var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

            // var elem_3 = document.querySelector('.js-switch_3');
            // var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

            // var elem_4 = document.querySelector('.js-switch_4');
            // var switchery_4 = new Switchery(elem_4, { color: '#f8ac59' });
            // switchery_4.disable();



            $('.demo1').colorpicker();

            var divStyle = $('.back-change')[0].style;
            $('#demo_apidemo').colorpicker({
                color: divStyle.backgroundColor
            }).on('changeColor', function (ev) {
                divStyle.backgroundColor = ev.color.toHex();
            });

            $('.clockpicker').clockpicker();

            $('input[name="daterange"]').daterangepicker();

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: { days: 60 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });



            //FINAL
            $(".select2_demo_1").select2({
                theme: 'bootstrap4',
            });
            $(".select2_demo_2").select2({
                theme: 'bootstrap4',
            });
            $(".select2_demo_3").select2({
                theme: 'bootstrap4',
                placeholder: "Pilih",
                allowClear: true
            });
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            // Mendengarkan perubahan pada radio button
            $('.icheck').on('ifChecked', function (event) {
                // Menghapus opsi sebelumnya dari Select2
                $('#select2').empty();

                // Mengambil peran yang dipilih
                var role = $('input[name="role"]:checked').val();

                $("#select2").select2({
                    placeholder: 'Pilih',
                    ajax: {
                        url: "{{url('getUser')}}/" + role,
                        processResults: function ({ data }) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.name,
                                        text: item.nama_pengguna
                                    }
                                })
                            }
                        }
                    }
                });
            });
            //END FINAL

            // pengambilan data select dari database SIA menggunakan API

            // $('.__pengguna').select2({
            //     ajax: { 
            //         url: function () { 
            //             return $('.__jenis:checked').attr('data-api-path'); 
            //         },
            //         dataType: 'json', 
            //         data: function (params) {

            //             console.log($('.__jenis:checked').attr('data-api-path')); return { 
            //                 __csrf_token: "971d06dbd4a3ca36bcef5be6722acb79", nama: params.term, number: 100 
            //             } }, processResults: function (response) { var results = []; $.each(response, function (index, item) { results.push({
            //                  id: item.id, text: item.nama, nip: item.nip, prodi: item.prodi, 
            //                 }); }); return {
            //                      results: results 
            //                     } }, cache: true 
            //                 }, placeholder: 'Pilih', escapeMarkup: function (markup) {
            //                      return markup; 
            //                     }, minimumInputLength: 1, templateResult: function (item) {
            //                      if (item.loading) 
            //                      return item.text; 
            //                      return '<strong>' + item.text + '</strong><br/>' + '<small>' + item.prodi + '</small><br/>' + '<small>' + item.nip + '</small>'; 
            //                     },
            //                     templateSelection: function (item) { return item.text; 
            //                     }
            //                 });


            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $(".touchspin2").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%',
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $(".touchspin3").TouchSpin({
                verticalbuttons: true,
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $('.dual_select').bootstrapDualListbox({
                selectorMinimalHeight: 160
            });


        });



        $("#ionrange_1").ionRangeSlider({
            skin: "flat",
            min: 0,
            max: 5000,
            type: 'double',
            prefix: "$",
            maxPostfix: "+",
            grid: true
        });

        $("#ionrange_2").ionRangeSlider({
            skin: "flat",
            min: 0,
            max: 10,
            type: 'single',
            step: 0.1,
            postfix: " carats",
            grid: true
        });

        $("#ionrange_3").ionRangeSlider({
            skin: "flat",
            min: -50,
            max: 50,
            from: 0,
            postfix: "°",
            grid: true
        });

        $(".dial").knob();

        var basic_slider = document.getElementById('basic_slider');

        noUiSlider.create(basic_slider, {
            start: 40,
            behaviour: 'tap',
            connect: 'upper',
            range: {
                'min': 20,
                'max': 80
            }
        });

        var range_slider = document.getElementById('range_slider');

        noUiSlider.create(range_slider, {
            start: [40, 60],
            behaviour: 'drag',
            connect: true,
            range: {
                'min': 20,
                'max': 80
            }
        });

        var drag_fixed = document.getElementById('drag-fixed');

        noUiSlider.create(drag_fixed, {
            start: [40, 60],
            behaviour: 'drag-fixed',
            connect: true,
            range: {
                'min': 20,
                'max': 80
            }
        });


    </script>

</body>

</html>