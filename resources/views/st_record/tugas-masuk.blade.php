@extends('layout')

@section('side-menu')
<!-- <li>
    <a href="/st/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li> -->
<li class="active">
    <a href="/st/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugasMasuk > 0)
        <span class="label label-warning float-right">{{ $jumlahTugasMasuk }}</span>
        @endif
    </a>
</li>
<li>
    <a href="/st/tugas"><i class="fa fa-file-o"></i>
        <span class="nav-label">Tugas</span></a>
</li>
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
            <h2>Tugas Masuk</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Tugas Masuk</strong>
                </li>
            </ol>
        </div>
    </div>
    <!-- pesan kesalahan -->
    @if(session()->has('success'))
    <br>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-check"></i>
        &nbsp;
        {{ session('success') }}
    </div>
    @endif

    @if(session()->has('error'))
    <br>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-check"></i>
        &nbsp;
        {{ session('error') }}
    </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tugas Masuk</h5>
                    </div>
                    <div class="ibox-content">
                        <form role="form" action="/st/tugas-masuk" method="get">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="search" style="font-weight: bold;">Keterangan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="search" class="form-control" name="search">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br /><br />
                        <!-- <form role="form" method="post" action=""> -->
                        <div class="table-responsive">
                            @if ($semuaTugas->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="max-width: 300px;">
                                            Pengirim
                                        </th>
                                        <th style="min-width: 200px;">Keterangan</th>
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
                                        <th style="min-width: 400px;">
                                            Pengirim
                                        </th>
                                        <th style="min-width: 700px;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaTugas as $tugas)
                                    <tr>
                                        <td nowrap="">
                                            <label for="user_id" class="text-navy">
                                                <i class="fa fa-exchange">
                                                </i>
                                                &nbsp;
                                                {{ $tugas->nama_pengirim}}
                                                <!-- {{ $tugas->user_id }} -->
                                            </label>
                                            <br>
                                            <label for="create_at" class="text-success" style="font-weight: bold;">
                                                {{ $tugas->formattedDate }}
                                            </label>
                                        </td>
                                        <!-- Sampai sini, waktu yang tampil masih keliru -->

                                        <td>
                                            <p>
                                                {{ $tugas->perihal }}
                                            </p>
                                            <!-- <a href="{{ url('s/tugas-masuk', ['id_tugas' => $tugas->id_tugas]) }}" -->
                                            <a href="{{ route('st.show', ['tugas' => $tugas->id_tugas] ) }}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;
                                                Buka
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            <!-- <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="max-width: 300px;">
                                            Pengirim
                                        </th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td nowrap="">
                                            <label for="nama_pengirim" class="text-navy">
                                                <span class="fa fa-exchange">

                                                </span>
                                                &nbsp;
                                                Nama Pengirim
                                            </label>
                                            <br>
                                            <label for="timestamp_penambahan" class="text-success"
                                                style="font-weight: bold;">
                                                7 Mar 2023, 9:49
                                                am
                                            </label>
                                        </td>
                                        <td nowrap="">
                                            <p>
                                                Keterangan terkait perihal tugas yang diajukan
                                            </p>

                                            <a href="/st/detail-tugas-masuk" class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;Buka
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> -->
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