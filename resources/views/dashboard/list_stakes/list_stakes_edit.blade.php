@extends('dashboard.layouts.container')
@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">List Stakes</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ URL('dashboard/list_stakes') }}">List Stakes</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
		            <form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/list_stakes/processedit/'.$edit_list_stakes->id_list_stakes) }}" method="POST">
						{{ csrf_field() }}
                        <div class="form-group row" align="center">
                            <div class="col-md-12">
                                <a href="{{ URL::to($edit_list_stakes->path_image_list_stakes) }}/{{ $edit_list_stakes->name_image_list_stakes }}" class="image-popup-no-margins"><img src="{{ URL::to($edit_list_stakes->path_image_list_stakes) }}/{{ $edit_list_stakes->name_image_list_stakes }}"></a>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                            <label style="color:orange">better image size 500x500px</label>
                        </div>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="hidden">
                                <input type="file" name="userfile_image" id="list_stakes_image" />
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                        {{ Shwetech::formError($errors->first('userfile_image')) }}
                        <br/>
                        <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name_list_stakes')) }}">
                            <label class="form-control-label">Name <b style="color:red">*</b></label>
                            <input id="name_list_stakes" type="text" name="name_list_stakes" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name_list_stakes')) }}" value="{{ Request::old('name_list_stakes') == '' ? $edit_list_stakes->name_list_stakes : Request::old('name_list_stakes') }}" placeholder="List Stakes" required>
                            {{ Shwetech::formError($errors->first('name_list_stakes')) }}
                        </div>
                        <br/>
                        <div class="form-group" align="center">
	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
	            			@if(request()->session()->get('page') != '')
	            				@php($get_back = request()->session()->get('page'))
                        	@else
                        		@php($get_back = 'dashboard/list_stakes')
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