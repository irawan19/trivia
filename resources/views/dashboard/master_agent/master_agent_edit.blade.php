@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Master Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/master_agent') }}">Master Agent</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/master_agent/processedit/'.$edit_master_agents->id) }}" method="POST">
    						{{ csrf_field() }}
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name" type="text" name="name" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name')) }}" value="{{ Request::old('name') == '' ? $edit_master_agents->name : Request::old('name') }}" placeholder="Name" required autofocus>
                                {{ Shwetech::formError($errors->first('name')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('email')) }}">
                                <label class="form-control-label">Email <b style="color:red">*</b></label>
                                <input id="email" type="text" name="email" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('email')) }}" value="{{ Request::old('email') == '' ? $edit_master_agents->email : Request::old('email') }}" placeholder="Email" required>
                                {{ Shwetech::formError($errors->first('email')) }}
                            </div>
                            @php($check_agent = \App\Master_user::where('sub_users_id',$edit_master_agents->id)->count())
                            @if($check_agent == 0)
                                @php($readonly = '')
                            @else
                                @php($readonly = 'readonly="readonly"')
                            @endif
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_users')) }}">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input {{ $readonly }} id="credit_users" type="text" name="credit_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_users')) }}" value="{{ Request::old('credit_users') == '' ? $edit_master_agents->credit_users : Request::old('credit_users') }}" placeholder="Credit" required>
                                {{ Shwetech::formError($errors->first('credit_users')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('phone_number_users')) }}">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_users" type="text" name="phone_number_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('phone_number_users')) }}" value="{{ Request::old('phone_number_users') == '' ? $edit_master_agents->phone_number_users : Request::old('phone_number_users') }}" placeholder="Phone Number" required>
                                {{ Shwetech::formError($errors->first('phone_number_users')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('bot_phone_number_users')) }}">
                                <label class="form-control-label">BOT Phone Number <b style="color:red">*</b></label>
                                <input id="bot_phone_number_users" type="text" name="bot_phone_number_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('bot_phone_number_users')) }}" value="{{ Request::old('bot_phone_number_users') == '' ? $edit_master_agents->bot_phone_number_users : Request::old('bot_phone_number_users') }}" placeholder="BOT Phone Number" required>
                                {{ Shwetech::formError($errors->first('bot_phone_number_users')) }}
                            </div>
                            <br/>
                            <div align="center">
                            	<label style="color:orange">clear the password if you do not want to change the password</label>
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('password')) }}">
                                <label class="form-control-label">Password</label>
                                <input id="password" type="password" name="password" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('password')) }}" value="{{ Request::old('password') }}" placeholder="Password">
                                {{ Shwetech::formError($errors->first('password')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('password_confirmation')) }}">
                                <label class="form-control-label">Conf. Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('password_confirmation')) }}" value="{{ Request::old('password_confirmation') }}" placeholder="Conf. Password">
                                {{ Shwetech::formError($errors->first('password_confirmation')) }}
                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/master_agent')
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