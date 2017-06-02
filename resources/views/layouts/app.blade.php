<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from jesus.gallery/everest/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:42:29 GMT -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ Config::get('constants.PAGE_DESCRIPTION') }}" />
    <meta name="keywords" content="{{ Config::get('constants.PAGE_KEYWORDS') }}" />
    <meta name="author" content="{{ Config::get('constants.DEV') }}" />
    <link rel="shortcut icon" href="img/favicon.ico">
    <title>{{ Config::get('constants.PAGE_TITLE') }}</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" media="screen">

    <!-- Animate CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" media="screen">

    <!-- Alertify CSS -->
    <link href="{{ asset('css/alertify/alertify.core.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('css/alertify/alertify.default.css') }}" rel="stylesheet" media="screen">

    <!-- Main CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="screen">

    <!-- Datepicker CSS -->
    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet" media="screen">

    <!-- Font Awesome -->
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" media="screen">

    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- jQuery UI JS -->
    <script src="{{ asset('js/jquery-ui-v1.10.3.js') }}"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Data tables -->
    <script type="text/javascript" src="{{ URL::asset('js/jquery.datatables.js') }}"></script>

    <!-- moment -->
    <script type="text/javascript" src="{{ URL::asset('js/moment/moment-with-locales.js') }}"></script>

</head>

<body>

<!-- Header Start -->
<header>

    <!-- Logo starts -->
    <div class="logo">
        <a href="#">
            <img src="{{ asset('img/dcnc.png') }}" alt="logo">
            <span class="menu-toggle hidden-xs">
                <i class="fa fa-bars"></i>
            </span>
        </a>
    </div>
    <!-- Logo ends -->

    <!-- Mini right nav starts -->
    <div class="pull-right">
        <ul id="mini-nav" class="clearfix">
            <li class="list-box hidden-lg hidden-md hidden-sm" id="mob-nav">
                <a href="#">
                    <i class="fa fa-reorder"></i>
                </a>
            </li>
            <li class="list-box dropdown hidden-xs">
                <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                </a>
                <span class="info-label danger-bg animated rubberBand">4</span>
                <ul class="dropdown-menu bounceIn animated messages">
                    <li class="plain">
                        Messages
                    </li>
                    <li>
                        <div class="user-pic">
                            <img src="{{ asset('img/user4.jpg') }}" alt="User">
                        </div>
                        <div class="details">
                            <strong class="text-danger">Wilson</strong>
                            <span>Uploaded 28 new files yesterday.</span>
                            <div class="progress progress-xs no-margin">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="user-pic">
                            <img src="{{ asset('img/user1.jpg') }}" alt="User">
                        </div>
                        <div class="details">
                            <strong class="text-danger">Adams</strong>
                            <span>Got 12 new messages.</span>
                            <div class="progress progress-xs no-margin">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="user-pic">
                            <img src="{{ asset('img/user3.jpg') }}" alt="User">
                        </div>
                        <div class="details">
                            <strong class="text-info">Sam</strong>
                            <span>Uploaded new project files today.</span>
                            <div class="progress progress-xs no-margin">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="user-pic">
                            <img src="{{ asset('img/user5.jpg') }}" alt="User">
                        </div>
                        <div class="details">
                            <strong class="text-info">Jennifer</strong>
                            <span>128 new purchases last 3 hours.</span>
                            <div class="progress progress-xs no-margin">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="list-box user-profile hidden-xs">
                <a href="login.html" class="user-avtar animated rubberBand">
                    <img src="{{ asset('img/user4.jpg') }}" alt="user avatar">
                </a>
            </li>
        </ul>
    </div>
    <!-- Mini right nav ends -->

</header>
<!-- Header ends -->

<!-- Left sidebar starts -->
<aside id="sidebar">

    <!-- Current User Starts -->
    <div class="current-user">
        <div class="user-avatar animated rubberBand">
            <img src="{{ asset('img/users/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->nome }}">
            <span class="busy"></span>
        </div>
        <div class="user-name">Olá {{ Auth::user()->nome }}</div>
        <ul class="user-links">
            <li>
                <a href="profile.html">
                    <i class="fa fa-user text-success"></i>
                </a>
            </li>
            <li>
                <a href="invoice.html">
                    <i class="fa fa-file-pdf-o text-warning"></i>
                </a>
            </li>
            <li>
                <a href="components.html">
                    <i class="fa fa-sliders text-info"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out text-danger"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- Current User Ends -->

    @include('elements.menu')


</aside>
<!-- Left sidebar ends -->

<!-- Dashboard Wrapper starts -->
<div class="dashboard-wrapper">

    @yield('content')

    <!-- Footer starts -->
    <footer>
        Copyright Everest Admin Panel 2014.
    </footer>
    <!-- Footer ends -->
    <!-- Footer ends -->

</div>
<!-- Dashboard Wrapper ends -->

<!-- Sparkline graphs -->
<script src="{{ asset('js/sparkline.js') }}"></script>

<!-- jquery ScrollUp JS -->
<script src="{{ asset('js/scrollup/jquery.scrollUp.js') }}"></script>

<!-- Notifications JS -->
<script src="{{ asset('js/alertify/alertify.js') }}"></script>
<script src="{{ asset('js/alertify/alertify-custom.js') }}"></script>

<!-- Flot Charts -->
<script src="{{ asset('js/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('js/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('js/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('js/flot/jquery.flot.stack.min.js') }}"></script>
<script src="{{ asset('js/flot/jquery.flot.orderBar.min.js') }}"></script>
<script src="{{ asset('js/flot/jquery.flot.pie.min.js') }}"></script>

<!-- Custom Index -->
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/custom-components.js') }}"></script>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>

@include('elements.scripts')

@yield('footer')

</body>
</html>