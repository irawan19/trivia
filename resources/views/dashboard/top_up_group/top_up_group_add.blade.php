@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Top Up Group</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/top_up_group') }}">Top Up Group</a></li>
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

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/top_up_group/processadd') }}" method="POST">
    						{{ csrf_field() }}
    						<div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Group <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="to_groups_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    @foreach($add_groups as $groups)
	                                    	@if(Auth::user()->level_systems_id == 1)
	                                    		@php($get_agent = \App\Master_user::where('id',$groups->id)->first())
	                                    		@php($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first())
	                                        	<option value="{{ $groups->id_groups }}" {{ Request::old('to_groups_id') == $groups->id_groups ? $select='selected' : $select='' }}>{{ $get_master_agent->name }} - {{ $get_agent->name }} - {{ $groups->name_groups }} ({{$groups->credit_groups}})</option>
	                                    	@elseif(Auth::user()->level_systems_id == 2)
	                                    		@php($get_agent = \App\Master_user::where('id',$groups->id)->first())
	                                    		<option value="{{ $groups->id_groups }}" {{ Request::old('to_groups_id') == $groups->id_groups ? $select='selected' : $select='' }}>{{ $get_agent->name }} - {{ $groups->name_groups }} ({{$groups->credit_groups}})</option>
	                                    	@elseif(Auth::user()->level_systems_id == 3)
	                                    		<option value="{{ $groups->id_groups }}" {{ Request::old('to_groups_id') == $groups->id_groups ? $select='selected' : $select='' }}>{{ $groups->name_groups }} ({{$groups->credit_groups}})</option>
	                                    	@endif
	                                    @endforeach
	                                </select>
	                                {{ Shwetech::formError($errors->first('to_groups_id')) }}
	                            </div>
	                        </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_top_ups')) }}">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input id="credit_top_ups" type="text" name="credit_top_ups" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_top_ups')) }}" value="{{ Request::old('credit_top_ups') }}" placeholder="Credit" required>
                                {{ Shwetech::formError($errors->first('credit_top_ups')) }}
                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/top_up_group')
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