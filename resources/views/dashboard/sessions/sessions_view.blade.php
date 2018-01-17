@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Sessions</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Manage Sessions</li>
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
								<form method="GET" action="{{ URL('dashboard/sessions/search') }}" class="form-horizontal m-t-40">
									{{ csrf_field() }}
									<div class="input-group">
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
							<div align="center">{{ Shwetech::add($link_sessions,'dashboard/sessions/add') }}</div>
						@else
							@php($get_user = Auth::user()->id)
							@php($date_now = date('Y-m-d H:i:s'))
							@php($check_last_sessions = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
																			->where('users_id',$get_user)
																			->where('end_date_sessions','>',$date_now)
																			->count())
							@if($check_last_sessions == 0)
								<div align="center">{{ Shwetech::add($link_sessions,'dashboard/sessions/add') }}</div>
							@endif
						@endif
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Group</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Start</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">End</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Credit/Member</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">RTP</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="7">Status</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_sessions as $sessions)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ $sessions->name_groups }}</td>
		                                <td>{{ Shwetech::changeDBToDatetime($sessions->start_date_sessions) }}</td>
		                                <td>{{ Shwetech::changeDBToDatetime($sessions->end_date_sessions) }}</td>
		                                <td>{{ ROUND($sessions->credit_member_sessions) }}</td>
		                                <td>{{ ROUND($sessions->rtp_sessions) }}</td>
		                                <td>{!! Shwetech::convertStatus($sessions->status_active_sessions) !!}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_sessions,'dashboard/sessions/read/'.$sessions->id_sessions) }}
														@php($check_game = \App\Master_game::where('sessions_id',$sessions->id_sessions)->count())
														@if($check_game == 0)
															{{ Shwetech::edit($link_sessions,'dashboard/sessions/edit/'.$sessions->id_sessions) }}
															{{ Shwetech::delete($link_sessions,'dashboard/sessions/delete/'.$sessions->id_sessions,Shwetech::changeDBToDatetime($sessions->start_date_sessions).' - '.Shwetech::changeDBToDatetime($sessions->end_date_sessions)) }}
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