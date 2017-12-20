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
	            <li class="breadcrumb-item">{{ $view_menus->name_menus }}</li>
	            <li class="breadcrumb-item active">Edit</li>
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

			            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/menu/processedit_submenu/'.$edit_sub_menus->id_menus) }}" method="POST">
							{{ csrf_field() }}
	                        <div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Icons <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="icon_menus" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    @foreach($view_icons as $icons)
	                                    	@php($selected = '')
		                                    @if(Request::old('icons') == '')
		                                    	@if($icons == $edit_sub_menus->icon_menus)
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
	                            <input id="name_menus" type="text" name="name_menus" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name_menus')) }}" value="{{ Request::old('name_menus') == '' ? $edit_sub_menus->name_menus : Request::old('name_menus') }}" placeholder="Name" required autofocus>
	                            {{ Shwetech::formError($errors->first('name_menus')) }}
	                        </div>
	                        <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('link_menus')) }}">
	                            <label class="form-control-label">Link <b style="color:red">*</b></label>
	                            <input id="link_menus" type="text" name="link_menus" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('link_menus')) }}" value="{{ Request::old('link_menus') == '' ? $edit_sub_menus->link_menus : Request::old('link_menus') }}" placeholder="Name" required autofocus>
	                            {{ Shwetech::formError($errors->first('link_menus')) }}
	                        </div>
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
											@php($id_sub_menus = $edit_sub_menus->id_menus)
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
												<input type="checkbox" name="name_features[]" value="view" class="chk-col-black" id="md_checkbox_features_view_sub_menu" {{ $checked_feature_view }}>
												<label for="md_checkbox_features_view_sub_menu"></label>
											</td>
											<td align="center">
												<input type="checkbox" name="name_features[]" value="add" class="chk-col-cyan" id="md_checkbox_features_add_sub_menu" {{ $checked_feature_add }}>
												<label for="md_checkbox_features_add_sub_menu"></label>
											</td>
											<td align="center">
												<input type="checkbox" name="name_features[]" value="read" class="chk-col-amber" id="md_checkbox_features_read_sub_menu" {{ $checked_feature_read }}>
												<label for="md_checkbox_features_read_sub_menu"></label>
											</td>
											<td align="center">
												<input type="checkbox" name="name_features[]" value="edit" class="chk-col-purple" id="md_checkbox_features_edit_sub_menu" {{ $checked_feature_edit }}>
												<label for="md_checkbox_features_edit_sub_menu"></label>
											</td>
											<td align="center">
												<input type="checkbox" name="name_features[]" value="delete" class="chk-col-red" id="md_checkbox_features_delete_sub_menu" {{ $checked_feature_delete }}>
												<label for="md_checkbox_features_delete_sub_menu"></label>
											</td>
											<td align="center">
												<input type="checkbox" name="name_features[]" value="print" class="chk-col-green" id="md_checkbox_features_print_sub_menu" {{ $checked_feature_print }}>
												<label for="md_checkbox_features_print_sub_menu"></label>
											</td>
										</tr>
									</table>
									{{ Shwetech::formError($errors->first('name_features.0')) }}
								</div>
							</div>
	                        <br/>
	                        <div class="form-group" align="center">
		            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
		            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
		            			@if(request()->session()->get('page2') != '')
		            				@php($get_back = request()->session()->get('page2'))
	                        	@else
	                        		@php($get_back = 'dashboard/menu/submenu/'.$view_menus->id_menus)
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