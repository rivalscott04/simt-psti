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
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i>
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
            <h2>Edit Delegasi Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/k/delegasi-tugas">Delegasi Tugas</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Edit</strong>
                </li>
            </ol>
        </div>
    </div>

    @if ($errors->any())
    <br>
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <div>
            <i class="icon fa fa-times"></i>
            &nbsp;
            {{ $error }}
        </div>
        @endforeach
    </div>
    @endif

    @if(session()->has('success'))
    <br>
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ">
                    <div class="ibox-title back-change">
                        <h5>Edit Delegasi Tugas</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <form action="{{ route('k.update', ['id_tugas' => $tugas->id_tugas])}}"
                            enctype="multipart/form-data" method="post" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                                    <div class="form-group row">
                                        <input type="hidden" name="user_id" value="id_pengguna_disini">
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
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1" for="perihal">
                                            Perihal * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="perihal" rows="5" name="perihal"
                                                required>
                                            </textarea>
                                            <small class="text-muted"> <b>Keterangan tugas</b> </small>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1"
                                            for="tenggat_waktu_tanggal">
                                            Deadline (tanggal) *</label>
                                        <div class="col-sm-8 col-md-5">
                                            <div class="form-group" id="data_1">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i
                                                            class="fa fa-calendar"></i></span>

                                                    <input type="text" id="data_1" name="tenggat_waktu_tanggal"
                                                        class="form-control" value="{{ $tanggalFormatted }}" readonly>
                                                </div>
                                                <small class="text-muted"> <b>Tenggat waktu pengerjaan
                                                        (<code>tanggal</code>)</b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="tenggat_waktu_jam"> Deadline (jam) * </label>
                                        <div class="col-sm-8 col-md-5">
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                                <input type="text" name="tenggat_waktu_jam" class="form-control"
                                                    value="{{ $jam }}" readonly>
                                                <span class="input-group-addon">
                                                    <span>WITA</span>
                                                </span>
                                            </div>
                                            <small class="text-muted"> <b>Tenggat waktu pengerjaan
                                                    (<code>jam</code>)</b> </small>
                                        </div>
                                    </div>

                                    <div class="form-group row"> <label class="col-sm-4 label1" for="url"> URL
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="url" name="url" class="form-control"
                                                value="{{$tugas->url}}">
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
                                                    accept=".pdf,.docx,.zip,.rar,.png,.jpg,.jpeg"
                                                    class="custom-file-input">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose
                                                    file
                                                </label>
                                                @if (isset($tugas->lampiran))
                                                <small class="text-muted">
                                                    <a href="{{ route('k.download', ['tugas' => $tugas->lampiran]) }}">
                                                        <i class="fa fa-download"></i>
                                                        &nbsp;Download
                                                    </a>
                                                </small>
                                                &nbsp;—&nbsp;
                                                @endif
                                                <small class="text-muted">
                                                    <b>Berkas pendukung (
                                                        <code>pdf</code>,
                                                        <code>docx</code>,
                                                        <code>zip</code>,
                                                        <code>rar</code>,
                                                        <code>png</code>,
                                                        <code>jpg</code>,
                                                        <code>jpeg</code>)
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
        var perihal = "{{ $perihal }}".trim();
        $("#perihal").val(perihal);

        // bsCustomFileInput.init()

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

        $('.clockpicker').clockpicker({
            // placeholder: "{{ $tugas->tenggat_waktu_jam }}",
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            afterDone: function () {
                var tenggat_waktu_jam = this.value;
            }
        });

        var mem = $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            afterDone: function () {
                var tenggat_waktu_tanggal = this.value;
            }
        });

        //FINAL
        $(".select2_demo_3").select2({
            placeholder: '{{$tujuan}}',
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
    });

    // Validasi form sebelum dikirimkan
    $('form').submit(function () {
        // var waktuInput = $('#waktu').val();
        if (!tenggat_waktu_jam) {
            alert('Jam harus diisi.');
            return false; // Jika waktu tidak diisi, form tidak akan dikirimkan
        }

        if (!tenggat_waktu_tanggal) {
            alert('Tanggal harus diisi.');
            return false; // Jika waktu tidak diisi, form tidak akan dikirimkan
        }
    });
</script>
@endsection