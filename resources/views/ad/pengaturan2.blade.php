@extends('layout')
@section('side-menu')
<li class="active">
    <a href="/admin"><i class="fa fa-cog"></i>
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
                    <a href="/admin">
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
                        <div class="row">
                            <div class="col-lg-5">
                                <form action="/admin" method="get">
                                    <!-- @csrf -->
                                    <label for="search" style="font-weight: bold">Pencarian</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm m-b-xs" name="search"
                                            id="filter" placeholder="Masukkan NIP / ID / Nama / Role">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 col-lg-7" style="padding-top: 7px; padding-left: 7px;">
                                <br />
                                &nbsp;
                                <!-- <a href="{{ route('admin.create')}}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                        &nbsp;Tambah
                                    </a> -->
                                <a data-toggle="modal" class="btn btn-primary" href="#modal-form">
                                    <i class="fa fa-plus"></i>
                                    &nbsp;Tambah Data Role User
                                </a>
                                <div id="modal-form" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.store') }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <!-- <div class="row"> -->
                                                    <!-- <div class="col-lg-6"> -->
                                                    <h3 class="m-t-none m-b">Tambah data</h3>

                                                    <p>Masukkan data nama dan role.</p>

                                                    <div class="form-group"><label>Nama Pengguna</label>
                                                        <select style="width: 100%;" id="nama_pengguna"
                                                            name="nama_pengguna" class="select2_demo_3 form-control"
                                                            required>
                                                        </select>
                                                    </div>
                                                    <div class="form-group"><label>Role</label>
                                                        <select style="width: 100%;" id="role" name="role"
                                                            class="select2_demo_3 form-control" required>
                                                        </select>
                                                    </div>

                                                    <!-- </div> -->
                                                    <!-- <div class="col-sm-6">
                                                                    <h4>Not a member?</h4>
                                                            <p>You can create an account:</p>
                                                            <p class="text-center">
                                                                <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                                            </p>
                                                        </div> -->
                                                    <!-- </div> -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <!-- <th style="width: 50px;">No</th> -->
                                        <!-- <th>ID RoleUser</th> -->
                                        <th>
                                            Nama Role
                                        </th>
                                        <th>NIP/ID</th>
                                        <th>Nama</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <br>
                                    @foreach ($usersWithRoles as $roleUser)
                                    <tr>
                                        <!-- <td>
                                            {{$roleUser->id}}
                                        </td> -->
                                        <td>
                                            @if ($roleUser->name == 'Kaprodi')
                                            <span class="label label-warning">
                                                {{ $roleUser->name }}
                                            </span>
                                            @elseif ($roleUser->name == 'Sekprodi')
                                            <span class="label label-primary">
                                                {{ $roleUser->name }}
                                            </span>
                                            @elseif ($roleUser->name == 'Kalab')
                                            <span class="label label-info">
                                                {{ $roleUser->name }}
                                            </span>
                                            @elseif ($roleUser->name == 'AdHoc')
                                            <span class="label label-success">
                                                {{ $roleUser->name }}
                                            </span>
                                            @elseif ($roleUser->name == 'Dosen')
                                            <span class="label">
                                                {{ $roleUser->name }}
                                            </span>
                                            @elseif ($roleUser->name == 'Staf')
                                            <span class="label text-white bg-secondary">
                                                {{ $roleUser->name }}
                                            </span>
                                            @elseif ($roleUser->name == 'Admin')
                                            <span class="badge badge-dark">
                                                <i class="fa fa-cog"></i>
                                                {{ $roleUser->name }}
                                            </span>
                                            @endif

                                        </td>
                                        <td>
                                            <p>
                                                {{ $roleUser->user_id }}
                                            </p>
                                        </td>
                                        <td nowrap>
                                            <span> {{ $roleUser->nama_pengguna }} </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('k.edit', $tugas->id_tugas) }}"
                                                class="btn btn-xs btn-primary btn-outline">
                                                <i class="fa fa-edit"></i>
                                                &nbsp;Edit
                                            </a>


                                            <a href="#" class="btn-edit btn-white btn btn-xs"
                                                data-id="{{ $roleUser->id }}">Edit Paling Baru</a>

                                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                                aria-labelledby="editModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <!-- <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div> -->
                                                        <div class="modal-body text-left">
                                                            <form id="editForm" method="POST" action="">
                                                                @csrf
                                                                @method('PATCH')
                                                                <h3 class="m-t-none m-b">Edit data</h3>

                                                                <p>Masukkan data nama dan role.</p>

                                                                <div class="form-group"><label>Nama Pengguna</label>
                                                                    <select style="width: 100%;" id="nama_pengguna"
                                                                        name="nama_pengguna"
                                                                        class="select2_demo_3 form-control" required>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group"><label>Role</label>
                                                                    <select style="width: 100%;" id="role" name="role"
                                                                        class="select2_demo_3 form-control" required>
                                                                    </select>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">
                                                                    Simpan
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


















                                            <a data-toggle="modal" class="btn-white btn btn-xs" href="#modal-form">
                                                &nbsp;Edit Baru
                                            </a>
                                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.update', $roleUser->id ) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <h3 class="m-t-none m-b">Edit Data</h3>
                                                                <p>Masukkan data nama dan role.</p>

                                                                <div class="form-group"><label>Nama Pengguna</label>
                                                                    <select style="width: 100%;" id="nama_pengguna"
                                                                        name="nama_pengguna"
                                                                        class="select2_demo_3 form-control" required>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group"><label>Role</label>
                                                                    <select style="width: 100%;" id="role" name="role"
                                                                        class="select2_demo_3 form-control" required>
                                                                    </select>
                                                                </div>

                                                                <!-- </div> -->
                                                                <!-- <div class="col-sm-6">
                                                                                <h4>Not a member?</h4>
                                                                        <p>You can create an account:</p>
                                                                        <p class="text-center">
                                                                            <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                                                        </p>
                                                                    </div> -->
                                                                <!-- </div> -->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Tambah</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- edit -->
                                            <form action="{{ route('admin.edit', $roleUser->id) }}" method="post"
                                                class="d-inline">
                                                <button type='submit' class="btn-white btn btn-xs">
                                                    Edit
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.destroy', $roleUser->id) }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type='submit' class="btn-white btn btn-xs"
                                                    onclick=" return confirm('Apakah anda yakin?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- </form> -->
                    </div>
                    <div class="ibox-footer">
                        <span class="text-muted">
                            {{ ($jumlahData) }} items
                        </span>
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

        $("#nama_pengguna").select2({
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

        $("#role").select2({
            placeholder: 'Cari & Pilih',
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

        $('.btn-edit').click(function () {
            var postId = $(this).data('id');
            var editUrl = '{{ route("admin.edit", ":id") }}';
            editUrl = editUrl.replace(':id', postId);

            $('#editForm').attr('action', editUrl);

            $.get(editUrl, function (data) {
                // Update modal content with data from server
                // For example, update form fields with fetched data
                $('#editModal').modal('show');
            });
        });

    });
</script>
@endsection