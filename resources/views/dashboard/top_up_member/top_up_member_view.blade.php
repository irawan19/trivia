@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Top Up Member</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Top Up Member</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    <div class="row">
	                       	<div class="col-lg-12">
								<form method="GET" action="{{ URL('dashboard/top_up_member/search') }}" class="form-horizontal m-t-40">
									{{ csrf_field() }}
									<div class="input-group">
										<input id="getStartEndDate" name="search_date" value="{{ $result_date_start.' - '.$result_date_end  }}" class="form-control" type="text">
										@if(Auth::user()->level_systems_id != 3)
											<select name="search_agent" class="custom-select" id="inlineFormCustomSelect" required autofocus>
			                                    @php($selected_none = '')
		                                        @if($result_agent == 0)
		                                             @php($selected_none = 'selected')
		                                        @endif
			                                    <option value="0" {{ $selected_none }}>All</option>
			                                    @foreach($view_agent as $agent)
			                                    	@php($selected = '')
			                                    	@if($agent->id == $result_agent)
			                                    		@php($selected = 'selected')
			                                    	@endif

			                                    	@if(Auth::user()->level_systems_id == 1)
			                                    		@php($id_master_agent = $agent->sub_users_id)
			                                    		@php($get_master_agent = \App\Master_user::where('id',$id_master_agent)->first())
			                                    		<option value="{{ $agent->id }}" {{ $selected }} >{{ $get_master_agent->name.' - '.$agent->name }}</option>
			                                    	@else(Auth::user()->level_systems_id == 2)
			                                    		<option value="" {{ $selected }}>{{ $agent->name }}</option>
			                                    	@endif
			                                    @endforeach
			                                </select>
										@endif
										<input name="search_word" placeholder="search" value="{{ $result_word }}" class="form-control" type="text">
										<span class="input-group-btn">
											<button class="btn btn-info" name="submit_search" value="submit_search" type="submit">Search</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<br/>
						<div align="center">{{ Shwetech::add($link_top_up_member,'dashboard/top_up_member/add') }}</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Date</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Time</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">From</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Member</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">Credit</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_top_up_members as $top_up_members)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ Shwetech::changeDBToDate($top_up_members->date_top_ups) }}</td>
		                                <td>{{ $top_up_members->time_top_ups }}</td>
		                                <td>{{ $top_up_members->name }}</td>
		                                <td>{{ $top_up_members->phone_number_register_members }}</td>
		                                <td>{{ $top_up_members->credit_top_ups }}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_top_up_member,'dashboard/top_up_member/read/'.$top_up_members->id_top_ups) }}
														{{ Shwetech::edit($link_top_up_member,'dashboard/top_up_member/edit/'.$top_up_members->id_top_ups) }}
														{{ Shwetech::delete($link_top_up_member,'dashboard/top_up_member/delete/'.$top_up_members->id_top_ups,$top_up_members->name) }}
													</div>
												</div>
											</div>
		                                </td>
		                            </tr>
		                            @php($no++)
		                        @endforeach
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop