@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Register BOT</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/register_bot') }}">Register BOT</a></li>
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
    		            @if (Session::get('after_save.alert') == 'error')
    		            	{{ Shwetech::errorCustom(Session::get('after_save.text')) }}
    		            @endif

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/register_bot/processregister') }}" method="POST">
    						{{ csrf_field() }}
                            <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Country Code <i style="color:red">*</i></label>
                                <div class="col-12">
                                    <select name="country_phone_codes_id" class="custom-select col-12 select2" id="country_phone_codes_id" required autofocus>
                                        <option value="">Please Choose...</option>
                                        @foreach($add_country_phone_codes as $country_phone_codes)
                                            <option value="{{ $country_phone_codes->id_country_phone_codes }}" {{ Request::old('country_phone_codes_id') == $country_phone_codes->id_country_phone_codes ? $select='selected' : $select='' }}>{{ $country_phone_codes->name_country_phone_codes.' -'.$country_phone_codes->code_country_phone_codes }}</option>
                                        @endforeach
                                    </select>
                                    {{ Shwetech::formError($errors->first('country_phone_codes_id')) }}
                                </div>
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('phone_number_bots')) }}">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_bots" type="text" name="phone_number_bots" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('phone_number_bots')) }}" value="{{ Request::old('phone_number_bots') }}" placeholder="Phone Number With Country Code" required>
                                {{ Shwetech::formError($errors->first('phone_number_bots')) }}
                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/register_bot')
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