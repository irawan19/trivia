@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Game</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/game') }}">Manage Game</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/game/processedit/'.$edit_games->id_games) }}" method="POST">
    						{{ csrf_field() }}
    						<div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Agent <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="sessions_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    @foreach($edit_sessions as $sessions)
	                                        @php($selected = '')
			                                @if(Request::old('sessions_id') == '')
			                                	@if($sessions->id_sessions == $edit_games->sessions_id)
			                                		@php($selected = 'selected')
			                                	@endif
			                                @else
			                                	@if($sessions->id_sessions == Request::old('sessions_id'))
			                                		@php($selected = 'selected')
			                                	@endif
			                                @endif

	                                       	@if(Auth::user()->level_systems_id != 3)
			                                @php($get_agent 	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
			                                										->join('users','users_id','users.id')
			                                										->where('id_sessions',$sessions->id_sessions)
			                                										->first())
			                                	@php($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first())
				                            	<option value="{{ $sessions->id_sessions }}" {{ $selected }}>{{ $get_master_agent->name.' - '.$get_agent->name.' | '.$get_agent->name_groups.' | '.$sessions->start_date_sessions.' - '.$sessions->end_date_sessions }}</option>
				                            @else
				                            	<option value="{{ $sessions->id_sessions }}" {{ $selected }}>{{ $sessions->start_date_sessions.' - '.$sessions->end_date_sessions }}</option>
				                            @endif
	                                    @endforeach
	                                </select>
	                                {{ Shwetech::formError($errors->first('sessions_id')) }}
	                            </div>
	                        </div>
	                        <div class="form-group {{ Shwetech::errorStyleFormControl($errors->first('date_games')) }}">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                @php($get_date_games = $edit_games->start_date_games.' - '.$edit_games->end_date_games);
                                <input id="getDateRange" type="text" name="date_games" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('date_games')) }}" value="{{ Request::old('date_games') == '' ? $get_date_games : Request::old('date_games') }}" placeholder="Date" required>
                                {{ Shwetech::formError($errors->first('date_games')) }}
                            </div>
                            <label class="form-control-label">Return to Player <b style="color:red">*</b></label>
                            <div class="input-group {{ Shwetech::errorStyleGroup($errors->first('rtp_games')) }}">
                                <input id="rtp_games" type="text" name="rtp_games" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('rtp_games')) }}" value="{{ Request::old('rtp_games') == '' ? $edit_games->rtp_games : Request::old('rtp_games') }}" placeholder="Return To Player" required aria-describedby="basic-addon2">
                                <span class="input-group-addon" id="basic-addon2">%</span>
                                {{ Shwetech::formError($errors->first('rtp_games')) }}
                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/game')
                            	@endif

                            	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop