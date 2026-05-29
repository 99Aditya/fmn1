<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ SITE_NAME }}</title>
    <!-- Favicon icon -->
    <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/files\bower_components\bootstrap\css\bootstrap.min.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/files\assets\icon\themify-icons\themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/files\assets\icon\icofont\css\icofont.css') }}">

    <!-- notify js Fremwork -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/files\bower_components\pnotify\css\pnotify.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('template/files\bower_components\pnotify\css\pnotify.brighttheme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/files\assets\pages\pnotify\notify.css') }}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/files\assets\css\style.css') }}">
</head>

<body class="fix-menu">
    @if (session('flash-error'))
        <span class="admin-toastr" id="pnotify-rich"
            onclick="toastr_alert('Error','{{ session()->get('flash-error') }}','error')"></span>
    @endif
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                    <form class="md-float-material form-material" method="post"
                        action="{{ route('root.loginVerify') }}">
                        @csrf
                        <div class="text-center">
                            <img src="{{ asset('web/assets/images/social-logo.png') }}" style="width:200px" />
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Welcome back</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="email" class="form-control"
                                        placeholder="Your Email Address" value="admin@gmail.com">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        value="admin1234">
                                    <span class="form-bar"></span>
                                </div>

                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Login
                                            to Dashboard</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('template/files\bower_components\jquery\js\jquery.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/files\bower_components\popper.js\js\popper.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\bootstrap\js\bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('template/files\bower_components\modernizr\js\modernizr.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\modernizr\js\css-scrollbars.js') }}"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="{{ asset('template/files\bower_components\i18next\js\i18next.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('template/files\bower_components\jquery-i18next\js\jquery-i18next.min.js') }}"></script>


    <!-- pnotify js -->
    <script type="text/javascript" src="{{ asset('template/files\bower_components\pnotify\js\pnotify.js') }}">
    </script>

    <script type="text/javascript" src="{{ asset('template/files\assets\js\common-pages.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>

</body>

</html>
