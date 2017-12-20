@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Group</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Manage Group</li>
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
								<form method="GET" action="{{ URL('dashboard/group/search') }}" class="form-horizontal m-t-40">
									{{ csrf_field() }}
									<div class="input-group">
										@if(Auth::user()->level_systems_id == 1)
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
			                                    		@php($get_master_agent = \App\Master_user::where('id',$agent->sub_users_id)->first())
			                                    		<option value="{{ $agent->id }}" {{ $selected }} >{{ $get_master_agent->name }} - {{ $agent->name }}</option>
			                                    	@elseif(Auth::user()->level_systems_id == 2)
			                                    		<option value="{{ $agent->id }}" {{ $selected}} >{{ $agent->name }}</option>
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
						@if(Auth::user()->level_systems_id != '3')
							<div align="center">{{ Shwetech::add($link_group,'dashboard/group/add') }}</div>
						@else
							@php($get_users = \App\Master_user::where('id',Auth::user()->id)->first())
							@php($check_total_group = \App\Master_group::where('users_id',Auth::user()->id)->count())
							@if($check_total_group < $get_users->max_group_users)
								<div align="center">{{ Shwetech::add($link_group,'dashboard/group/add') }}</div>
							@endif
						@endif
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Date</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Credit</th>
	                                @if(Auth::user()->level_systems_id != 3)
	                                	<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Agent</th>
	                                @endif
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_groups as $groups)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ Shwetech::changeDBToDatetime($groups->created_on_groups) }}</td>
		                                <td>{{ $groups->name_groups }}</td>
		                                <td>{{ $groups->credit_groups }}</td>
		                                @if(Auth::user()->level_systems_id != 3)
		                                	@php($get_agent 	= \App\Master_user::where('id',$groups->users_id)->first())
		                                	@php($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first())
		                                	<td>{{ $get_master_agent->name.' - '.$get_agent->name }}</td>
		                                @endif
		                                <td width="5%">
		                                	@php($check_sessions = \App\Master_session::where('groups_id',$groups->id_groups)->count())
											@if($check_sessions == 0)
			                                	<div class="input-group">
													<div class="input-group-btn">
														<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
															<span class="caret"></span>
														</button>
														<div class="dropdown-menu dropdown-menu-right action">
															{{ Shwetech::edit($link_group,'dashboard/group/edit/'.$groups->id_groups) }}
															{{ Shwetech::delete($link_group,'dashboard/group/delete/'.$groups->id_groups,$groups->name_groups) }}
														</div>
													</div>
												</div>
											@endif
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