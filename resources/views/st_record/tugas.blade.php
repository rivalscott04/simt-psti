@extends('layout')

@section('side-menu')
<!-- <li>
    <a href="/st/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li> -->
<li>
    <a href="/st/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugasMasuk > 0)
        <span class="label label-warning float-right">{{ $jumlahTugasMasuk }}</span>
        @endif
    </a>
</li>
<li class="active">
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
            <h2>Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Tugas</strong>
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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tugas</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="/st/tugas" method="get">
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
                        <div class="table-responsive">
                            @if ($semuaTugas->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="min-width: 200px;">
                                            Keterangan
                                        </th>
                                        <th style="width: 400px; min-width: 300px;">Tenggat Waktu</th>
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
                                        <th style="min-width: 300px;">
                                            Keterangan
                                        </th>
                                        <th style="width: 400px; min-width: 300px;">Tenggat Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaTugas as $tugas)
                                    <tr>
                                        <td>
                                            <p>
                                                {{ $tugas->perihal }}
                                            </p>
                                            <a href="{{ route('st.updatePerkembangan', ['id_tugas' => $tugas->id_tugas] ) }}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-edit"></i>
                                                &nbsp;
                                                Update Perkembangan Tugas
                                            </a>
                                        </td>
                                        <td>
                                            <label for="create_at" class="text-success" style="font-weight: 600;">
                                                {{ $tugas->nama_hari }}, {{ $tugas->tanggal }}, {{ $tugas->jam }} WITA
                                            </label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
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