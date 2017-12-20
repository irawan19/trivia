@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Game</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Manage Game</li>
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
								<form method="GET" action="{{ URL('dashboard/game/search') }}" class="form-horizontal m-t-40">
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
							<div align="center">{{ Shwetech::add($link_game,'dashboard/game/add') }}</div>
						@else
							@php($get_users = \App\Master_user::where('id',Auth::user()->id)->first())
							@php($check_total_game = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
																		->join('master_groups','groups_id','=','master_groups.id_groups')
																		->where('users_id',$get_users)
																		->where('status_active_games','0')
																		->orWhere('status_active_games','1')
																		->where('users_id',$get_users)
																		->count())
							@if($check_total_game == 0)
								<div align="center">{{ Shwetech::add($link_game,'dashboard/game/add') }}</div>
							@endif
						@endif
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Group</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Sessions</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Start</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">RTP</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Status</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_game as $game)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ $game->name_groups }}</td>
		                                <td>{{ $game->name_sessions }}</td>
		                                <td>{{ Shwetech::changeDBToDatetime($game->start_date_games) }}</td>
		                                <td>{{ Shwetech::changeDBToDatetime($game->end_date_games) }}</td>
		                                <td>{{ $game->rtp_games }}</td>
		                                <td>{!! Shwetech::convertStatus($game->status_active_games) !!}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_game,'dashboard/game/read/'.$game->id_games) }}
														{{ Shwetech::edit($link_game,'dashboard/game/edit/'.$game->id_games) }}
														{{ Shwetech::delete($link_game,'dashboard/game/delete/'.$game->id_games,Shwetech::changeDBToDatetime($game->start_date_games).' - '.Shwetech::changeDBToDatetime($game->end_date_games)) }}
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