@extends('layout')

@section('side-menu')
<li>
    <a href="/s/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li>
<li>
    <a href="/s/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugasMasuk > 0)
        <span class="label label-warning float-right">{{ $jumlahTugasMasuk }}</span>
        @endif
    </a>
</li>
<li>
    <a href="/s/tugas"><i class="fa fa-file-o"></i>
        <span class="nav-label">Tugas</span></a>
</li>
<li class="active">
    <a href="/s/statistik-tugas"><i class="fa fa-pie-chart"></i>
        <span class="nav-label">Statistik Tugas</span></a>
</li>
<li>
    <a href="/s/ad-hoc"><i class="fa fa-user"></i>
        <span class="nav-label">Ad Hoc</span></a>
</li>
@endsection

@section('pesan')

@endsection


@section('page-wrapper')
<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href=""><i class="fa fa-bars"></i>
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
            <h2>Detail Statistik Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/s/statistik-tugas">Statistik Tugas</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>
                        <strong>Detail Statistik Tugas</strong>
                    </a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

    @if(session()->has('success'))
    <br>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-check"></i>
        &nbsp;
        {{ session('success') }}
    </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Daftar Tugas |
                            <span class="text-info"> {{ $nama_dosen_staf }} </span>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Tugas</th>
                                    <!-- <th>Tahun</th> -->
                                    <!-- <th data-hide="all">Tahun</th> -->
                                    <th data-hide="all">Tugas</th>
                                    <th data-hide="all">Nama Pengirim</th>
                                    <th data-hide="all">Tenggat Waktu Pengerjaan</th>
                                    <!-- <th data-hide="all">Diteruskan Oleh</th> -->
                                    <th data-hide="all">Status</th>
                                    <th style="width: 100px;">Status</th>
                                    <!-- sampe sini mau ngatur besar kolom status -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semuaTugas as $tugas)
                                <tr>
                                    <td>{{ $tugas->perihal }}</td>
                                    <td>{{ $tugas->perihal }}</td>
                                    <td>{{ $tugas->nama_pengirim }}</td>
                                    <td>{{ $tugas->nama_hari }}, {{ $tugas->tanggal }}</td>
                                    <!-- <td>{{ $tugas->nama_pengirim }}</td> -->
                                    <td>
                                        @if($tugas->keterangan == 'completed')
                                        <label for="keterangan" class="text-success" style="font-weight: bold;">
                                            completed
                                        </label>
                                        @else
                                        <label for="keterangan" class="text-warning" style="font-weight: bold;">
                                            incomplete
                                        </label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tugas->keterangan == 'completed')
                                        <label class="label label-success">
                                            Completed
                                        </label>
                                        @else
                                        <label class="label label-warning">
                                            incomplete
                                        </label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div>
            <strong>Copyright</strong> Program Studi Teknik Informatika -- Universitas Mataram &copy; 2023
        </div>
    </div>
</div>
@endsection


@section('isi-js')
<script>
    $(document).ready(function () {
        $("body").scrollspy({
            target: "#navbar",
            offset: 80,
        });

        // Page scrolling feature
        $("a.page-scroll").bind("click", function (event) {
            var link = $(this);
            $("html, body")
                .stop()
                .animate(
                    {
                        scrollTop:
                            $(link.attr("href")).offset().top - 50,
                    },
                    500
                );
            event.preventDefault();
            $("#navbar").collapse("hide");
        });
    });

    var cbpAnimatedHeader = (function () {
        var docElem = document.documentElement,
            header = document.querySelector(".navbar-default"),
            didScroll = false,
            changeHeaderOn = 200;
        function init() {
            window.addEventListener(
                "scroll",
                function (event) {
                    if (!didScroll) {
                        didScroll = true;
                        setTimeout(scrollPage, 250);
                    }
                },
                false
            );
        }
        function scrollPage() {
            var sy = scrollY();
            if (sy >= changeHeaderOn) {
                $(header).addClass("navbar-scroll");
            } else {
                $(header).removeClass("navbar-scroll");
            }
            didScroll = false;
        }
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();
    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();

    $('.footable').footable();
    $('.footable2').footable();
</script>

@endsection