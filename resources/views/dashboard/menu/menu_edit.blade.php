@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Menu</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/menu') }}">Menu</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/menu/processedit/'.$edit_menus->id_menus) }}" method="POST">
    						{{ csrf_field() }}
                            <div class="form-group row">
                                <label for="example-month-input" class="col-2 col-form-label">Icons <i style="color:red">*</i></label>
                                <div class="col-12">
                                    <select name="icon_menus" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
                                        <option value="">Please Choose...</option>
                                        @foreach($view_icons as $icons)
                                            @php($selected = '')
                                            @if(Request::old('icons') == '')
                                                @if($icons == $edit_menus->icon_menus)
                                                    @php($selected = 'selected')
                                                @endif
                                            @else
                                                @if($icons == Request::old('icon_menus'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
                                            <option value="{{ $icons }}" {{ $selected }}>{{ $icons }}</option>
                                        @endforeach
                                    </select>
                                    {{ Shwetech::formError($errors->first('icon_menus')) }}
                                </div>
                            </div>
                            <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name_menus')) }}">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name_menus" type="text" name="name_menus" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name_menus')) }}" value="{{ Request::old('name_menus') == '' ? $edit_menus->name_menus : Request::old('name_menus') }}" placeholder="Name" required autofocus>
                                {{ Shwetech::formError($errors->first('name_menus')) }}
                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			@if(request()->session()->get('page') != '')
    	            				@php($get_back = request()->session()->get('page'))
                            	@else
                            		@php($get_back = 'dashboard/menu')
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