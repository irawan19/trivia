@php($get_app_configuration = \App\Master_app_configuration::first())
<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations) }}">
<title>{{ config('app.name') }}</title>
<link href="{{ URL::asset('public/dashboard/plugins/jqueryui/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/dashboard/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/dashboard/plugins/morrisjs/morris.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/dashboard/css/style.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/dashboard/css/colors/blue.css') }}" id="theme" rel="stylesheet">
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<link href="{{ URL::asset('public/dashboard/plugins/tablesaw-master/dist/tablesaw.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/dashboard/plugins/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">
<link type="text/css" media="screen" rel="stylesheet" href="{{ URL::asset('public/dashboard/plugins/jqueryui/jquery-ui.css')}}" />
<link type="text/css" media="screen" rel="stylesheet" href="{{ URL::asset('public/dashboard/plugins/select2/dist/css/select2.min.css') }}" />
<link type="text/css" media="screen" rel="stylesheet" href="{{{ URL::asset('public/dashboard/plugins/daterangepicker/daterangepicker.css')}}}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/dashboard/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<style>
	.u-info
	{
		font-size: 12px;
		font-family: "Poppins", sans-serif
	}
    .pager {
	    padding-left: 0;
	    margin: 20px 0;
	    text-align: center;
	    list-style: none
	}
	.pager li {
	    display: inline
	}
	li.active.my-active span{
		background-color: #41f4e8;
	}
	.pager li>a,.pager li>span {
	    display: inline-block;
	    padding: 5px 14px;
	    background-color: #fff;
	    border: 1px solid #ddd;
	    border-radius: 15px
	}
	.pager li>a:focus,.pager li>a:hover {
	    text-decoration: none;
	    background-color: #eee
	}
	.pager .next>a,.pager .next>span {
	    float: right
	}
	.pager .previous>a,.pager .previous>span {
	    float: left
	}
	.pager .disabled>a,.pager .disabled>a:focus,.pager .disabled>a:hover,.pager .disabled>span {
	    color: #777;
	    cursor: not-allowed;
	    background-color: #fff
	}
	.td_align.td_right{
		text-align:right;
	}
	.td_align.td_center{
		text-align:center;
	}
	.td_align.td_left{
		text-align:left;
	}
	.th_align.th_right{
		text-align:right;
	}
	.th_align.th_center{
		text-align:center;
	}
	.th_align.th_left{
		text-align: left;
	}
	.date-profile{
	    margin: 0 auto;
	    padding: 10px 0 5px 0;
	    text-align: center;
	}
	.custom-select{
		background:url(public/images/custom-select.png) right 0.75rem center no-repeat
	}
	.topbar ul.dropdown-user li .dw-user-box .u-img
	{
		width: 60%;
	}
	.modal-footer {
	    display: -ms-flexbox;
	    display: block;
	    -ms-flex-align: center;
	    align-items: center;
	    -ms-flex-pack: end;
	    justify-content: flex-end;
	    padding: 15px;
	    border-top: 1px solid #e9ecef;
	}
</style>