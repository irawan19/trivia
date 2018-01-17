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
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    	@if (Session::get('after_save.alert') == 'success')
    		            	{{ Shwetech::formSuccess(Session::get('after_save.text')) }}
    		            @endif

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/game/processadd') }}" method="POST">
    						{{ csrf_field() }}
	    					<div class="form-group row">
		                        <label for="example-month-input" class="col-2 col-form-label">Sessions <i style="color:red">*</i></label>
		                        <div class="col-12">
		                            <select name="sessions_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
		                                <option value="">Please Choose...</option>
		                                @foreach($add_sessions as $sessions)
		                                	@php($check_game = \App\Master_game::where('sessions_id',$sessions->id_sessions)
		                                										->where('status_active_games',0)
		                                										->count())
		                                	@if($check_game == 0)
			                                	@if(Auth::user()->level_systems_id != 3)
			                                		@php($get_agent 	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
			                                												->join('users','users_id','users.id')
			                                												->where('id_sessions',$sessions->id_sessions)
			                                												->first())
			                                		@php($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first())
				                                	<option value="{{ $sessions->id_sessions }}" {{ Request::old('sessions_id') == $sessions->id_sessions ? $select='selected' : $select='' }}>{{ $get_master_agent->name.' - '.$get_agent->name.' | '.$get_agent->name_groups.' | '.$sessions->start_date_sessions.' - '.$sessions->end_date_sessions }}</option>
				                                @else
				                                	<option value="{{ $sessions->id_sessions }}" {{ Request::old('sessions_id') == $sessions->id_sessions ? $select='selected' : $select='' }}>{{ $sessions->start_date_sessions.' - '.$sessions->end_date_sessions }}</option>
				                                @endif
				                            @endif
		                                @endforeach
		                            </select>
		                            {{ Shwetech::formError($errors->first('sessions_id')) }}
		                        </div>
		                    </div>
                            <div class="form-group {{ Shwetech::errorStyleFormControl($errors->first('date_games')) }}">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                <input id="getDateRange" type="text" name="date_games" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('date_games')) }}" value="{{ Request::old('date_games') }}" placeholder="Date" required>
                                {{ Shwetech::formError($errors->first('date_game')) }}
                            </div>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
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