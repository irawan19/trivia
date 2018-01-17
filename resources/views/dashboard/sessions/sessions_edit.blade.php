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
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/sessions/processedit/'.$edit_sessions->id_sessions) }}" method="POST">
    						{{ csrf_field() }}
    						<div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Group <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="groups_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    @foreach($edit_groups as $groups)
	                                        @php($selected = '')
			                                @if(Request::old('groups_id') == '')
			                                	@if($groups->id_groups == $edit_sessions->groups_id)
			                                		@php($selected = 'selected')
			                                	@endif
			                                @else
			                                	@if($groups->id_groups == Request::old('groups_id'))
			                                		@php($selected = 'selected')
			                                	@endif
			                                @endif

	                                        @if(Auth::user()->level_systems_id != 3)
		                                		@php($get_agent 	= \App\Master_user::where('id',$groups->users_id)->first())
		                                		@php($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first())
			                                	<option value="{{ $groups->id_groups }}" {{ $selected }}>{{ $get_master_agent->name.' - '.$get_agent->name.' | '.$groups->name_groups }}</option>
			                                @else
			                                	<option value="{{ $groups->id_groups }}" {{ $selected }}>{{ $groups->name_groups }}</option>
			                                @endif
	                                    @endforeach
	                                </select>
	                                {{ Shwetech::formError($errors->first('groups_id')) }}
	                            </div>
	                        </div>
	                        <div class="form-group {{ Shwetech::errorStyleFormControl($errors->first('date_sessions')) }}">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                @php($get_date_sessions = $edit_sessions->start_date_sessions.' - '.$edit_sessions->end_date_sessions);
                                <input id="getDateRange" type="text" name="date_sessions" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('date_sessions')) }}" value="{{ Request::old('date_sessions') == '' ? $get_date_sessions : Request::old('date_sessions') }}" placeholder="Date" required>
                                {{ Shwetech::formError($errors->first('date_sessions')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_member_sessions')) }}">
                                <label class="form-control-label">Credit Member <b style="color:red">*</b></label>
                                <input id="credit_member_sessions" type="text" name="credit_member_sessions" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_member_sessions')) }}" value="{{ Request::old('credit_member_sessions') == '' ? $edit_sessions->credit_member_sessions : Request::old('credit_member_sessions') }}" placeholder="Credit Member" required>
                                {{ Shwetech::formError($errors->first('credit_member_sessions')) }}
                            </div>
                            <label class="form-control-label">Return to Player <b style="color:red">*</b></label>
                            <div class="input-group {{ Shwetech::errorStyleGroup($errors->first('rtp_sessions')) }}">
                                <input id="rtp_sessions" type="text" name="rtp_sessions" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('rtp_sessions')) }}" value="{{ Request::old('rtp_sessions') == '' ? $edit_sessions->rtp_sessions : Request::old('rtp_sessions') }}" placeholder="Return To Player" required aria-describedby="basic-addon2">
                                <span class="input-group-addon" id="basic-addon2">%</span>
                                {{ Shwetech::formError($errors->first('rtp_sessions')) }}
                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
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