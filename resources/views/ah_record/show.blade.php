@extends('layout')

@section('side-menu')
<li>
    <a href="/ah/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li>
<li class="active">
    <a href="/ah/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugas > 0)
        <span class="label label-warning float-right">{{ $jumlahTugas }}</span>
        @endif
    </a>
</li>
<li>
    <a href="/ah/tugas"><i class="fa fa-file-o"></i>
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
            <h2>Detail Tugas Masuk</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/ah/tugas-masuk">Tugas Masuk</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Detail Tugas Masuk</strong>
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
                                                {{ $tugas->nama_pengirim }}
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
                                        <p class="form-control-static">
                                            {{ $tugas->perihal }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tenggat_waktu" class="col-sm-4 label1">
                                        Tenggat Waktu
                                    </label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static text-success" style="font-weight: bold;">
                                            {{ $nama_hari }}, {{ $tanggal }}, {{ $jam }} WITA
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="url" class="col-sm-4 label1">
                                        URL
                                    </label>
                                    @if (empty($tugas->url))
                                    <div class="col-sm-8">
                                        <p class="form-control-static" style="font-style: italic;">
                                            Tidak ada url tercantum.
                                        </p>
                                    </div>
                                    @else
                                    <div class="col-sm-8">
                                        <p class="form-control-static">
                                            <a href="{{$tugas->url}}">
                                                <i class="fa fa-link"></i>
                                                &nbsp; Link Terkait Tugas
                                            </a>
                                            <br>
                                            <small class="text-muted">Klik untuk menuju link terkait tugas yang
                                                diberikan.</small>
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 label1">
                                        Lampiran
                                        <br>
                                        <small class="text-muted">Dokumen Lampiran</small>
                                    </label>
                                    @if (isset($tugas->lampiran))
                                    <div class="col-sm-8">
                                        <a href="{{ route('ah.download', ['tugas' => $tugas->lampiran]) }}">
                                            <i class="fa fa-download"></i>
                                            &nbsp;Download
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-sm-8">
                                        <p class="form-control-static" style="font-style: italic;">
                                            Tidak ada lampiran tercantum.
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="text-center">
                            @if ($tugas->ket_tujuan === 'menunggu_konfirmasi')

                            <!-- Jika tugas diterima -->
                            <form action="{{ route('ah.accept', $tugas->id_tugas) }}" method="post"
                                style="display: inline;">
                                @csrf
                                <button type='submit' class="btn btn-primary"
                                    onclick=" return confirm('Apakah anda yakin?')">
                                    <i class="fa fa-check"></i>
                                    Terima
                                </button>
                            </form>

                            <!-- FINAL Tolak Tugas  -->
                            <!-- Tombol untuk memunculkan modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#tolak">
                                <i class="fa fa-times"></i>
                                Tolak
                            </button>

                            <div class="modal inmodal" id="tolak" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tolak Tugas</h4>
                                        </div>
                                        <form action="{{ route('ah.reject', $tugas->id_tugas) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="alasan_penolakan">Alasan Penolakan</label>
                                                    <textarea class="form-control" name="alasan_penolakan" rows="3"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type='submit' class="btn btn-primary"
                                                    onclick=" return confirm('Apakah anda yakin?')">
                                                    Kirim
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Jika tugas diteruskan -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#teruskan">
                                <i class="fa fa-share"></i>
                                Teruskan
                            </button>
                            <div class="modal inmodal" id="teruskan" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tujuan Teruskan</h4>
                                        </div>
                                        <form action="{{ route('ah.forward', $tugas->id_tugas) }}" method="post"
                                            style="display: inline;">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- <label>
                                                    <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                        value="AdHoc">
                                                    <b>AdHoc</b>
                                                </label>
                                                &nbsp; -->
                                                <label>
                                                    <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                        value="Dosen">
                                                    <b>Dosen</b>
                                                </label>
                                                &nbsp;
                                                <label>
                                                    <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                        value="Staf">
                                                    <b>Staf</b>
                                                </label>
                                                <br><br>
                                                <select id="select2" name="tujuan" class="select2_demo_3 form-control"
                                                    required>
                                                </select>

                                                <!-- <label class="radio-inline i-checks" type="radio" value="Kalab"
                                                    name="role_pengguna_tujuan">
                                                    <input type="radio" value="Kalab" name="role_pengguna_tujuan"
                                                        checked>
                                                    Kalab
                                                </label>
                                                &nbsp;
                                                <label class="radio-inline i-checks" type="radio" value="Dosen"
                                                    name="role_pengguna_tujuan">
                                                    <input type="radio" value="Dosen" name="role_pengguna_tujuan">
                                                    Dosen
                                                </label>
                                                &nbsp;
                                                <label class="radio-inline i-checks" type="radio" value="Staf"
                                                    name="role_pengguna_tujuan">
                                                    <input type="radio" value="Staf" name="role_pengguna_tujuan">
                                                    Staf
                                                </label>
                                                <br><br>
                                                <select class="select2_demo_1 form-control">
                                                    <option value=""></option>
                                                </select> -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Teruskan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <br><br>

                            <!-- <form action="/ah/detail-tugas-masuk" method="post">
                                <button type='submit' class="btn btn-primary"
                                    onclick=" return confirm('Apakah anda yakin?')">
                                    Terima
                                </button> -->
                            <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#tolak">
                                    Tolak
                                </button>
                                <div class="modal inmodal" id="tolak" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <input type="text" class="form-control required">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white"
                                                    data-dismiss="modal">Cencel</button>
                                                <button type="button" class="btn btn-primary">Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                        </div>
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

<!-- Letakkan di tempat yang sesuai di dalam view Anda -->
<script>
    $(document).ready(function () {
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
                                    text: item.nama_pengguna
                                }
                            })
                        }
                    }
                },
            });
        });
        //END FINAL

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
</script>
@endsection