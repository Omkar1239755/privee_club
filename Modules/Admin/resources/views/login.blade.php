<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ url('public/assets/css/adminlte.min2167.css?v=3.2.0') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url('public/assets/css/custom.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="row">
            <div class="col-md-5 m-auto">
                <div class="card">
                    <div class="card-header text-center">
                        <a href="{{ route('admin.login') }}" style="font-weight: 600; font-size: 26px;" class="h1">
                            <img src="{{ url('public/assets/images/Frame.png') }}" class="brand-image " alt="Logo" width="60%">
                        </a>
                    </div>

                    <div class="card-body">

                        <!-- Display validation errors -->
                        @if ($errors->any())
                        <div class="alert alert-danger v-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Display session error -->
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <!-- Login Form -->
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                           
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </form>
                        <!-- /Login Form -->

                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div class="col-md-6 d-none d-md-block">
                <div class="login-img">
                    <img src="{{ url('public/assets/images/Rectangle 2617.png') }}" class="img-fluid">
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ url('public/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('assets/js/adminlte.min2167.js?v=3.2.0') }}"></script>

    <script>
        $(document).ready(function () {
            // Auto fade alerts
            $('.alert-dismissible').fadeOut(4000);
        });
    </script>
</body>
</html>
