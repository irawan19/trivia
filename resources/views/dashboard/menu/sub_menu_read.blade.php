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
	            <li class="breadcrumb-item active">{{ $read_menus->name_menus }}</li>
	            <li class="breadcrumb-item active">Read</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
				        <table class="table table-condensed table-striped">
							<tr>
								<th width="25%">Icon</th>
								<th width="1%">:</th>
								<td><i class="{{ $read_sub_menus->name_menu }}"></i> {{ $read_sub_menus->icon_menus }}</td>
							</tr>
							<tr>
								<th>Name</th>
								<th>:</th>
								<td>{{ $read_sub_menus->name_menus }}</td>
							</tr>
							<tr>
								<th>Link</th>
								<th>:</th>
								<td>{{ $read_sub_menus->link_menus }}</td>
							</tr>
						</table>
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="hf-name">Features</label>
							<br/>
						    <div class="col-sm-12">
								<table class="table table-bordered table-hover">
									<tr>
										<td width="10%" align="center">View <i style="color:red">*</i></td>
										<td width="10%" align="center">Add</td>
										<td width="10%" align="center">Read</td>
										<td width="10%" align="center">Edit</td>
										<td width="10%" align="center">Delete</td>
										<td width="10%" align="center">Print</td>
									</tr>
									<tr>
										@php($id_sub_menus = $read_sub_menus->id_menus)
										@php($get_feature_view = \App\Master_feature::where('menus_id',$id_sub_menus)->where('name_features','view')->count())
										@php($checked_feature_view = '')
										@if($get_feature_view != 0)
											@php($checked_feature_view = 'checked')
										@endif

										@php($get_feature_add = \App\Master_feature::where('menus_id',$id_sub_menus)->where('name_features','add')->count())
										@php($checked_feature_add = '')
										@if($get_feature_add != 0)
											@php($checked_feature_add = 'checked')
										@endif

										@php($get_feature_read = \App\Master_feature::where('menus_id',$id_sub_menus)->where('name_features','read')->count())
										@php($checked_feature_read = '')
										@if($get_feature_read != 0)
											@php($checked_feature_read = 'checked')
										@endif

										@php($get_feature_edit = \App\Master_feature::where('menus_id',$id_sub_menus)->where('name_features','edit')->count())
										@php($checked_feature_edit = '')
										@if($get_feature_edit != 0)
											@php($checked_feature_edit = 'checked')
										@endif

										@php($get_feature_delete = \App\Master_feature::where('menus_id',$id_sub_menus)->where('name_features','delete')->count())
										@php($checked_feature_delete = '')
										@if($get_feature_delete != 0)
											@php($checked_feature_delete = 'checked')
										@endif

										@php($get_feature_print = \App\Master_feature::where('menus_id',$id_sub_menus)->where('name_features','print')->count())
										@php($checked_feature_print = '')
										@if($get_feature_print != 0)
											@php($checked_feature_print = 'checked')
										@endif

										<td align="center">
											<input type="checkbox" name="name_features[]" value="view" class="chk-col-black" id="md_checkbox_features_view_sub_menu" {{ $checked_feature_view }} disabled>
											<label for="md_checkbox_features_view_sub_menu"></label>
										</td>
										<td align="center">
											<input type="checkbox" name="name_features[]" value="add" class="chk-col-cyan" id="md_checkbox_features_add_sub_menu" {{ $checked_feature_add }} disabled>
											<label for="md_checkbox_features_add_sub_menu"></label>
										</td>
										<td align="center">
											<input type="checkbox" name="name_features[]" value="read" class="chk-col-amber" id="md_checkbox_features_read_sub_menu" {{ $checked_feature_read }} disabled>
											<label for="md_checkbox_features_read_sub_menu"></label>
										</td>
										<td align="center">
											<input type="checkbox" name="name_features[]" value="edit" class="chk-col-purple" id="md_checkbox_features_edit_sub_menu" {{ $checked_feature_edit }} disabled>
											<label for="md_checkbox_features_edit_sub_menu"></label>
										</td>
										<td align="center">
											<input type="checkbox" name="name_features[]" value="delete" class="chk-col-red" id="md_checkbox_features_delete_sub_menu" {{ $checked_feature_delete }} disabled>
											<label for="md_checkbox_features_delete_sub_menu"></label>
										</td>
										<td align="center">
											<input type="checkbox" name="name_features[]" value="print" class="chk-col-green" id="md_checkbox_features_print_sub_menu" {{ $checked_feature_print }} disabled>
											<label for="md_checkbox_features_print_sub_menu"></label>
										</td>
									</tr>
								</table>
							</div>
						</div>
	                    <br/>
	                    <div class="form-group" align="center">
		            		@if(request()->session()->get('page2') != '')
		            			@php($get_back = request()->session()->get('page2'))
	                    	@else
	                    		@php($get_back = 'dashboard/menu/submenu/'.$read_menus->id_menus)
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop
