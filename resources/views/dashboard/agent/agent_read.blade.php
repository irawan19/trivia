@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Agent</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/agent') }}">Manage Agent</a></li>
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
								<td>{{ $read_agents->name }}</td>
							</tr>
							<tr>
								<th>Level System</th>
								<th>:</th>
								<td>{{ $read_agents->name_level_systems }}</td>
							</tr>
							<tr>
								<th>Email</th>
								<th>:</th>
								<td><a href="mailto:{{ $read_agents->email }}">{{ $read_agents->email }}</a></td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<th>:</th>
								<td>
									@if($read_agents->phone_number_users != 0)
										@php($phone_number = $read_agents->phone_number_users)
									@else
										@php($phone_number = '-')
									@endif
									{{ $phone_number }}
								</td>
							</tr>
							<tr>
								<th>Credit</th>
								<th>:</th>
								<td>{{ $read_agents->credit_users }}</td>
							</tr>
							<tr>
								<th>Total Group</th>
								<th>:</th>
								<td>{{ $read_agents->max_group_users }}</td>
							</tr>
							<tr>
								<th>Created</th>
								<th>:</th>
								<td>{{ Shwetech::changeDBToDatetime($read_agents->created_at) }}</td>
							</tr>
							<tr>
								<th>Updated</th>
								<th>:</th>
								<td>{{ Shwetech::changeDBToDatetime($read_agents->updated_at) }}</td>
							</tr>
							<tr>
								<th>Sub User</th>
								<th>:</th>
								<td>
									@php($id_sub_users = $read_agents->sub_users_id)
									@if($id_sub_users != 0)
										@php($get_sub_users = \App\Master_user::where('id',$id_sub_users)->first())
										@php($sub_users = $get_sub_users->name)
									@else
										@php($sub_users = '-')
									@endif
									{{ $sub_users }}
								</td>
							</tr>
						</table>
						<br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/agent')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop