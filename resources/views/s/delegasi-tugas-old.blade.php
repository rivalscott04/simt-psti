<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Delegasi Tugas | Sistem Informasi Monitoring Tugas</title>
    <link rel="icon" href="../img/logo_unram.png" />

    <link rel="icon" type="image/x-icon" href="../images/favicon.ico" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="../css/animate.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
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
                            <a href="/logout" style="padding-right: 20px;">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Delegasi Tugas</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Delegasi Tugas</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Delegasi Tugas</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <form role="form" method="get" action="/s/delegasi-tugas">
                                            <label for="perihal" style="font-weight: bold">Keterangan</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input type="text" id="perihal" name="perihal" value
                                                    class="form-control" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 col-lg-8" style="padding-top: 10px;">
                                        <br />
                                        &nbsp;
                                        <form action="/s/delegasi-tugas/create" method="get">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus"></i>
                                                &nbsp;Tambah
                                            </button>
                                        </form>
                                        <!-- <a href="/s/tambah-delegasi-tugas" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            &nbsp;Tambah
                                        </a> -->
                                    </div>
                                </div>
                                <br /><br />


                                <form role="get" method="post" action="">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 200px;">
                                                        Waktu
                                                    </th>
                                                    <th>Keterangan</th>
                                                    <th>Tujuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">
                                                    <td>
                                                        <label for="ttd_e8a3154cb8a9f919fe57609dfa68ced4"
                                                            class="text-success">
                                                            7 Mar 2023, 9:49
                                                            am
                                                        </label>
                                                        <br />
                                                    </td>
                                                    <td>
                                                        <p>
                                                            Keterangan terkait perihal tugas yang diajukan
                                                        </p>
                                                        <a href="/s/riwayat-tugas/id_tugas"
                                                            class="btn btn-xs btn-primary btn-outline">
                                                            <i class="fa fa-external-link"></i>
                                                            &nbsp;Riwayat
                                                        </a>
                                                    </td>
                                                    <td nowrap="">
                                                        <ol style="padding-left: 16px">
                                                            <span> Nama Tujuan </span>
                                                            &nbsp;
                                                            <label class="label label-warning"> Menunggu
                                                                konfirmasi</label>
                                                        </ol>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <label for="ttd_e8a3154cb8a9f919fe57609dfa68ced4"
                                                            class="text-success">
                                                            8 Mar 2023, 9:49
                                                            am
                                                        </label>
                                                        <br />
                                                    </td>
                                                    <td>
                                                        <p>
                                                            Keterangan terkait perihal tugas yang diajukan
                                                        </p>
                                                        <a href="/s/riwayat-tugas/id_tugas"
                                                            class="btn btn-xs btn-primary btn-outline">
                                                            <i class="fa fa-external-link"></i>
                                                            &nbsp;Riwayat
                                                        </a>
                                                    </td>
                                                    <td nowrap="">
                                                        <ol style="padding-left: 16px">
                                                            <span> Nama Tujuan </span>
                                                            &nbsp;
                                                            <label class="label label-success"> Diterima</label>
                                                        </ol>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <label for="ttd_e8a3154cb8a9f919fe57609dfa68ced4"
                                                            class="text-success">
                                                            9 Mar 2023, 9:49
                                                            am
                                                        </label>
                                                        <br />
                                                    </td>
                                                    <td>
                                                        <p>
                                                            Keterangan terkait perihal tugas yang diajukan3
                                                        </p>
                                                        <a href="/s/tambah-delegasi-tugas/id_tugas"
                                                            class="btn btn-xs btn-success btn-outline">
                                                            <i class="fa fa-edit"></i>
                                                            &nbsp;Edit
                                                        </a>
                                                        &nbsp;
                                                        <a href="/s/riwayat-tugas/id_tugas"
                                                            class="btn btn-xs btn-primary btn-outline">
                                                            <i class="fa fa-external-link"></i>
                                                            &nbsp;Riwayat
                                                        </a>
                                                    </td>
                                                    <td nowrap="">
                                                        <ol style="padding-left: 16px">
                                                            <span> Nama Tujuan </span>
                                                            &nbsp;
                                                            <label class="label label-danger"> Ditolak</label>

                                                            <p>
                                                                <a href="/s/alasan-penolakan/id_penolakan"
                                                                    class="btn btn-xs btn-info btn-outline">
                                                                    &nbsp;Lihat alasan penolakan
                                                                </a>
                                                            </p>
                                                        </ol>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="ibox-footer">
                                <span class="text-muted">
                                    33 Items
                                </span>
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li><span>«</span></li>
                                    <li class="active"><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=1">1</a>
                                    </li>
                                    <li class=""><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=2">2</a>
                                    </li>
                                    <li class=""><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=3">3</a>
                                    </li>
                                    <li><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=3">»</a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Daftar Teruskan Tugas</h5>
                            </div>
                            <div class="ibox-content">
                                <form role="form" method="post" action="">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="
                                                                min-width: 200px;
                                                            ">
                                                        Waktu
                                                    </th>
                                                    <th>Keterangan</th>
                                                    <th>Tujuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">
                                                    <td>
                                                        <label for="ttd_e8a3154cb8a9f919fe57609dfa68ced4"
                                                            class="text-success">
                                                            10 Mar 2023, 9:49
                                                            am
                                                        </label>
                                                        <br />
                                                    </td>
                                                    <td>
                                                        <p>
                                                            Keterangan terkait perihal tugas yang diajukan
                                                        </p>
                                                        <a href="/s/teruskan-tugas"
                                                            class="btn btn-xs btn-success btn-outline">
                                                            <i class="fa fa-edit"></i>
                                                            &nbsp;Edit Tujuan Teruskan
                                                        </a>
                                                    </td>
                                                    <td nowrap="">
                                                        <ol style="padding-left: 16px">
                                                            <span> Nama Tujuan </span>
                                                            &nbsp;
                                                            <label class="label label-danger"> Ditolak</label>
                                                            <p>
                                                                <a href="/s/alasan-penolakan/id_penolakan"
                                                                    class="btn btn-xs btn-info btn-outline">
                                                                    &nbsp;Lihat alasan penolakan
                                                                </a>
                                                            </p>
                                                        </ol>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="ibox-footer">
                                <span class="text-muted">
                                    33 Items
                                </span>
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li><span>«</span></li>
                                    <li class="active"><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=1">1</a>
                                    </li>
                                    <li class=""><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=2">2</a>
                                    </li>
                                    <li class=""><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=3">3</a>
                                    </li>
                                    <li><a
                                            href="https://e-sign.unram.ac.id/index.php/p/tanda-tangan?tanda_tangan_filter=-1&amp;tanda_tangan_keterangan=&amp;pengguna_kode=&amp;pengguna_nama=&amp;page=1&amp;number=15&amp;page=3">»</a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
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
        <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="../js/inspinia.js"></script>
        <script src="../js/plugins/pace/pace.min.js"></script>

        <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
</body>

</html>