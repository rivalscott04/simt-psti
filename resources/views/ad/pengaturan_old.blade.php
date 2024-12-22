@extends('layout')
@section('side-menu')
<!-- <li>
    <a href="/st/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li> -->
<!-- <li>
    <a href="/st/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
    </a>
</li> -->
<li class="active">
    <a href="/ad/pengaturan"><i class="fa fa-cog"></i>
        <span class="nav-label">Pengaturan</span></a>
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
                    <a href="/ad/pengaturan">
                        <strong>Pengaturan</strong>
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
                        <form action="/ad/pengaturan" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Kaprodi -->
                            <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_kaprodi">
                                    Kaprodi
                                </label>
                                <div class="col-md-6">
                                    <select id="nama_pengguna_kaprodi" name="nama_pengguna_kaprodi"
                                        class="select2_demo_3 form-control" required>
                                    </select>
                                    <br>
                                </div>
                            </div>

                            <!-- Sekprodi -->
                            <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_sekprodi">
                                    Sekprodi
                                </label>
                                <div class="col-md-6">
                                    <select id="nama_pengguna_sekprodi" name="nama_pengguna_sekprodi"
                                        class="select2_demo_3 form-control" required>
                                    </select>
                                    <br>
                                </div>
                            </div>

                            <!-- Kalab -->
                            <!-- <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_kalab">
                                    Kalab
                                </label>
                                <div class="col-md-6">
                                    <select id="select2" name="nama_pengguna_kalab" class="select2_demo_3 form-control" required>
                                    </select>
                                    <br>
                                </div>
                            </div> -->

                            <!-- Kalab -->
                            <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_kalab">
                                    Kalab
                                </label>
                                <div class="col-md-6">
                                    <select class="select2_demo_3 form-control" id="nama_pengguna_kalab"
                                        name="nama_pengguna_kalab[]" multiple="multiple">
                                    </select>
                                    <br>
                                </div>
                            </div>

                            <!-- AdHoc -->
                            <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_adhoc">
                                    AdHoc
                                </label>
                                <div class="col-md-6">
                                    <select class="select2_demo_3 form-control" id="nama_pengguna_adhoc"
                                        name="nama_pengguna_adhoc[]" multiple="multiple">
                                    </select>
                                    <br>
                                </div>
                            </div>

                            <!-- Dosen -->
                            <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_dosen">
                                    Dosen
                                </label>
                                <div class="col-md-6">
                                    <select class="select2_demo_3 form-control" id="nama_pengguna_dosen"
                                        name="nama_pengguna_dosen[]" multiple="multiple">
                                    </select>
                                    <br>
                                </div>
                            </div>

                            <!-- Staf -->
                            <div class="form-group row">
                                <label class="col-md-2 label1" for="nama_pengguna_staf">
                                    Staf
                                </label>
                                <div class="col-md-6">
                                    <select class="select2_demo_3 form-control" id="nama_pengguna_staf"
                                        name="nama_pengguna_staf[]" multiple="multiple">
                                    </select>
                                    <br>
                                </div>
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

        // Ambil nilai id_tugas dari atribut data
        // var id_tugas = document.getElementById('id_tugas').dataset.id;

        // $("#todo_list").select2({
        //     // Mengambil peran yang dipilih
        //     var role = $('input[name="role"]:checked').val(),
        //     placeholder: 'Cari & Pilih',
        //     ajax: {
        //         url: "{{ url('getTask')}}/" + id_tugas,
        //         // url: "{{url('getUser')}}/" + role,
        //         processResults: function ({ data }) {
        //             return {
        //                 results: $.map(data, function (item) {
        //                     return {
        //                         id: item.todo_list,
        //                         text: item.todo_list,
        //                     }
        //                 })
        //             }
        //         }
        //     },
        // });

        // $('.icheck').on('ifChecked', function (event) {

        // Mengambil peran yang dipilih
        // var id_tugas = $('input[name="id_tugas"]').val();

        // $("#todo_list").select2({
        //     placeholder: 'Pilih',
        //     ajax: {
        //         url: "{{url('getTask')}}/" + id_tugas,
        //         processResults: function ({ data }) {
        //             return {
        //                 results: $.map(data, function (item) {
        //                     return {
        //                         id: item.todo_list,
        //                         text: item.todo_list,
        //                     }
        //                 })
        //             }
        //         }
        //     },
        // });
        // });

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