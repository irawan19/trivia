@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Agent</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Manage Agent</li>
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
								<form method="GET" action="{{ URL('dashboard/agent/search') }}" class="form-horizontal m-t-40">
									{{ csrf_field() }}
									<div class="input-group">
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
						<div align="center">{{ Shwetech::add($link_agent,'dashboard/agent/add') }}</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Name</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Phone Number</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Total Group</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Credit</th>
	                                @if(Auth::user()->level_systems_id == 1)
	                                	<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">Agent</th>
	                                @endif
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_agents as $agents)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ $agents->name }}</td>
		                                <td>{{ $agents->phone_number_users }}</td>
		                                <td>{{ $agents->max_group_users }}</td>
		                                <td>{{ $agents->credit_users }}</td>
		                                @if(Auth::user()->level_systems_id == 1)
	                                		@php($sub_users_id = $agents->sub_users_id)
	                                		@php($get_sub_users = \App\Master_user::where('id',$sub_users_id)->first())
		                                	<td>{{ $get_sub_users->name }}</td>
		                                @endif
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_agent,'dashboard/agent/read/'.$agents->id) }}
														{{ Shwetech::edit($link_agent,'dashboard/agent/edit/'.$agents->id) }}
														@php($check_group_agent = \App\Master_group::where('users_id',$agents->id)->count())
														@if($check_group_agent == 0)
															{{ Shwetech::delete($link_agent,'dashboard/agent/delete/'.$agents->id,$agents->name_level_systems.' - '.$agents->name) }}
														@endif
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