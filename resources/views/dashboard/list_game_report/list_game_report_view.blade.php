@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">List Game Report</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">List Game Report</li>
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
								<form method="GET" action="{{ URL('dashboard/list_game_report/search') }}" class="form-horizontal m-t-40">
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
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Credit</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Members</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Start</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">End</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">RTP</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="7">Status</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no_group = 1)
	                        	@foreach($view_list_game_reports as $list_game_reports)
		                            <tr>
		                                <td>{{ $no_group.'. '.$list_game_reports->name_groups }}</td>
		                                <td>{{ $list_game_reports->credit_groups }}</td>
		                                @if(Auth::user()->level_systems_id != 3)
		                                	@if(Auth::user()->level_systems_id == 1)
		                                		<td colspan="5">
		                                			@php($id_master_agent 	= $list_game_reports->sub_users_id)
		                                			@php($get_master_agent = \App\Master_user::where('id',$id_master_agent)->first())
		                                			{{ $get_master_agent->name.' - '.$list_game_reports->name }}
		                                		</td>
		                                	@elseif(Auth::user()->level_systems_id == 2)
		                                		<td colspan="5">
		                                			{{ $list_game_reports->name }}
		                                		</td>
		                                	@endif
		                                @else
			                                <td colspan="5"></td>
		                                @endif
		                            </tr>
			                        @php($id_groups 	= $list_game_reports->id_groups)
			                        @php($get_sessions	= \App\Master_session::where('groups_id',$id_groups)->get())
			                        @php($no_sessions 	= 1)
			                        @foreach($get_sessions as $sessions)
			                            @php($id_sessions 	= $sessions->id_sessions)
			                            <tr>
			                            	<td>{{ $no_group.'.'.$no_sessions.'. Sessions '.$no_sessions }}</td>
			                            	<td>{{ $sessions->credit_member_sessions }} / Members</td>
			                            	<td>
			                            		@php($get_total_register_members = \App\Master_register_member::where('sessions_id',$id_sessions)->count())
			                            		{{$get_total_register_members}}
			                            	</td>
			                            	<td>{{ Shwetech::changeDBToDatetime($sessions->start_date_sessions) }}</td>
			                            	<td>{{ Shwetech::changeDBToDatetime($sessions->end_date_sessions) }}</td>
			                            	<td>{{ $sessions->rtp_sessions }}%</td>
			                            	<td></td>
			                            </tr>
			                            @php($get_game 		= \App\Master_game::where('sessions_id', $id_sessions)->get())
			                            @php($no_game 		= 1)
			                            @foreach($get_game as $game)
			                            	<tr>
			                            		<td>{{ $no_group.'.'.$no_sessions.'.'.$no_game }}</td>
			                            		<td></td>
			                            		<td></td>
			                            		<td>{{ Shwetech::changeDBToDatetime($game->start_date_games) }}</td>
			                            		<td>{{ Shwetech::changeDBToDatetime($game->end_date_games) }}</td>
			                            		<td></td>
			                            		<td>
			                            			@if($game->status_active_games == '0')
			                            				@php($status_game = 'Pending')
			                            				@php($style_status_game = 'style="color:red"')
			                            			@elseif($game->status_active_games == '1')
			                            				@php($status_game = 'Active')
			                            				@php($style_status_game = 'style="color:green"')
			                            			@elseif($game->status_active_games == '2')
			                            				@php($status_game = 'Finished')
			                            				@php($style_status_game = 'style="color:blue"')
			                            			@endif

			                            			<b {{ $style_status_game }}>{{ $status_game }}</b>
			                            		</td>
			                            	</tr>
			                            	@php($no_game++)
			                            @endforeach
			                            @php($no_sessions++)
			                        @endforeach
		                            @php($no_group++)
		                        @endforeach
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop