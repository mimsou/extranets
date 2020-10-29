<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>ADMIN</title>
	<link rel="icon" type="image/x-icon" href="{{ asset('atmos-assets/img/logo.png') }}"/>
	<link rel="icon" href="{{ asset('atmos-assets/img/logo.png') }}" type="image/png" sizes="16x16">
	<link rel="stylesheet" href="{{ asset('atmos-assets/vendor/pace/pace.css') }}">
	<script src="{{ asset('atmos-assets/vendor/pace/pace.min.js') }}"></script>
	<!--vendors-->
	<link rel="stylesheet" type="text/css" href="{{ asset('atmos-assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('atmos-assets/vendor/jquery-scrollbar/jquery.scrollbar.css') }}">
	<link rel="stylesheet" href="{{ asset('atmos-assets/vendor/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('atmos-assets/vendor/jquery-ui/jquery-ui.min.css') }}">
	<link rel="stylesheet" href="{{ asset('atmos-assets/vendor/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('atmos-assets/vendor/timepicker/bootstrap-timepicker.min.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('atmos-assets/fonts/jost/jost.css') }}">
	<!--Material Icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('atmos-assets/fonts/materialdesignicons/materialdesignicons.min.css') }}">
    <!--FontAwsome Icons-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome/css/all.css') }}">
	<!--Bootstrap + atmos Admin CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('atmos-assets/css/atmos.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/general.css') }}">
	<!-- Additional library for page -->
    @yield('head')
    @livewireStyles
</head>
<!--body with default sidebar pinned -->
<body class="{{--sidebar-pinned--}}">
    @yield('modal')

	<!--sidebar Begins-->
	@include('admin.atmos.partials.menus.default')

	<main class="admin-main">

	    <!--site header begins-->
	    @include('admin.atmos.partials.header')
		<!--site header ends -->

	    <section class="admin-content">
	    	@include('flash::message')
	        @yield('content')
	    </section>

	</main>

	@include('admin.atmos.partials.search')


	<script src="{{ asset('atmos-assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/popper/popper.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('atmos-assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('atmos-assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/listjs/listjs.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/moment/moment.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
	<script src="{{ asset('atmos-assets/js/atmos.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('li.active').addClass("opened");
            $('li.active.opened ul.sub-menu').css("display", "block");
        })

    </script>
	<!--page specific scripts for demo-->

	@yield('footer')
    @livewireScripts

</body>
</html>
