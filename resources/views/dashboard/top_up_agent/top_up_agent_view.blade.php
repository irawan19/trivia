@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Top Up Agent</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Top Up Agent</li>
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
								<form method="GET" action="{{ URL('dashboard/top_up_agent/search') }}" class="form-horizontal m-t-40">
									{{ csrf_field() }}
									<div class="input-group">
										<input id="getStartEndDate" name="search_date" value="{{ $result_date_start.' - '.$result_date_end  }}" class="form-control" type="text">
										@if(Auth::user()->level_systems_id == 1)
											<select name="search_master_agent" class="custom-select" id="inlineFormCustomSelect" required autofocus>
			                                    @php($selected_none = '')
		                                        @if($result_master_agent == 0)
		                                             @php($selected_none = 'selected')
		                                        @endif
			                                    <option value="0" {{ $selected_none }}>All</option>
			                                    @foreach($view_master_agent as $master_agent)
			                                    	@php($selected = '')
			                                    	@if($master_agent->id == $result_master_agent)
			                                    		@php($selected = 'selected')
			                                    	@endif
			                                    	<option value="{{ $master_agent->id }}" {{ $selected }} >{{ $master_agent->name }}</option>
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
						<div align="center">{{ Shwetech::add($link_top_up_agent,'dashboard/top_up_agent/add') }}</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Date</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Time</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Agent</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Phone Number</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">Credit</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_top_up_agents as $top_up_agents)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ Shwetech::changeDBToDate($top_up_agents->date_top_ups) }}</td>
		                                <td>{{ $top_up_agents->time_top_ups }}</td>
		                                <td>{{ $top_up_agents->name }}</td>
		                                <td>{{ $top_up_agents->phone_number_users }}</td>
		                                <td>{{ $top_up_agents->credit_top_ups }}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_top_up_agent,'dashboard/top_up_agent/read/'.$top_up_agents->id_top_ups) }}
														{{ Shwetech::edit($link_top_up_agent,'dashboard/top_up_agent/edit/'.$top_up_agents->id_top_ups) }}
														{{ Shwetech::delete($link_top_up_agent,'dashboard/top_up_agent/delete/'.$top_up_agents->id_top_ups,$top_up_agents->name) }}
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