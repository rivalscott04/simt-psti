<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Monitoring Tugas | Login</title>

    <link rel="icon" href="{{ asset('img/logo_unram.png')}}" />
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            @if(session()->has('SelectedRoleFailed'))
            <div class="alert alert-danger" role="alert">
                {{ session('SelectedRoleFailed') }}
            </div>
            @endif

            @if(session()->has('LoginFailed2'))
            <div class="alert alert-danger" role="alert">
                {{ session('LoginFailed2') }}
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            @if(session()->has('autentikasiFailed'))
            <div class="alert alert-danger" role="alert">
                {{ session('autentikasiFailed') }}
            </div>
            @endif

            @if(session()->has('roleNull'))
            <div class="alert alert-danger" role="alert">
                {{ session('roleNull') }}
            </div>
            @endif

            <!-- @if(session()->has('selectedRole'))
            <div class="alert alert-danger" role="alert">
                {{ session('selectedRole') }}
            </div>
            <div class="form-group">
                <select name="role_id" id="role_id" class="form-control">
                    <option value="">Pilih Role</option>
                    <option value="1">Kaprodi</option>
                    <option value="2">Sekprodi</option>
                    <option value="3">Kalab</option>
                    <option value="4">AdHoc</option>
                    <option value="5">Dosen</option>
                    <option value="6">Staf</option>
                </select>
            </div>
            @endif -->

            <div>
                <img src="{{ asset('img/logo_unram.png')}}" alt="">
            </div>
            <p></p>
            <h3>Sign On</h3>
            <form class="m-t" method="post" action="{{route('authenticate')}}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" id="id" name="id" required>
                    <!-- <label for="floatingInput">Username</label> -->
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password"
                        required>
                    <!-- <label for="floatingPassword">Password</label> -->
                </div>
                <div class="form-group">
                    <select name="role" id="role" class="form-control">
                        <!-- <option value="">Pilih Role</option> -->
                        <option value="Kaprodi">Kaprodi</option>
                        <option value="Sekprodi">Sekprodi</option>
                        <option value="Kalab">Kalab</option>
                        <option value="AdHoc">AdHoc</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Staf">Staf</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>


                <!-- level access -->


                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <!-- <a href="#"><small>Forgot password?</small></a> -->
            <p class="m-t"> <small>Teknik Informatika Universitas Mataram &copy; 2023</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.js')}}"></script>

</body>

</html>