@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Master Agent</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/master_agent') }}">Manage Master Agent</a></li>
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
								<td>{{ $read_master_agents->name }}</td>
							</tr>
							<tr>
								<th>Level System</th>
								<th>:</th>
								<td>{{ $read_master_agents->name_level_systems }}</td>
							</tr>
							<tr>
								<th>Email</th>
								<th>:</th>
								<td><a href="mailto:{{ $read_master_agents->email }}">{{ $read_master_agents->email }}</a></td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<th>:</th>
								<td>{{ $read_master_agents->phone_number_users }}</td>
							</tr>
							<tr>
								<th>Bot Phone Number</th>
								<th>:</th>
								<td>{{ $read_master_agents->bot_phone_number_users }}</td>
							</tr>
							<tr>
								<th>Credit</th>
								<th>:</th>
								<td>{{ $read_master_agents->credit_users }}</td>
							</tr>
							<tr>
								<th>Created</th>
								<th>:</th>
								<td>{{ Shwetech::changeDBToDatetime($read_master_agents->created_at) }}</td>
							</tr>
							<tr>
								<th>Updated</th>
								<th>:</th>
								<td>{{ Shwetech::changeDBToDatetime($read_master_agents->updated_at) }}</td>
							</tr>
						</table>
						<br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/master_agent')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop