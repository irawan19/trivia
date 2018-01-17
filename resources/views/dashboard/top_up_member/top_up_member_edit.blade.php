@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Top Up Member</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/top_up_member') }}">Top Up Member</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/top_up_member/processedit/'.$edit_top_up_members->id_top_ups) }}" method="POST">
    						{{ csrf_field() }}
    						
                            <input id="id_top_ups" type="hidden" name="id_top_ups" class="form-control" value="{{ $edit_top_up_members->id_top_ups }}" placeholder="ID" required>
                            <div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Member <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="to_register_members_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    @foreach($edit_members as $members)
	                                        @php($selected = '')
			                                @if(Request::old('to_register_members_id') == '')
			                                	@if($members->id_register_members == $edit_top_up_members->to_register_members_id)
			                                		@php($selected = 'selected')
			                                	@endif
			                                @else
			                                	@if($members->id_register_members == Request::old('to_register_members_id'))
			                                		@php($selected = 'selected')
			                                	@endif
			                                @endif

			                                @if(Auth::user()->level_systems_id != 3)
	                                    		@php($get_agent = \App\Master_user::where('id',$members->sub_users_id)->first())
	                                        	<option value="{{ $members->id_register_members }}" {{ $selected }}>{{ $get_agent->name }} - {{ $members->phone_number_register_members }} ({{ $members->credit_register_members - $edit_top_up_members->credit_top_ups }})</option>
	                                    	@else
	                                    		<option value="{{ $members->id_register_members }}" {{ $selected }}>{{ $members->phone_number_register_members }} ({{ $members->credit_register_members - $edit_top_up->credit_top_ups }})</option>
	                                    	@endif
	                                    @endforeach
	                                </select>
	                                {{ Shwetech::formError($errors->first('to_register_members_id')) }}
	                            </div>
	                        </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('credit_top_ups')) }}">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input id="credit_top_ups" type="text" name="credit_top_ups" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('credit_top_ups')) }}" value="{{ Request::old('credit_top_ups') == '' ? $edit_top_up_members->credit_top_ups : Request::old('credit_top_ups') }}" placeholder="Credit" required>
                                {{ Shwetech::formError($errors->first('credit_top_ups')) }}
                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/top_up_member')
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