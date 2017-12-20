@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Master Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/master_agent') }}">Manage Master Agent</a></li>
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

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/master_agent/processadd') }}" method="POST">
    						{{ csrf_field() }}
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name" type="text" name="name" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name')) }}" value="{{ Request::old('name') }}" placeholder="Name" required>
                                {{ Shwetech::formError($errors->first('name')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('email')) }}">
                                <label class="form-control-label">Email <b style="color:red">*</b></label>
                                <input id="email" type="text" name="email" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('email')) }}" value="{{ Request::old('email') }}" placeholder="Email" required>
                                {{ Shwetech::formError($errors->first('email')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('phone_number_users')) }}">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_users" type="text" name="phone_number_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('phone_number_users')) }}" value="{{ Request::old('phone_number_users') }}" placeholder="Phone Number" required>
                                {{ Shwetech::formError($errors->first('phone_number_users')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_users')) }}">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input id="credit_users" type="text" name="credit_users" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_users')) }}" value="{{ Request::old('credit_users') }}" placeholder="Credit" required>
                                {{ Shwetech::formError($errors->first('credit_users')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('password')) }}">
                                <label class="form-control-label">Password <b style="color:red">*</b></label>
                                <input id="password" type="password" name="password" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('password')) }}" value="{{ Request::old('password') }}" placeholder="Password" required>
                                {{ Shwetech::formError($errors->first('password')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('password_confirmation')) }}">
                                <label class="form-control-label">Conf. Password <b style="color:red">*</b></label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('password_confirmation')) }}" value="{{ Request::old('password_confirmation') }}" placeholder="Conf. Password" required>
                                {{ Shwetech::formError($errors->first('password_confirmation')) }}
                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
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