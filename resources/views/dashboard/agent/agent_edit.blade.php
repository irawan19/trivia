@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/agent') }}">Manage Agent</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/agent/processedit/'.$edit_agents->id) }}" method="POST">
    						{{ csrf_field() }}
    						@if(Auth::user()->level_systems_id == 1)
	                            <div class="form-group row">
	                                <label for="example-month-input" class="col-2 col-form-label">Sub User <i style="color:red">*</i></label>
	                                <div class="col-12">
	                                    <select name="sub_users_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                        @php($selected_none = '')
	                                        @if($edit_agents->sub_users_id == 0)
	                                             @php($selected_none = 'selected')
	                                        @endif
	                                        <option value="0" {{ $selected_none }}>None</option>
	                                        @foreach($edit_sub_users as $sub_users)
	                                            @php($selected = '')
	                                            @if(Request::old('sub_users_id') == '')
	                                                @if($sub_users->id != 0 && $sub_users->id == $edit_agents->sub_users_id)
	                                                    @php($selected = 'selected')
	                                                @endif
	                                            @else
	                                                @if($sub_users->id == Request::old('sub_users_id'))
	                                                    @php($selected = 'selected')
	                                                @endif
	                                            @endif

	                                            <option value="{{ $sub_users->id }}" {{ $selected }}>{{ $sub_users->name }}</option>
	                                        @endforeach
	                                    </select>
	                                    {{ Shwetech::formError($errors->first('sub_users_id')) }}
	                                </div>
	                            </div>
	                        @else
	                        	<input id="sub_users_id" type="hidden" name="sub_users_id" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('sub_users_id')) }}" value="{{ Auth::user()->id }}">
	                        @endif
                            <input id="id_agent" type="hidden" name="id_agent" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('id_agent')) }}" value="{{ $edit_agents->id }}">
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name" type="text" name="name" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name')) }}" value="{{ Request::old('name') == '' ? $edit_agents->name : Request::old('name') }}" placeholder="Name" required autofocus>
                                {{ Shwetech::formError($errors->first('name')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('email')) }}">
                                <label class="form-control-label">Email <b style="color:red">*</b></label>
                                <input id="email" type="text" name="email" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('email')) }}" value="{{ Request::old('email') == '' ? $edit_agents->email : Request::old('email') }}" placeholder="Email" required>
                                {{ Shwetech::formError($errors->first('email')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('phone_number_users')) }}">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_users" type="text" name="phone_number_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('phone_number_users')) }}" value="{{ Request::old('phone_number_users') == '' ? $edit_agents->phone_number_users : Request::old('phone_number_users') }}" placeholder="Phone Number" required>
                                {{ Shwetech::formError($errors->first('phone_number_users')) }}
                            </div>
                            @php($check_group = \App\Master_group::where('users_id',$edit_agents->id)->count())
                            @if($check_group == 0)
                                @php($readonly = '')
                            @else
                                @php($readonly = 'readonly')
                            @endif
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_users')) }}">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input {{ $readonly }} id="credit_users" type="text" name="credit_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_users')) }}" value="{{ Request::old('credit_users') == '' ? $edit_agents->credit_users : Request::old('credit_users') }}" placeholder="Credit" required>
                                {{ Shwetech::formError($errors->first('credit_users')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('max_group_users')) }}">
                                <label class="form-control-label">Max Group <b style="color:red">*</b></label>
                                <input id="max_group_users" type="text" name="max_group_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('max_group_users')) }}" value="{{ Request::old('max_group_users') == '' ? $edit_agents->max_group_users : Request::old('max_group_users') }}" placeholder="Max Group" required>
                                {{ Shwetech::formError($errors->first('max_group_users')) }}
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
                            		@php($get_back = 'dashboard/agent')
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