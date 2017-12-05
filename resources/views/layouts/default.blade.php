<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicon.png') }}">
    <title>{{ env('APP_NAME') }}</title>

    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Schedule</p>
        </div>
    </div>-->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('types', ['user' => $user]) }}">
                        <svg width="188px" height="273px" viewBox="0 0 188 273" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Logo" transform="translate(-3.000000, -3.000000)" fill="#FFFFFF">
                                    <g id="Group">
                                        <rect id="Rectangle" transform="translate(97.479514, 60.682531) rotate(18.000000) translate(-97.479514, -60.682531) " x="0.746285226" y="46.182531" width="193.466457" height="29" rx="14.5"></rect>
                                        <rect id="Rectangle" transform="translate(43.523007, 81.150999) rotate(18.000000) translate(-43.523007, -81.150999) " x="3.52300707" y="66.6509993" width="80" height="29" rx="14.5"></rect>
                                        <rect id="Rectangle" transform="translate(106.523007, 26.150999) rotate(18.000000) translate(-106.523007, -26.150999) " x="66.5230071" y="11.6509993" width="80" height="29" rx="14.5"></rect>
                                        <rect id="Rectangle" transform="translate(85.523007, 253.150999) rotate(18.000000) translate(-85.523007, -253.150999) " x="45.5230071" y="238.650999" width="80" height="29" rx="14.5"></rect>
                                        <rect id="Rectangle" transform="translate(96.900648, 138.923542) rotate(18.000000) translate(-96.900648, -138.923542) " x="54.4006484" y="124.423542" width="85" height="29" rx="14.5"></rect>
                                        <rect id="Rectangle" transform="translate(151.523007, 196.150999) rotate(18.000000) translate(-151.523007, -196.150999) " x="111.523007" y="181.650999" width="80" height="29" rx="14.5"></rect>
                                        <rect id="Rectangle" transform="translate(96.733228, 216.764968) rotate(18.000000) translate(-96.733228, -216.764968) " x="-0.266771501" y="202.264968" width="194" height="29" rx="14.5"></rect>
                                    </g>
                                </g>
                            </g>
                        </svg>    
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item hidden-sm-down"><span></span></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            @include('partials.user-dropdown');
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">You're booking a meeting with {{ $user->email }}</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-12 align-self-center">
                        <h3 class="text-themecolor">@yield('title')</h3>
                    </div>
                </div>

                @include('partials.alert')
                @yield('content')

                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            @include('partials.footer')
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>