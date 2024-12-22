@extends('layout')

@section('side-menu')
<li class="active">
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
<li>
    <a href="/s/statistik-tugas"><i class="fa fa-pie-chart"></i>
        <span class="nav-label">Statistik Tugas</span></a>
</li>
<li>
    <a href="/s/ad-hoc"><i class="fa fa-user"></i>
        <span class="nav-label">Ad Hoc</span></a>
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
            <h2>Delegasi Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/s/delegasi-tugas">
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
                        <h5>Daftar Delegasi Tugas</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="/s/delegasi-tugas" method="get">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="perihal" style="font-weight: bold;">Keterangan/Tujuan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="search" class="form-control" name="search">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-8" style="padding-top: 7px; padding-left: 7px;">
                                    <br />
                                    &nbsp;
                                    <a href="/s/tambah-delegasi-tugas" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                        &nbsp;Tambah
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- <div class="row">
                            <div class="col-md-6 col-lg-8" style="padding-top: 7px; padding-left: 7px;">
                                
                                &nbsp;
                                <a href="/s/tambah-delegasi-tugas" class="btn btn-primary">
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
                                            <a href="{{ route('s.riwayatTugas', $tugas->id_tugas)}}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;Riwayat
                                            </a>
                                            &nbsp;


                                            <!-- <a href="/s/riwayat-tugas/{id_tugas}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;Riwayat
                                            </a>
                                            &nbsp;
                                              -->
                                            <!-- Button edit tugas -->
                                            @if ($tugas->ket_tujuan == 'ditolak')
                                            <a href="{{ route('s.edit', $tugas->id_tugas) }}"
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

        <!-- Tabel Daftar Teruskan Tugas -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Daftar Teruskan Tugas</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="/s/delegasi-tugas" method="get">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="searchTeruskan" style="font-weight: bold">Keterangan/Tujuan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="search" class="form-control" name="searchTeruskan">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <br /><br />
                        <div class="table-responsive">
                            @if ($semuaTugasTeruskan->isEmpty())
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

                                    @foreach ($semuaTugasTeruskan as $tugasTeruskan)
                                    <tr>
                                        <td>
                                            <label for="create_at" class="text-success">
                                                <span style="font-weight: bold;">
                                                    {{ $tugasTeruskan->formattedDate }}
                                                </span>
                                            </label>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $tugasTeruskan->perihal }}
                                            </p>
                                            <a href="{{ route('s.riwayatTugas', $tugasTeruskan->id_tugas) }}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;Riwayat
                                            </a>
                                            &nbsp;


                                            <!-- <a href="/s/riwayat-tugas/{id_tugas}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;Riwayat
                                            </a>
                                            &nbsp; -->

                                            <!-- Button edit tugas -->
                                            <!-- DISINI -->
                                            @if ($tugasTeruskan->ket_tujuan_teruskan == 'ditolak')
                                            

                                            <a href="{{ route('s.show', ['tugas' => $tugasTeruskan->id_tugas] ) }}"
                                                class="btn btn-xs btn-warning btn-outline">
                                                <i class="fa fa-external-link"></i>
                                                &nbsp;
                                                Buka
                                            </a>

                                            @endif
                                        </td>
                                        <td nowrap>
                                            <span> {{ $tugasTeruskan->nama_tujuan_teruskan }} </span>
                                            &nbsp;
                                            @if ($tugasTeruskan->ket_tujuan_teruskan == 'menunggu_konfirmasi')
                                            <label class="label label-warning">
                                                Menunggu konfirmasi
                                            </label>
                                            @elseif ($tugasTeruskan->ket_tujuan_teruskan == 'diterima')
                                            <label class="label label-success">
                                                Diterima
                                            </label>
                                            @elseif ($tugasTeruskan->ket_tujuan_teruskan == 'diteruskan')
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
                            {{ ($jumlahTugasTeruskan) }} items
                        </span>

                        <ul class="pagination float-right">
                            {{ $semuaTugasTeruskan->withQueryString()->links() }}
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

        //FINAL
        $(".select2_demo_3").select2({
            theme: 'bootstrap4',
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
            var role_tujuan = $('input[name="role_tujuan"]:checked').val();

            $("#select2").select2({
                placeholder: 'Pilih',
                ajax: {
                    url: "{{url('getUser')}}/" + role_tujuan,
                    processResults: function ({ data }) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.nama_pengguna,
                                    text: item.nama_pengguna,
                                }
                            })
                        }
                    }
                },
            });
        });

        //END FINAL

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