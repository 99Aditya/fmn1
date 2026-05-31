<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login — Find My Naukri</title>
    <link rel="icon" href="{{ asset('assets/img/white-logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/assets/icon/icofont/css/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/bower_components/pnotify/css/pnotify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/bower_components/pnotify/css/pnotify.brighttheme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/assets/pages/pnotify/notify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files/assets/css/style.css') }}">
</head>

<body class="fix-menu">
    @if (session('flash-error'))
        <span class="admin-toastr" id="pnotify-rich"
            onclick="toastr_alert('Error','{{ session()->get('flash-error') }}','error')"></span>
    @endif

    <div class="theme-loader">
        <div class="ball-scale">
            <div class="contain">
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
    </div>

    <section class="login-block">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form class="md-float-material form-material" method="post" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="text-center">
                            <img src="{{ asset('logo/logo1.png') }}" alt="Find My Naukri" style="width:200px" />
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Admin Login</h3>
                                    </div>
                                </div>

                                <div class="form-group form-primary">
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email address" value="{{ old('email') }}" autofocus>
                                    <span class="form-bar"></span>
                                    @error('email')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password">
                                    <span class="form-bar"></span>
                                    @error('password')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group form-primary">
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" name="remember" value="1">
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span>Remember me</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                                            Login to Dashboard
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="{{ asset('admin/files/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/popper.js/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/modernizr/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/modernizr/js/css-scrollbars.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/bower_components/pnotify/js/pnotify.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files/assets/js/common-pages.js') }}"></script>
</body>

</html>
