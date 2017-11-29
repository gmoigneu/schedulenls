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
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <!-- This page CSS -->
    <!-- Vector CSS -->
    <link href="{{ url('plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- chartist CSS -->
    <link href="{{ url('plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ url('plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">

    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <link href="{{ url('css/dashboard4.css') }}" rel="stylesheet">
    <link href="{{ url('css/blue.css') }}" id="theme" rel="stylesheet">
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
                    <a class="navbar-brand" href="/">
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
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify">
                                    @if (Auth::user()->unreadNotifications->count())
                                        <span class="heartbit"></span> <span class="point"></span>
                                    @endif
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            @foreach (Auth::user()->unreadNotifications as $notification)
                                            <!-- Message -->
                                                @if ($notification->type == 'App\Notifications\EventScheduled')
                                                <?php
                                                    $data = $notification->data;                                                    
                                                    if (!array_key_exists('event', $data)) {
                                                        continue;
                                                    } else {
                                                        $event = \App\Event::find($data['event']['id']);
                                                    }
                                                ?>
                                                <a href="#">
                                                    <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                    <div class="mail-contnet">
                                                        <h5>{{ $event->name }}</h5>
                                                        <span class="mail-desc">{{ \Carbon\Carbon::parse($event->start) }}</span> <span class="time">{{ \Carbon\CarbonInterval::minutes($event->eventType->duration) }}</span>
                                                    </div>
                                                </a>
                                                @endif
                                            @endforeach
                                        
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="{{ route('archive') }}"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ Gravatar::get(Auth::user()->email) }}" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-text">
                                                <h4>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                                                <p class="text-muted">{{ Auth::user()->email }}</p></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <!--<li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                    <li role="separator" class="divider"></li>-->
                                    <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
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
                        <li> <a class="has-arrow waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="{{ route('select') }}" aria-expanded="false"><i class="mdi mdi-calendar-multiple-check"></i><span class="hide-menu">Calendars</span></a></li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="{{ route('eventtype.index') }}" aria-expanded="false"><i class="mdi mdi-buffer"></i><span class="hide-menu">Event types</span></a></li>
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
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">@yield('title')</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">@yield('breadcrumb')</li>
                        </ol>
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
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{ url('plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ url('js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ url('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ url('js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ url('js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Vector map JavaScript -->
    <script src="{{ url('plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ url('plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!--sparkline JavaScript -->
    <script src="{{ url('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--morris JavaScript -->
    <script src="{{ url('plugins/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ url('plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ url('js/dashboard4.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ url('plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>