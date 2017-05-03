<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from jesus.gallery/everest/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:45:00 GMT -->
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

    <!-- Main CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="screen">

    <!-- Main CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" media="screen">

    <!-- Font Awesome -->
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" media="screen">

    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->

</head>

<body>
<!-- Container Fluid starts -->
<div class="container-fluid">
    @yield('content')
</div>
<!-- Container Fluid ends -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/jquery.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script type="text/javascript">
    (function($) {
        // constants
        var SHOW_CLASS = 'show',
                HIDE_CLASS = 'hide',
                ACTIVE_CLASS = 'active';

        $('a').on('click', function(e){
            e.preventDefault();
            var a = $(this),
                    href = a.attr('href');

            $('.active').removeClass(ACTIVE_CLASS);
            a.addClass(ACTIVE_CLASS);

            $('.show')
                    .removeClass(SHOW_CLASS)
                    .addClass(HIDE_CLASS)
                    .hide();

            $(href)
                    .removeClass(HIDE_CLASS)
                    .addClass(SHOW_CLASS)
                    .hide()
                    .fadeIn(550);
        });
    })(jQuery);
</script>
</body>
</html>