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
                    <a href="/k/ad-hoc">
                        <strong>Ad Hoc</strong>
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
                            <div class="col-md-6 col-lg-7" style="padding-top: 7px; padding-left: 7px;">
                                <div style="margin-left: 10px;">
                                    <a data-toggle="modal" class="btn btn-primary" href="#modal-form">
                                        <i class="fa fa-plus"></i>
                                        &nbsp;Tambah Data Role User
                                    </a>
                                </div>
                                <div id="modal-form" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('k.storeAdHoc') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <h3 class="m-t-none m-b">Tambah role user</h3>

                                                    <div class="form-group"><label>Nama Pengguna</label>
                                                        <select style="width: 100%;" id="nama_pengguna"
                                                            name="nama_pengguna" class="select2_demo_3 form-control"
                                                            required>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="form-group"><label>Role</label>
                                                        <select style="width: 100%;" id="role" name="role"
                                                            class="select2_demo_3 form-control" disabled="">
                                                        </select>
                                                    </div>
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
                                        <th>Nama Role</th>
                                        <th>NIP/ID</th>
                                        <th>Nama</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <br>
                                    @foreach ($usersWithRoles as $roleUser)
                                    <tr>
                                        <td>
                                            <span class="label label-success">
                                                {{ $roleUser->name }}
                                            </span>
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
                                            <!-- edit -->
                                            <a href="{{ route('k.editAdHoc', $roleUser->id) }}"
                                                class="btn-white btn btn-xs">
                                                &nbsp;Edit
                                            </a>

                                            <!-- delete -->
                                            <form action="{{ route('k.destroyAdHoc', ['id' => $roleUser->id]) }}" method="post"
                                                class="d-inline">
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
            placeholder: 'AdHoc',
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