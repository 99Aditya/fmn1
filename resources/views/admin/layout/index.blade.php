<!DOCTYPE html>
<html lang="en">

<head>
    <title>Find My Naukri : @yield('title') </title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/img/white-logo.png') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/files\bower_components\bootstrap\css\bootstrap.min.css') }}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files\assets\icon\feather\css\feather.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files\assets\css\style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files\assets\css\jquery.mCustomScrollbar.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}"> --}}
    <!-- Data Table Css  -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin\files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/files\assets\pages\data-table\css\buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">

    <!-- swiper css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/files\bower_components\swiper\css\swiper.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/files\assets\css\component.css') }}">

    <!-- NOTIFY -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin\files\bower_components\pnotify\css\pnotify.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin\files\bower_components\pnotify\css\pnotify.brighttheme.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin\files\bower_components\pnotify\css\pnotify.buttons.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin\files\bower_components\pnotify\css\pnotify.mobile.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin\files\assets\pages\pnotify\notify.css') }}">

    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin\files\assets\icon\icofont\css\icofont.css') }}">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('admin_custom_style')

</head>

<body>
    @if (session('flash-error'))
        <span class="admin-toastr"
            onclick="toastr_alert('Error','{{ session()->get('flash-error') }}','error')"></span>
    @endif
    @if (session('flash-success'))
        <span class="admin-toastr"
            onclick="toastr_alert('Success','{{ session()->get('flash-success') }}','success')"></span>
    @endif
    <!-- Pre-loader start -->
    <div class="theme-loader data-table">
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
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="javascript:void(0)">
                            <h6 class="text-white">Find My Naukri</h6>
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i
                                                class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i
                                                class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{ asset('logo/user.png') }}" />
                                        <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu"
                                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <form method="POST" action="{{ route('admin.logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item border-0 bg-transparent w-100 text-start">
                                                    <i class="feather icon-log-out"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>



            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                

                                <li class="{{ request()->is('admin/blog*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.blog') }}">
                                        <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                        <span class="pcoded-mtext">Blog</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/contacts*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.contacts.index') }}">
                                        <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                                        <span class="pcoded-mtext">Contacts</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories.index') }}">
                                        <span class="pcoded-micon"><i class="feather icon-tag"></i></span>
                                        <span class="pcoded-mtext">Test Categories</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/tests*') && !request()->is('admin/bulk*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.tests.index') }}">
                                        <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                                        <span class="pcoded-mtext">MCQ Tests</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/bulk*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.bulk.tests.form') }}">
                                        <span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span>
                                        <span class="pcoded-mtext">Bulk Upload</span>
                                    </a>
                                </li>

                                {{-- <li class="">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-info"></i></span>
                                        <span class="pcoded-mtext">Demo</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="">
                                                <span class="pcoded-mtext">Sub Menu</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                              
                               
                            </ul>

                        </div>
                    </nav>

                    @yield('content')

                </div>
            </div>


        </div>
    </div>

    <script>
        var csrf = "{{ csrf_token() }}";
        var baseUrl = "{{ url('/') }}";
    </script>


    <!-- Required Jquery -->
    <script data-cfasync="false" src="..\..\..\cdn-cgi\scripts\5c5dd728\cloudflare-static\email-decode.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/files\bower_components\jquery\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files\bower_components\jquery-ui\js\jquery-ui.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('admin/files\bower_components\popper.js\js\popper.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('admin/files\bower_components\bootstrap\js\bootstrap.min.js') }}">
    </script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript"
        src="{{ asset('admin/files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('admin/files\bower_components\modernizr\js\modernizr.js') }}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('admin/files\bower_components\chart.js\js\Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="{{ asset('admin/files\assets\pages\widget\amchart\amcharts.js') }}"></script>
    <script src="{{ asset('admin/files\assets\pages\widget\amchart\serial.js') }}"></script>
    <script src="{{ asset('admin/files\assets\pages\widget\amchart\light.js') }}"></script>
    <script src="{{ asset('admin/files\assets\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files\assets\js\SmoothScroll.js') }}"></script>
    <script src="{{ asset('admin/files\assets\js\pcoded.min.js') }}"></script>

    <!-- Data Table JS  -->
    <script src="{{ asset('admin/files\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}">
    </script>
    <script src="{{ asset('admin/files\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('admin/files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
    </script>
    <script
        src="{{ asset('admin/files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
    </script>

    <!-- NOTIFY TOASTER -->
    <script type="text/javascript" src="{{ asset('admin\files\bower_components\pnotify\js\pnotify.js') }}"></script>

    <script type="text/javascript" src="{{ asset('admin\files\assets\pages\pnotify\notify.js') }}"></script>


    <script src="{{ asset('admin/files\assets\js\vartical-layout.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files\assets\pages\dashboard\custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files\assets\js\script.min.js') }}"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <script type="text/javascript" src="{{ asset('admin\files\bower_components\swiper\js\swiper.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('admin/files\assets\js\modalEffects.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/files\assets\js\classie.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- custom js -->
    {{-- <script src="{{ asset('assets/js/custom.js') }}"></script> --}}
    @stack('admin_custom_scripts')

</body>

</html>
