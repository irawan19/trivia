@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Register Bot</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/register_bot') }}">Register Bot</a></li>
	            <li class="breadcrumb-item active">Read</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
				        <table class="table table-bordered table-condensed">
							<tr>
								<th width="35%">Date</th>
								<th width="1%">:</th>
								<td>{{ Shwetech::changeDBToDate($read_register_bots->date_register_bots) }}</td>
							</tr>
							<tr>
								<th>Time</th>
								<th>:</th>
								<td>{{ $read_register_bots->time_register_bots }}</td>
							</tr>
							<tr>
								<th>Name</th>
								<th>:</th>
								<td>{{ $read_register_bots->name_register_bots }}</td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<th>:</th>
								<td>{{ $read_register_bots->phone_number_bots }}</td>
							</tr>
							<tr>
								<th>Code</th>
								<th>:</th>
								<td>{{ $read_register_bots->code_bots }}</td>
							</tr>
							<tr>
								<th>Password</th>
								<th>:</th>
								<td>{{ $read_register_bots->password_bots }}</td>
							</tr>
						</table>
						<br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/register_bot')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop