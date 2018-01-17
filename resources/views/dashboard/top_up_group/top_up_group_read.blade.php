@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Top Up Group</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/top_up_group') }}">Top Up Group</a></li>
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
								<td>{{ Shwetech::changeDBToDate($read_top_up_groups->date_top_ups) }}</td>
							</tr>
							<tr>
								<th>Time</th>
								<th>:</th>
								<td>{{ $read_top_up_groups->time_top_ups }}</td>
							</tr>
							<tr>
								<th>From</th>
								<th>:</th>
								<td>
									@php($get_from = \App\Master_user::where('id',$read_top_up_groups->from_users_id)->first())
									{{ $get_from->name }}
								</td>
							</tr>
							<tr>
								<th>Group</th>
								<th>:</th>
								<td>
									@php($get_to = \App\Master_group::join('users','users_id','=','users.id')
																	->where('id_groups',$read_top_up_groups->to_groups_id)
																	->first())
									{{ $get_to->name_groups }}
								</td>
							</tr>
							<tr>
								<th>Agent</th>
								<th>:</th>
								<td>
									{{ $get_to->name }}
								</td>
							</tr>
							<tr>
								<th>Credit</th>
								<th>:</th>
								<td>{{ $read_top_up_groups->credit_top_ups }}</td>
							</tr>
						</table>
						<br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/top_up_group')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop