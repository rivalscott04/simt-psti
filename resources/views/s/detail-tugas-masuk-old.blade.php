<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Tugas Masuk | Sistem Informasi Monitoring Tugas</title>
    <link rel="icon" href="../img/logo_unram.png" />

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">
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
    <link href="../css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet"> -->
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="../css/plugins/sweetalert/sweetalert.css" rel="stylesheet">


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
                    <li>
                        <a href="/s/delegasi-tugas"><i class="fa fa-list-alt"></i>
                            <span class="nav-label">Delegasi Tugas</span></a>
                    </li>
                    <li class="active">
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
                    <h2>Detail Tugas Masuk</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/s/tugas-masuk">Tugas Masuk</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Detail Tugas Masuk</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox ">
                            <div class="ibox-title back-change">
                                <h5>Detail Tugas Masuk</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="nama_pengirim" class="col-sm-4 label1">
                                                Pengirim
                                            </label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">
                                                    <span class="fa fa-exchange text-navy">
                                                    </span>
                                                    &nbsp;
                                                    <span class="text-navy">
                                                        Nama Pengirim
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 label1">
                                                Perihal
                                                <br>
                                                <small class="text-muted">Keterangan</small>
                                            </label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static"> Keterangan </p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tenggat_waktu" class="col-sm-4 label1">
                                                Tenggat Waktu
                                            </label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">
                                                    Kamis, 18 Maret 2023, 23:59 WITA
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="url" class="col-sm-4 label1">
                                                URL
                                            </label>
                                            <div class="col-sm-8">
                                                <p class="form-control-static">
                                                    <!-- query ke atribut url pada tabel tugas dengan kondisi, jika ada maka akan muncul, jika tidak maka nilai default nya strip (-) -->
                                                    <a href="https://instagram.com/syahidjihad?igshid=YmMyMTA2M2Y=">
                                                        <i class="fa fa-link"></i>
                                                        &nbsp; Link Terkait Tugas
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 label1">
                                                Lampiran
                                                <br>
                                                <small class="text-muted">Dokumen Lampiran</small>
                                            </label>
                                            <div class="col-sm-8">
                                                <!-- query ke atribut lampiran pada tabel tugas dengan kondisi, jika ada maka akan muncul, jika tidak maka nilai default nya strip (-) -->
                                                <a href="lampiran.pdf">
                                                    <i class="fa fa-download"></i>
                                                    &nbsp;Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="text-center">
                                    <form action="/s/detail-tugas-masuk" method="post">
                                        <button type='submit' class="btn btn-primary"
                                            onclick=" return confirm('Apakah anda yakin?')">
                                            Terima
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#tolak">
                                            Tolak
                                        </button>
                                        <div class="modal inmodal" id="tolak" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content animated bounceInRight">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span
                                                                aria-hidden="true">&times;</span><span
                                                                class="sr-only">Close</span></button>

                                                        <h4 class="modal-title">Alasan Penolakan</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group"><label>Masukkan Alasan Penolakan</label>
                                                            <input type="text" class="form-control required"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white"
                                                            data-dismiss="modal">Cencel</button>
                                                        <button type="button" class="btn btn-primary">Kirim</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#teruskan">
                                            Teruskan
                                        </button>
                                        <div class="modal inmodal" id="teruskan" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content animated bounceInRight">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span
                                                                aria-hidden="true">&times;</span><span
                                                                class="sr-only">Close</span></button>

                                                        <h4 class="modal-title">Tujuan Teruskan</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="radio-inline i-checks" type="radio" value="Kalab"
                                                            name="role_pengguna_tujuan">
                                                            <input type="radio" value="Kalab"
                                                                name="role_pengguna_tujuan" checked>
                                                            Kalab
                                                        </label>
                                                        &nbsp;
                                                        <label class="radio-inline i-checks" type="radio" value="Dosen"
                                                            name="role_pengguna_tujuan">
                                                            <input type="radio" value="Dosen"
                                                                name="role_pengguna_tujuan">
                                                            Dosen
                                                        </label>
                                                        &nbsp;
                                                        <label class="radio-inline i-checks" type="radio" value="Staf"
                                                            name="role_pengguna_tujuan">
                                                            <input type="radio" value="Staf"
                                                                name="role_pengguna_tujuan">
                                                            Staf
                                                        </label>
                                                        <br><br>
                                                        <select class="select2_demo_1 form-control">
                                                            <!-- option akan disembunyikan, dan akan muncul berdasarkan kata kunci yang dimasukkan. -->
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white"
                                                            data-dismiss="modal">Cencel</button>
                                                        <button type="button" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                </div>
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

    <!-- Sweet alert -->
    <script src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <script>

        $(document).ready(function () {

            $('.demo1').click(function () {
                swal({
                    title: "Welcome in Alerts",
                    text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                });
            });

            $('.demo2').click(function () {
                swal({
                    title: "Tugas Diterima!",
                    // text: "You clicked the button!",
                    type: "success"
                });
            });

            $('.demo3').click(function () {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function () {
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                });
            });

            $('.demo4').click(function () {
                swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        } else {
                            swal("Cancelled", "Your imaginary file is safe :)", "error");
                        }
                    });
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $(".select2_demo_1").select2({
                theme: 'bootstrap4',
            });
        });
    </script>
</body>
</html>