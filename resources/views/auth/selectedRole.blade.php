<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Monitoring Tugas | Login</title>

    <link rel="icon" href="img/logo_unram.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <img src="img/logo_unram.png" alt="">
            </div>
            <p></p>
            <h3>Single Sign On</h3>
            <form class="m-t" method="post" action="{{route('selectedRole')}}">
                @csrf
                <div class="form-group">
                    <select name="id_role" id="id_role" class="form-control">
                        <option value="">Pilih Role</option>
                        <option value="1">Kaprodi</option>
                        <option value="2">Sekprodi</option>
                        <option value="3">Kalab</option>
                        <option value="4">AdHoc</option>
                        <option value="5">Dosen</option>
                        <option value="6">Staf</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <a href="#"><small>Forgot password?</small></a>
            <p class="m-t"> <small>Universitas Mataram &copy; 2023</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>