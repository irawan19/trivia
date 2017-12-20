@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Sessions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/sessions') }}">Manage Sessions</a></li>
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

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/sessions/processadd') }}" method="POST">
    						{{ csrf_field() }}
	    					<div class="form-group row">
		                        <label for="example-month-input" class="col-2 col-form-label">Group <i style="color:red">*</i></label>
		                        <div class="col-12">
		                            <select name="groups_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
		                                <option value="">Please Choose...</option>
		                                @foreach($add_groups as $groups)
                                            @php($check_last_sessions =\App\Master_session::where('groups_id',$groups->id_groups)
                                                                                            ->where('status_active_sessions','0')
                                                                                            ->orWhere('status_active_sessions','1')
                                                                                            ->where('groups_id',$groups->id_groups)
                                                                                            ->count())
                                            @if($check_last_sessions == 0)
    		                                	@if(Auth::user()->level_systems_id != 3)
    		                                		@php($get_agent 	= \App\Master_user::where('id',$groups->users_id)->first())
    		                                		@php($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first())
    			                                	<option value="{{ $groups->id_groups }}" {{ Request::old('groups_id') == $groups->id_groups ? $select='selected' : $select='' }}>{{ $get_master_agent->name.' - '.$get_agent->name.' | '.$groups->name_groups }}</option>
    			                                @else
    			                                	<option value="{{ $groups->id_groups }}" {{ Request::old('groups_id') == $groups->id_groups ? $select='selected' : $select='' }}>{{ $groups->name_groups }}</option>
                                                @endif
    			                             @endif
                                        @endforeach
		                            </select>
		                            {{ Shwetech::formError($errors->first('groups_id')) }}
		                        </div>
		                    </div>
                            <div class="form-group {{ Shwetech::errorStyleFormControl($errors->first('date_sessions')) }}">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                <input id="getDateRange" type="text" name="date_sessions" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('date_sessions')) }}" value="{{ Request::old('date_sessions') }}" placeholder="Date" required>
                                {{ Shwetech::formError($errors->first('date_sessions')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleFormControl($errors->first('credit_member_sessions')) }}">
                                <label class="form-control-label">Credit Member <b style="color:red">*</b></label>
                                <input id="credit_member_sessions" type="text" name="credit_member_sessions" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_member_sessions')) }}" value="{{ Request::old('credit_member_sessions') }}" placeholder="Credit Member" required>
                                {{ Shwetech::formError($errors->first('credit_member_sessions')) }}
                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/sessions')
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