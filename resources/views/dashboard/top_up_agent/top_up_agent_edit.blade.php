@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Top Up Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/top_up_agent') }}">Top Up Agent</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/top_up_agent/processedit/'.$edit_top_up_agents->id_top_ups) }}" method="POST">
    						{{ csrf_field() }}
    						
                            <input id="id_top_ups" type="hidden" name="id_top_ups" class="form-control" value="{{ $edit_top_up_agents->id_top_ups }}" placeholder="ID" required>
                            <div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Agent <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="to_users_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    @foreach($edit_agents as $agents)
	                                        @php($selected = '')
			                                @if(Request::old('to_users_id') == '')
			                                	@if($agents->id == $edit_top_up_agents->to_users_id)
			                                		@php($selected = 'selected')
			                                	@endif
			                                @else
			                                	@if($agents->id == Request::old('to_users_id'))
			                                		@php($selected = 'selected')
			                                	@endif
			                                @endif

			                                @if(Auth::user()->level_systems_id == 1)
		                                		@php($get_agent = \App\Master_user::where('id',$agents->sub_users_id)->first())
		                                    	<option value="{{ $agents->id }}" {{ $selected }}>{{ $get_agent->name }} - {{ $agents->name }}</option>
		                                	@else
		                                		<option value="{{ $agents->id }}" {{ $selected }}>{{ $agents->name }}</option>
		                                	@endif
	                                    @endforeach
	                                </select>
	                                {{ Shwetech::formError($errors->first('to_users_id')) }}
	                            </div>
	                        </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_top_ups')) }}">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input id="credit_top_ups" type="text" name="credit_top_ups" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_top_ups')) }}" value="{{ Request::old('credit_top_ups') == '' ? $edit_top_up_agents->credit_top_ups : Request::old('credit_top_ups') }}" placeholder="Credit" required>
                                {{ Shwetech::formError($errors->first('credit_top_ups')) }}
                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/top_up_agent')
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