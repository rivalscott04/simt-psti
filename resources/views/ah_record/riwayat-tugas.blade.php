@extends('layout')

@php
use Carbon\Carbon;
@endphp

@section('side-menu')
<li class="active">
    <a href="/ah/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li>
<li>
    <a href="/ah/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugasMasuk > 0)
        <span class="label label-warning float-right">{{ $jumlahTugasMasuk }}</span>
        @endif
    </a>
</li>
<li>
    <a href="/ah/tugas"><i class="fa fa-file-o"></i>
        <span class="nav-label">Tugas</span></a>
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
            <h2>Riwayat Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/ah/delegasi-tugas">Delegasi Tugas</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Riwayat Tugas</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

    @if(session()->has('success'))
    <br>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
        <i class="icon fa fa-check"></i>
        &nbsp;
        {{ session('success') }}
    </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="text-center  p-md">
                        <span>Turn on/off orientation version: </span>
                        &nbsp;
                        <a href="#" class="btn btn-xs btn-primary" id="leftVersion">Left version</a>
                    </div>

                    <div class="ibox-content" id="ibox-content">
                        @if ($semuaRiwayat->isNotEmpty())
                        <div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
                            @foreach ($semuaRiwayat as $riwayat)
                            @if ($riwayat instanceof App\Models\Perkembangan)
                            <div class="vertical-timeline-block">
                                @if ($riwayat->keterangan == 'incomplete')
                                <div class="vertical-timeline-icon yellow-bg">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                @elseif ($riwayat->keterangan == 'completed')
                                <div class="vertical-timeline-icon bg-success">
                                    <i class="fa fa-check"></i>
                                </div>
                                @endif

                                <div class="vertical-timeline-content">
                                    <h2>{{ $riwayat->nama_pengguna }} </h2>
                                    <p>{{$riwayat->todo_list}}
                                        &nbsp;
                                        @if ($riwayat->keterangan == 'incomplete')
                                        <label class="label label-warning">
                                            In Progress
                                        </label>
                                        @elseif ($riwayat->keterangan == 'completed')
                                        <label class="label label-success">
                                            Done
                                        </label>
                                        @endif
                                    </p>
                                    <div>
                                        @if (isset($riwayat->pihak_terlibat))
                                        <p>
                                            Pihak terlibat:
                                        </p>
                                        @php
                                        $pihak_terlibat = json_decode($riwayat->pihak_terlibat, true);
                                        @endphp

                                        @foreach ($pihak_terlibat as $nama)
                                        <label class="label">
                                            {{$nama}}
                                        </label>
                                        <br>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div>
                                        @if (isset($riwayat->url))
                                        <a href="{{$riwayat->url}}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-link"></i>
                                            &nbsp;URL
                                        </a>
                                        <p>
                                            &nbsp;
                                        </p>
                                        @endif
                                        @if (isset($riwayat->lampiran))
                                        <a href="{{ route('s.download', ['tugas' => $riwayat->lampiran]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-download"></i>
                                            &nbsp;Lampiran
                                        </a>
                                        @endif
                                    </div>
                                    <span class="vertical-date">
                                        {{ Carbon::parse($riwayat->created_at)->format('l') }}
                                        <br>
                                        <small>
                                            @php
                                            $dateString = $riwayat->created_at;
                                            $carbonDate = Carbon::parse($dateString);
                                            @endphp
                                            {{ $carbonDate->isoFormat('D MMMM YYYY, HH:mm [WITA]') }}
                                        </small>
                                    </span>
                                </div>
                            </div>
                            @elseif ($riwayat instanceof App\Models\RiwayatPenerimaan)
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon bg-primary">
                                    <i class="fa fa-thumbs-up"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>{{ $riwayat->nama_pengguna }} </h2>
                                    <p>Tugas telah diterima.
                                    </p>
                                    <!-- <a href="#" > More info</a> -->
                                    <span class="vertical-date">
                                        {{ Carbon::parse($riwayat->created_at)->format('l') }} <br />
                                        <small>
                                            @php
                                            $dateString = $riwayat->created_at;
                                            $carbonDate = Carbon::parse($dateString);
                                            @endphp
                                            {{ $carbonDate->isoFormat('D MMMM YYYY, HH:mm [WITA]') }}</small>
                                    </span>
                                </div>
                            </div>
                            @elseif ($riwayat instanceof App\Models\RiwayatPenolakan)
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon bg-danger">
                                    <i class="fa fa-hand-stop-o"></i>
                                </div>
                                <div class="vertical-timeline-content">
                                    <h2>{{ $riwayat->nama_pengguna }} </h2>
                                    <p>Tugas telah ditolak.
                                    </p>
                                    <p>
                                        Alasan penolakan:
                                        <span style="color: brown;">
                                            {{ $riwayat->alasan_penolakan}}
                                        </span>
                                    </p>
                                    <span class="vertical-date">
                                        {{ Carbon::parse($riwayat->created_at)->format('l') }} <br />
                                        <small>
                                            @php
                                            $dateString = $riwayat->created_at;
                                            $carbonDate = Carbon::parse($dateString);
                                            @endphp
                                            {{ $carbonDate->isoFormat('D MMMM YYYY, HH:mm [WITA]') }}</small>
                                    </span>
                                </div>
                            </div>
                            @elseif ($riwayat instanceof App\Models\RiwayatTeruskan)
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon bg-info">
                                    <i class="fa fa-share"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>{{ $riwayat->nama_pengirim }} </h2>
                                    <p>Tugas telah diteruskan ke {{$riwayat->nama_tujuan}}
                                    </p>
                                    <span class="vertical-date">
                                        {{ Carbon::parse($riwayat->created_at)->format('l') }} <br />
                                        <small>
                                            @php
                                            $dateString = $riwayat->created_at;
                                            $carbonDate = Carbon::parse($dateString);
                                            @endphp
                                            {{ $carbonDate->isoFormat('D MMMM YYYY, HH:mm [WITA]') }}</small>
                                    </span>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <i class="text-danger">Belum ada riwayat tugas ...</i>
                        @endif
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
    // Local script for demo purpose only
    $('#leftVersion').click(function (event) {
        event.preventDefault()
        $('#vertical-timeline').toggleClass('center-orientation');
    });
</script>
@endsection