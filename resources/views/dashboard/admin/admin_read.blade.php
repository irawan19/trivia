@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Admin</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/admin') }}">Admin</a></li>
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
								<th width="35%">Name</th>
								<th width="1%">:</th>
								<td>{{ $read_admins->name }}</td>
							</tr>
							<tr>
								<th>Level System</th>
								<th>:</th>
								<td>{{ $read_admins->name_level_systems }}</td>
							</tr>
							<tr>
								<th>Email</th>
								<th>:</th>
								<td><a href="mailto:{{ $read_admins->email }}">{{ $read_admins->email }}</a></td>
							</tr>
							<tr>
								<th>Created</th>
								<th>:</th>
								<td>{{ Shwetech::changeDBToDatetime($read_admins->created_at) }}</td>
							</tr>
							<tr>
								<th>Updated</th>
								<th>:</th>
								<td>{{ Shwetech::changeDBToDatetime($read_admins->updated_at) }}</td>
							</tr>
						</table>
						<br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/admin')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop