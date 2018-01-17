@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Top Up Member</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/top_up_member') }}">Top Up Member</a></li>
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
								<td>{{ Shwetech::changeDBToDate($read_top_up_members->date_top_ups) }}</td>
							</tr>
							<tr>
								<th>Time</th>
								<th>:</th>
								<td>{{ $read_top_up_members->time_top_ups }}</td>
							</tr>
							<tr>
								<th>From</th>
								<th>:</th>
								<td>
									@php($get_from = \App\Master_user::where('id',$read_top_up_members->from_users_id)->first())
									{{ $get_from->name }}
								</td>
							</tr>
							<tr>
								<th>Member</th>
								<th>:</th>
								<td>
									@php($get_to = \App\Master_register_member::where('id_register_members',$read_top_up_members->to_register_members_id)->first())
									{{ $get_to->phone_number_register_members }}
								</td>
							</tr>
							<tr>
								<th>Credit</th>
								<th>:</th>
								<td>{{ $read_top_up_members->credit_top_ups }}</td>
							</tr>
						</table>
						<br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/top_up_member')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop