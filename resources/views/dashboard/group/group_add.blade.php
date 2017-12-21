@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Group</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/group') }}">Manage Group</a></li>
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

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/group/processadd') }}" method="POST">
    						{{ csrf_field() }}
    						@if(Auth::user()->level_systems_id != 3)
	    						<div class="form-group row">
		                            <label for="example-month-input" class="col-2 col-form-label">Agent <i style="color:red">*</i></label>
		                            <div class="col-12">
		                                <select name="users_id" class="custom-select col-12 select2" id="users_id" required autofocus>
		                                    <option value="">Please Choose...</option>
		                                    @foreach($add_agents as $agents)
		                                    	@if(Auth::user()->level_systems_id == 1)
		                                    		@php($get_master_agent = \App\Master_user::where('id',$agents->sub_users_id)->first())
		                                        	<option value="{{ $agents->id }}" get_credit_agent="{{ $agents->credit_users }}" {{ Request::old('users_id') == $agents->id ? $select='selected' : $select='' }}>{{ $get_master_agent->name }} - {{ $agents->name }}</option>
		                                    	@else
		                                    		<option value="{{ $agents->id }}" get_credit_agent="{{ $agents->credit_users }}" {{ Request::old('users_id') == $agents->id ? $select='selected' : $select='' }}>{{ $agents->name }}</option>
		                                    	@endif
		                                    @endforeach
		                                </select>
		                                {{ Shwetech::formError($errors->first('users_id')) }}
		                            </div>
		                        </div>
		                    @else
                                <input id="users_id" type="hidden" name="users_id" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('users_id')) }}" value="{{ Auth::user()->id }}">
		                    @endif
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name_groups')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name_groups" type="text" name="name_groups" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name_groups')) }}" value="{{ Request::old('name_groups') }}" placeholder="Name" required>
                                {{ Shwetech::formError($errors->first('name_groups')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_agents')) }}">
                                <label class="form-control-label">Credit Agent <b style="color:red">*</b></label>
                                @if(Auth::user()->level_systems_id != '3')
                                    <input id="credit_agents" type="text" name="credit_agents" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('credit_agents')) }}" value="{{ Request::old('credit_agents') == '' ? 0 : Request::old('credit_agents') }}" placeholder="Credit Agent" readonly>
                                @elseif(Auth::user()->level_systems_id == '3')
                                    <input id="credit_agents" type="text" name="credit_agents" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('credit_agents')) }}" value="{{ $add_agents->credit_users }}" placeholder="Credit Agent">
                                @endif
                                {{ Shwetech::formError($errors->first('credit_agents')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_groups')) }}">
                                <label class="form-control-label">Credit Group <b style="color:red">*</b></label>
                                <input id="credit_groups" type="text" name="credit_groups" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_groups')) }}" value="{{ Request::old('credit_groups') }}" placeholder="Credit Group" requred>
                                {{ Shwetech::formError($errors->first('credit_groups')) }}
                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/group')
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