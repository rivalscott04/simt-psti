@extends('layout')
@section('side-menu')
<li class="active">
    <a href="/k/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
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
                    <a href="/s/tugas">Tugas</a>
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
        <i class="icon fa fa-check"></i>
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
                                                <a href="#" class="float-right btn btn-xs btn-warning">In Progrss</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ $perkembangan->pihak_terlibat }}
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
                                {{ $perkembangan->pihak_terlibat }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
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

        bsCustomFileInput.init()
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
                url: "{{url('getAllUser')}}",
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