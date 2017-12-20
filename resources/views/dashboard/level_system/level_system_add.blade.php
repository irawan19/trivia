@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Level System</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard/level_system') }}">Level System</a></li>
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

			            <form class="form-horizontal m-t-40" action="{{ URL('dashboard/level_system/processadd') }}" method="POST">
							{{ csrf_field() }}
	                        <div class="form-group {{ Shwetech::errorStyleGroup($errors->first('name_level_systems')) }}">
	                            <label class="form-control-label">Name <b style="color:red">*</b></label>
	                            <input id="name_level_systems" type="text" name="name_level_systems" class="form-control {{ Shwetech::errorStyleFormControl($errors->first('name_level_systems')) }}" value="{{ Request::old('name_level_systems') }}" placeholder="Name" required autofocus>
	                            {{ Shwetech::formError($errors->first('name_level_systems')) }}
	                        </div>
	                        <div class="form-group row">
								<label class="col-md-3 form-control-label" for="hf-name">Feature</label>
								<br/>
						    	<div class="col-sm-12">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th class="th_align th_center" width="40%" rowspan="3" scope="col">Menu</th>
												<th class="th_align th_center" colspan="6" scope="col">Access Rights</th>
											</tr>
											<tr>
												<th class="th_align th_center" width="10%">View</th>
												<th class="th_align th_center" width="10%">Read</th>
												<th class="th_align th_center" width="10%">Add</th>
												<th class="th_align th_center" width="10%">Edit</th>
												<th class="th_align th_center" width="10%">Delete</th>
												<th class="th_align th_center" width="10%">Print</th>
											</tr>
											<tr>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_view" type="checkbox" class="chk-col-black" name="checkbox_all_view" value="" {{ Request::old('checkbox_all_view') != '' ? $checked='checked' : $checked='' }}>
													<label for="md_checkbox_features_all_view"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_read" type="checkbox" class="chk-col-amber" name="checkbox_all_read" value="" {{ Request::old('checkbox_all_read') != '' ? $checked='checked' : $checked='' }}>
													<label for="md_checkbox_features_all_read"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_add" type="checkbox" class="chk-col-cyan" name="checkbox_all_add" value="" {{ Request::old('checkbox_all_add') != '' ? $checked='checked' : $checked='' }}>
													<label for="md_checkbox_features_all_add"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_edit" type="checkbox" class="chk-col-purple" name="checkbox_all_edit" value="" {{ Request::old('checkbox_all_edit') != '' ? $checked='checked' : $checked='' }}>
													<label for="md_checkbox_features_all_edit"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_delete" type="checkbox" class="chk-col-red" name="checkbox_all_delete" value="" {{ Request::old('checkbox_all_delete') != '' ? $checked='checked' : $checked='' }}>
													<label for="md_checkbox_features_all_delete"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_print" type="checkbox" class="chk-col-green" name="checkbox_all_print" value="" {{ Request::old('checkbox_all_print') != '' ? $checked='checked' : $checked='' }}>
													<label for="md_checkbox_features_all_print"></label>
												</th>
											</tr>
										</thead>
										@php($no_checkbox = 1)
										@foreach($add_menus as $menus)
										<tbody>
											<tr>
												<td align="left" colspan="7"><b style="color:#3300ff;text-transform: uppercase;">{{ $menus->name_menus }}</b></td>
											</tr>
											@php($id_menus = $menus->id_menus)
											@php($get_sub_menus = \App\Master_menu::where('sub_menus_id',$id_menus)
																					->orderBy('order_menus')
																					->get())
											@foreach($get_sub_menus as $sub_menus)
												@php($id_sub_menus = $sub_menus->id_menus)
												@php($add_features = \App\Master_feature::where('menus_id',$id_sub_menus)->get())
												<tr>
													<td><b style="color:#cc0000">&nbsp;&nbsp;&nbsp;&nbsp;<i class="mdi {{ $sub_menus->icon_menus }}"></i>&nbsp;&nbsp; {{ $sub_menus->name_menus }}</b></td>
													<td align="center">
														@foreach($add_features as $features_view)
															@php($check_features = $features_view->name_features)
															@if($check_features == 'view')
																<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_view" class="chk-col-black sub" name="features_id[]" value="{{ $features_view->id_features }}" />
	                                							<label for="md_checkbox_{{ $no_checkbox }}_features_view"></label>
															@endif
														@endforeach
													</td>
													<td align="center">
														@foreach($add_features as $features_read)
															@php($check_features = $features_read->name_features)
															@if($check_features == 'read')
																<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_read" class="chk-col-amber sub" name="features_id[]" value="{{ $features_read->id_features }}" />
	                                							<label for="md_checkbox_{{ $no_checkbox }}_features_read"></label>
															@endif
														@endforeach
													</td>
													<td align="center">
														@foreach($add_features as $features_add)
															@php($check_features = $features_add->name_features)
															@if($check_features == 'add')
																<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_add" class="chk-col-cyan sub" name="features_id[]" value="{{ $features_add->id_features }}" />
	                                							<label for="md_checkbox_{{ $no_checkbox }}_features_add"></label>
															@endif
														@endforeach
													</td>
													<td align="center">
														@foreach($add_features as $features_edit)
															@php($check_features = $features_edit->name_features)
															@if($check_features == 'edit')
																@php($checked = '')
																@php($disabled = '')
																@php($class_admin = 'sub')
																@if($sub_menus->link_menus == 'admin')
																	@php($checked = 'checked')
																	@php($disabled = 'disabled')
																	@php($class_admin = '')
																@endif

																@if($sub_menus->link_menus == 'admin')
																	<input type="hidden" name="features_id[]" id="features_edit_user" class="features_edit" value="{{ $features_edit->id_features }}">
																@endif
																
																<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_edit" class="chk-col-purple {{$class_admin}}" name="features_id[]" value="{{ $features_edit->id_features }}"  {{ $checked }} {{ $disabled }} />
	                                							<label for="md_checkbox_{{ $no_checkbox }}_features_edit"></label>
															@endif
														@endforeach
													</td>
													<td align="center">
														@foreach($add_features as $features_delete)
															@php($check_features = $features_delete->name_features)
															@if($check_features == 'delete')
																<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_delete" class="chk-col-red sub" name="features_id[]" value="{{ $features_delete->id_features }}" />
	                                							<label for="md_checkbox_{{ $no_checkbox }}_features_delete"></label>
															@endif
														@endforeach
													</td>
													<td align="center">
														@foreach($add_features as $features_print)
															@php($check_features = $features_print->name_features)
															@if($check_features == 'print')
																<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_print" class="chk-col-green sub" name="features_id[]" value="{{ $features_print->id_features }}" />
	                                							<label for="md_checkbox_{{ $no_checkbox }}_features_print"></label>
															@endif
														@endforeach
													</td>
												</tr>
											@php($no_checkbox++)
											@endforeach
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
	                        <br/>
	                        <div class="form-group" align="center">
		            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
		            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
		            			@if(request()->session()->get('page') != '')
		            				@php($get_back = request()->session()->get('page'))
	                        	@else
	                        		@php($get_back = 'dashboard/level_system')
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