@extends('layout')
@section('side-menu')
<!-- <li>
    <a href="/d/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li> -->
<li>
    <a href="/d/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugasMasuk > 0)
        <span class="label label-warning float-right">{{ $jumlahTugasMasuk }}</span>
        @endif
    </a>
</li>
<li class="active">
    <a href="/d/tugas"><i class="fa fa-file-o"></i>
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
            <h2>Update Perkembangan Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/d/tugas">Tugas</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Update Perkembangan Tugas</strong>
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
            <div class="col-md-5">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>To-do</h3>

                        <div class="form-group row">
                            <input type="hidden" name="id_tugas" value="{{$id_tugas}}">
                        </div>

                        

                        <form action="{{ route('d.addTodoList', $id_tugas ) }}" method="post">
                            @csrf

                            <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                            <div class="form-group row">
                                <input type="hidden" name="id_perkembangan" value="default_id_perkembangan">
                            </div>

                            <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                            <div class="form-group row">
                                <input type="hidden" name="user_id" value="id_pengguna_disini">
                            </div>

                            <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                            <div class="form-group row">
                                <input type="hidden" name="keterangan" value="incomplete">
                            </div>

                            
                            <div class="input-group">
                                <input name="todo_list" type="text" placeholder="Add new subtask. "
                                    class="input form-control-sm form-control" required>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i>
                                        Add subtask</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>In Progress</h3>
                        <br>
                        <ul class="sortable-list connectList agile-list" id="todo">

                            @foreach($perkembangans as $perkembangan)
                            @if ($perkembangan->keterangan == 'incomplete')
                            <li class="warning-element" id="task1">
                                {{ $perkembangan->todo_list }}
                                <div class="agile-detail">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="text-right">
                                                <form
                                                    action="{{ route('d.perkembangan.selesai', $perkembangan->id_perkembangan) }}"
                                                    method="post">
                                                    @csrf
                                                    <button class="btn btn-xs btn-warning btn-outline" type="submit">
                                                        In progress
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @endforeach
                            @if ($perkembangans->isEmpty())
                            <i class="text-danger">Belum ada task yang ditambahkan ...</i>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Completed</h3>
                        <div class="form-group row">
                        </div>
                        <div class="form-group row">
                        </div>
                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach($perkembangans as $perkembangan)
                            @if ($perkembangan->keterangan == 'completed')
                            <li class="success-element" id="task1">
                                {{ $perkembangan->todo_list }}
                                <div class="agile-detail">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="text-right">
                                                <a href="#" class="float-right btn btn-xs btn-primary">Done</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Update Pihak Terlibat & Lampiran</h3>
                        <div class="form-group row">
                        </div>
                        <div class="form-group row">
                        </div>
                        @foreach($perkembangans as $perkembangan)

                        <form action="{{ route('d.updateLampiranPerkembangan', $id_tugas ) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 label1" for="todo_list">
                                    Task *
                                </label>
                                <div class="col-sm-8">
                                    <select class="select2_demo_3 form-control" name="todo_list"
                                        required>
                                        @foreach($perkembangans as $perkembangan)
                                        <option value="{{ $perkembangan->todo_list }}">{{ $perkembangan->todo_list }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 label1" for="tujuan">
                                    Pihak terlibat
                                </label>
                                <div class="col-sm-8">
                                    <select class="select2_demo_3 form-control" id="pihak_terlibat"
                                        name="pihak_terlibat[]" multiple="multiple">
                                    </select>
                                    <small class="text-muted"> <b>Jika ada pihak-pihak yang terlibat</b>
                                        <span class="text-info" style="font-style: italic;"><b>(opsional)</b></span>
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row"> <label class="col-sm-3 label1" for="url"> URL
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="url" name="url" class="form-control">
                                    <small class="text-muted"><b>Jika ada link tambahan terkait tugas
                                        </b>
                                        <span class="text-info" style="font-style: italic;"><b>(opsional)</b></span>
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row"> <label class="col-sm-3 label1">
                                    Lampiran </label>
                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input id="inputGroupFile01" name="lampiran" type="file"
                                            accept=".pdf,.docx,.zip,.rar,.png,.jpg,.jpeg" class="custom-file-input">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                            file</label>
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
                                            <span class="text-info" style="font-style: italic;"><b>(opsional)</b></span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit">
                                    <span style="text-align: right;">
                                        <i class="fa fa-send-o"></i> &nbsp;Kirim
                                    </span>
                                </button>
                            </div>
                        </form>
                        <!-- @endforeach -->
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

        $("#pihak_terlibat").select2({
            placeholder: 'Cari & Pilih',
            ajax: {
                url: "{{url('d/getAllUser')}}",
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