@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Confirmation BOT</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/register_bot') }}">Confirmation BOT</a></li>
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

    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/register_bot/processconfirmation/'.$confirmation_bots->id_bots) }}" method="POST">
    						{{ csrf_field() }}
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('country_phone_codes_id')) }}">
                                <label class="form-control-label">Country Code <b style="color:red">*</b></label>
                                @php($get_country_phone_codes = \App\Master_country_phone_code::where('id_country_phone_codes',$confirmation_bots->country_phone_codes_id)->first())
                                @php($get_name_country_phone_codes = $get_country_phone_codes->name_country_phone_codes)
                                @php($get_code_country_phone_codes = $get_country_phone_codes->code_country_phone_codes)
                                <input id="id_country_phone_codes" type="hidden" name="id_country_phone_codes" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('id_country_phone_codes')) }}" value="{{ Request::old('id_country_phone_codes') == '' ? $confirmation_bots->country_phone_codes_id : Request::old('id_country_phone_codes') }}" placeholder="Country" required>
                                <input id="country_phone_codes_id" type="text" name="country_phone_codes_id" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('country_phone_codes_id')) }}" value="{{ Request::old('country_phone_codes_id') == '' ? $get_name_country_phone_codes.' - '.$get_code_country_phone_codes : Request::old('country_phone_codes_id') }}" placeholder="Country Code" readonly required>
                                {{ Shwetech::formError($errors->first('country_phone_codes_id')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('phone_number_bots')) }}">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_bots" type="text" name="phone_number_bots" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('phone_number_bots')) }}" value="{{ Request::old('phone_number_bots') == '' ? $confirmation_bots->phone_number_bots : Request::old('phone_number_bots') }}" placeholder="Phone Number With Country Code" readonly required>
                                {{ Shwetech::formError($errors->first('phone_number_bots')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('code_bots')) }}">
                                <label class="form-control-label">Code <b style="color:red">*</b></label>
                                <input id="code_bots" type="text" name="code_bots" class="form-control number_format {{ Shwetech::errorStyleFormControl($errors->first('code_bots')) }}" value="{{ Request::old('code_bots') }}" placeholder="Code" required>
                                {{ Shwetech::formError($errors->first('code_bots')) }}
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name_bots')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name_bots" type="text" name="name_bots" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name_bots')) }}" value="{{ Request::old('name_bots') == '' ? $confirmation_bots->name_bots : Request::old('name_bots') }}" placeholder="Name" required>
                                {{ Shwetech::formError($errors->first('name_bots')) }}
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