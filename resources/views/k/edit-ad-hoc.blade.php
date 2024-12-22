@extends('layout')

@section('side-menu')
<li>
    <a href="/k/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li>
<li>
    <a href="/k/statistik-tugas"><i class="fa fa-pie-chart"></i>
        <span class="nav-label">Statistik Tugas</span></a>
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
            <h2>Edit Role User</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/k/ad-hoc">
                        Ad Hoc
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">
                        <strong>Edit Ad Hoc</strong>
                    </a>
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
                        <h5>Edit Role User</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <form action="{{ route('k.updateAdHoc', ['id' => $roleUser->id] )}}"
                            method="post" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Nama Pengguna -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="nama_pengguna">
                                            Nama *
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="select2" name="nama_pengguna"
                                                class="select2_demo_2 form-control" required>
                                            </select>
                                            <br>
                                        </div>
                                    </div>

                                    <!-- Role -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="role">
                                            Role *
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="select3" name="role" class="select2_demo_3 form-control"
                                                disabled>
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success btn-outline" type="submit">
                                    <i class="fa fa-send-o"></i> &nbsp;Simpan
                                </button>
                                <br><br>
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
        //FINAL
        $(".select2_demo_2").select2({
            placeholder: '{{$nama_pengguna_edit}}',
            theme: 'bootstrap4',
            allowClear: true
        });

        $(".select2_demo_3").select2({
            placeholder: '{{$nama_role_edit}}',
            theme: 'bootstrap4',
            allowClear: true
        });

        $('.icheck').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $("#select2").select2({
            placeholder: '{{$nama_pengguna_edit}}',
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

        $("#select3").select2({
            placeholder: '{{$nama_role_edit}}',
            ajax: {
                url: "{{url('getAllRole')}}",
                processResults: function ({ data }) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.name,
                                text: item.name,
                            }
                        })
                    }
                }
            },
        });

    });

</script>
@endsection