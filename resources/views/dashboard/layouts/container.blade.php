<!DOCTYPE html>
<html lang="en">
	<base href="{{URL::asset('/')}}" target="_top">
	<head>
		@include('dashboard.partials.meta')
		@include('dashboard.partials.css')
		<script src="{{ URL::asset('public/dashboard/plugins/jquery/jquery.min.js') }}"></script>
	</head>
	<body class="fix-header fix-sidebar card-no-border logo-center">
		@include('dashboard.partials.preloader')
		<div id="main-wrapper">
			@include('dashboard.partials.topbar')
			@include('dashboard.partials.left-sidebar')
			<div class="page-wrapper">
		    	@yield('content')
				@include('dashboard.partials.footer')
				@include('dashboard.partials.modal')
			</div>
		</div>
		@include('dashboard.partials.js')
	</body>
</html>