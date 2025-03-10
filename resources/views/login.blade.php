<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPORSAT KEMENKES RI</title>

    <!-- Icon Title -->
    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="form-group first">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p style="color:white;margin: auto;">{{ $message }}</p>
            </div>
            @endif
            @if ($message = Session::get('failed'))
            <div class="alert alert-danger">
                <p style="color:white;margin: auto;">{{ $message }}</p>
            </div>
            @endif
        </div>
        <div class="card" style="border-radius: 20px;">
            <div class="card-header text-center">
                <a href="{{ url('/') }}">
                    <p><img src="{{ url('dist/img/logo-siporsat.png') }}" class="img-fluid" width="150"></p>
                </a>
                <span class="text-uppercase text-center small" style="font-family: Arial;">
                    Sistem Informasi Pengelolaan <br> Operasional Perkantoran Terpusat
                </span>
            </div>
            <div class="card-body">
                <form action="{{ route('loginPost') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text rounded-left">
                                <span class="fas fa-users"></span>
                            </div>
                        </div>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="input-group mb-3" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text rounded-left">
                                <a type="button" onclick="lihatPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <button type="submit" class="btn btn-block btn-primary">
                            Masuk
                        </button>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="#">Lupa password ?</a>
                </p>
                <p class="mb-0">
                    <a href="https://wa.me/6285772652563" class="text-center">Bantuan</a>
                </p>
            </div>
            <div class="card-footer text-center">
                <img src="{{ asset('dist/img/biro-umum.png') }}" class="img-fluid" width="250">
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- Lihat Password -->
    <script type="text/javascript">
        function lihatPassword() {
            var x = document.getElementById("password");
            if ($('#password input').attr("type") == "password") {
                $('#password input').attr('type', 'text');
                $('#password i').addClass("fa-eye-slash");
                $('#password i').removeClass("fa-eye");
            } else {
                $('#password input').attr('type', 'password');
                $('#password i').removeClass("fa-eye-slash");
                $('#password i').addClass("fa-eye");
            }
        }

        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'captcha-reload',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
</body>

</html>
