@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Admin</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/admin') }}">Admin</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/admin/processedit/'.$edit_admins->id) }}" method="POST">
    						{{ csrf_field() }}
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name" type="text" name="name" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name')) }}" value="{{ Request::old('name') == '' ? $edit_admins->name : Request::old('name') }}" placeholder="Name" required autofocus>
                                {{ Shwetech::formError($errors->first('name')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('email')) }}">
                                <label class="form-control-label">Email <b style="color:red">*</b></label>
                                <input id="email" type="text" name="email" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('email')) }}" value="{{ Request::old('email') == '' ? $edit_admins->email : Request::old('email') }}" placeholder="Email" required>
                                {{ Shwetech::formError($errors->first('email')) }}
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
                            		@php($get_back = 'dashboard/admin')
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