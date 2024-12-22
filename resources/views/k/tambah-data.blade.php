@extends('layout')
@section('side-menu')
<li>
    <a href="/k/pengaturan"><i class="fa fa-cog"></i>
        <span class="nav-label">Pengaturan</span></a>
</li>
<li class="active">
    <a href="/k/ad-hoc"><i class="fa fa-user"></i>
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
            <h2>Pengaturan</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin">Pengaturan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin/create">
                        <strong>Tambah Data</strong>
                    </a>
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

    @if(session()->has('warning'))
    <br>
    <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-exclamation"></i>
        &nbsp;
        {{ session('warning') }}
    </div>
    @endif

    @if(session()->has('error'))
    <br>
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-check"></i>
        &nbsp;
        {{ session('error') }}
    </div>
    @endif

    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Pengaturan</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="/admin" enctype="multipart/form-data" method="post"
                            class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                                    <div class="form-group row">
                                        <input type="hidden" name="user_id" value="id_pengguna_disini">
                                    </div>

                                    <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                                    <div class="form-group row">
                                        <input type="hidden" name="nama_pengirim" value="nama_pengirim">
                                    </div>

                                    <!-- Input tujuan -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="tujuan">
                                            Tujuan *
                                        </label>
                                        <div class="col-sm-8">
                                            <label>
                                                <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                    value="Sekprodi">
                                                <b>Sekprodi</b>
                                            </label>
                                            &nbsp;
                                            <label>
                                                <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                    value="Kalab">
                                                <b>Kalab</b>
                                            </label>
                                            &nbsp;
                                            <label>
                                                <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                    value="AdHoc">
                                                <b>AdHoc</b>
                                            </label>
                                            &nbsp;
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
                                                <!-- Opsi akan ditambahkan melalui JavaScript -->
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1" for="perihal">
                                            Perihal * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="perihal" rows="5" name="perihal"
                                                required></textarea>
                                            <small class="text-muted"> <b>Keterangan tugas</b> </small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="tenggat_waktu_jam"> Waktu * </label>
                                        <div class="col-sm-8 col-md-5">
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                                <input type="text" name="tenggat_waktu_jam" class="form-control"
                                                    readonly>
                                                <span class="input-group-addon">
                                                    <span>WITA</span>
                                                </span>
                                            </div>
                                            <small class="text-muted"> <b>Tenggat waktu pengerjaan (jam)</b> </small>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1"
                                            for="tenggat_waktu_tanggal">
                                            Tanggal *</label>
                                        <div class="col-sm-8 col-md-5">
                                            <div class="form-group" id="data_1">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i
                                                            class="fa fa-calendar"></i></span>

                                                    <input type="text" id="data_1" name="tenggat_waktu_tanggal"
                                                        class="form-control" readonly>
                                                </div>
                                                <small class="text-muted"> <b>Tenggat waktu pengerjaan (tanggal)</b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1" for="url"> URL
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="url" name="url" class="form-control">
                                            <small class="text-muted"><b>Jika ada link tambahan terkait tugas
                                                </b>
                                                <span class="text-info"
                                                    style="font-style: italic;"><b>(opsional)</b></span>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1">
                                            Lampiran </label>
                                        <div class="col-sm-8">
                                            <div class="custom-file">
                                                <input id="inputGroupFile01" name="lampiran" type="file"
                                                    accept=".pdf,.docx,.zip,.rar" class="custom-file-input" value="{{ old('lampiran') }}">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose
                                                    file</label>
                                                <small class="text-muted"> 
                                                    <b>Berkas pendukung (
                                                        <code>pdf</code>,
                                                        <code>docx</code>,
                                                        <code>zip</code>,
                                                        <code>rar</code>)
                                                    </b>
                                                    <span class="text-info"
                                                        style="font-style: italic;"><b>(opsional)</b></span>
                                                </small>
                                            </div>


                                            <!-- <input type="file" id="lampiran" name="lampiran"
                                                accept=".pdf,.doc,.docx,.zip" class="form-control">
                                            <small class="text-muted"> <b>Opsional</b> </small> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center">
                                <button class="btn btn-success btn-outline" type="submit">
                                    <i class="fa fa-send-o"></i> &nbsp;Simpan dan Ajukan
                                </button>
                                <br>
                                <br>
                            </div>

                            <div>
                                <span style="text-align: left;">(<b>*</b>) Wajib diisi.</span>
                            </div>
                        </form>
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

        //COBA
        // Fungsi truncateFileName
        function truncateFileName() {
            const input = document.getElementById('inputGroupFile01');
            const maxLength = 30; // Atur panjang maksimal yang diinginkan

            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                if (fileName.length > maxLength) {
                    const truncatedName = `[${input.files.length}] ${fileName.slice(0, maxLength - 4)}...${fileName.slice(-4)}`;
                    input.nextElementSibling.innerHTML = truncatedName;
                } else {
                    input.nextElementSibling.innerHTML = `[${input.files.length}] ${fileName}`;
                }
            }
        }

        // Panggil fungsi truncateFileName saat file dipilih
        $('#inputGroupFile01').change(function () {
            truncateFileName();
        });
        // ENDCOBA

        // bsCustomFileInput.init()

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        //FINAL
        $(".select2_demo_1").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih",
        });
        $(".select2_demo_2").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih",
        });
        $(".select2_demo_3").select2({
            theme: 'bootstrap4',
            placeholder: "Cari & Pilih",
        });

        $("#nama_pengguna_adhoc").select2({
            placeholder: 'Cari & Pilih',
            ajax: {
                url: "{{url('ad/getAllUser')}}",
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

        $("#nama_pengguna_kalab").select2({
            placeholder: 'Cari & Pilih',
            ajax: {
                url: "{{url('ad/getAllUser')}}",
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

        $("#nama_pengguna_dosen").select2({
            placeholder: 'Cari & Pilih',
            ajax: {
                url: "{{url('ad/getAllUser')}}",
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

        $("#nama_pengguna_staf").select2({
            placeholder: 'Cari & Pilih',
            ajax: {
                url: "{{url('ad/getAllUser')}}",
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

        $('.todo-list').sortable({

            placeholder: "sort-highlight",
            handle: ".handle",
            forcePlaceholderSize: true,
            zIndex: 999999
        });
    });

</script>
@endsection