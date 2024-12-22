@extends('layout')

@section('side-menu')
<li class="active">
    <a href="/k/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li>
<li>
    <a href="/k/statistik-tugas"><i class="fa fa-pie-chart"></i>
        <span class="nav-label">Statistik Tugas</span></a>
</li>
<li>
    <a href="/k/ad-hoc"><i class="fa fa-user"></i>
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
                <li style="padding: 20px">
                    <span class="m-r-sm text-muted welcome-message">Welcome to <strong>SIMT PSTI</strong> - Universitas
                        Mataram.</span>
                </li>
                <li>
                    <!-- <form action="/logout" method="post">
                                @csrf
                                <button type="submit">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    Keluar
                                </button>
                            </form> -->
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
                    <a href="/k/delegasi-tugas">
                        <strong>Delegasi Tugas</strong>
                    </a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <!-- Disini -->

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
                        <h5>Delegasi Tugas</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="/k/delegasi-tugas" method="get">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="search" style="font-weight: bold">Keterangan / Tujuan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-8" style="padding-top: 7px; padding-left: 7px;">
                                    <br />
                                    &nbsp;
                                    <a href="/k/tambah-delegasi-tugas" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                        &nbsp;Tambah
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- <div class="row">
                            <div class="col-md-6 col-lg-8" style="padding-top: 7px; padding-left: 7px;">
                                &nbsp;
                                <a href="/k/tambah-delegasi-tugas" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    &nbsp;Tambah
                                </a>
                            </div>
                        </div> -->
                        <br />
                        <div class="table-responsive">
                            @if ($semuaTugas->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="min-width: 200px;">
                                            Waktu
                                        </th>
                                        <th style="min-width: 200px;">Keterangan</th>
                                        <th>Tujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <i class="text-danger">Tidak ada tugas ...</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="min-width: 200px;">
                                            Waktu
                                        </th>
                                        <th style="min-width: 200px;">Keterangan</th>
                                        <th>Tujuan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($semuaTugas as $tugas)
                                    <tr>
                                        <td>
                                            <label for="create_at" class="text-success">
                                                <span style="font-weight: bold;">
                                                    {{ $tugas->formattedDate }}
                                                </span>
                                            </label>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $tugas->perihal }}
                                            </p>
                                            <a href="{{ route('k.riwayatTugas', $tugas->id_tugas)}}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;Riwayat
                                            </a>
                                            &nbsp;

                                            <!-- Edit tugas -->
                                            <!-- <a href="/k/tambah-delegasi-tugas/{id_tugas}" class="btn btn-primary">Edit</a>                                                
                                            <i class="fa fa-edit"></i>
                                                &nbsp;Edit
                                            </a> -->

                                            @if ($tugas->ket_tujuan == 'ditolak')
                                            <a href="{{ route('k.edit', $tugas->id_tugas) }}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-edit"></i>
                                                &nbsp;Edit
                                            </a>
                                            @endif
                                        </td>
                                        <td nowrap>
                                            <span> {{ $tugas->tujuan }} </span>
                                            &nbsp;
                                            @if ($tugas->ket_tujuan == 'menunggu_konfirmasi')
                                            <label class="label label-warning">
                                                Menunggu konfirmasi
                                            </label>
                                            @elseif ($tugas->ket_tujuan == 'diterima')
                                            <label class="label label-success">
                                                Diterima
                                            </label>
                                            @elseif ($tugas->ket_tujuan == 'diteruskan')
                                            <label class="label label-info">
                                                Diteruskan
                                            </label>
                                            @else
                                            <label class="label label-danger">
                                                Ditolak
                                            </label>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <!-- </form> -->
                    </div>
                    <div class="ibox-footer">
                        <span class="text-muted">
                            {{ ($jumlahTugas) }} items
                        </span>

                        <ul class="pagination float-right">
                            {{ $semuaTugas->withQueryString()->links() }}
                        </ul>
                        <div class="clearfix"></div>
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
        // $('.demo1').click(function () {
        //     swal({
        //         title: "Alasan Penolakan",
        //         text: "{{$alasan_penolakan}}"
        //     });
        // });

        let toast = $('.toast');

        setTimeout(function () {
            toast.toast({
                delay: 5000,
                animation: true
            });
            toast.toast('show');

        }, 2200);

    });
    $(window).bind("scroll", function () {
        let toast = $('.toast');
        toast.css("top", window.pageYOffset + 20);

    });
</script>

@endsection