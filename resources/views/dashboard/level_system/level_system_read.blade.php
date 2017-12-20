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
	            <li class="breadcrumb-item active">Read</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    <div class="form-group">
	                        <label class="form-control-label">Name</label>
	                        <input id="name_level_systems" type="text" name="name_level_systems" class="form-control" value="{{ $read_level_systems->name_level_systems }}" placeholder="Name" disabled>
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
												<input id="md_checkbox_features_all_view" type="checkbox" class="chk-col-black" name="checkbox_all_view" value="" disabled>
												<label for="md_checkbox_features_all_view"></label>
											</th>
											<th class="th_align th_center">
												<input id="md_checkbox_features_all_read" type="checkbox" class="chk-col-amber" name="checkbox_all_read" value="" disabled>
												<label for="md_checkbox_features_all_read"></label>
											</th>
											<th class="th_align th_center">
												<input id="md_checkbox_features_all_add" type="checkbox" class="chk-col-cyan" name="checkbox_all_add" value="" disabled>
												<label for="md_checkbox_features_all_add"></label>
											</th>
											<th class="th_align th_center">
												<input id="md_checkbox_features_all_edit" type="checkbox" class="chk-col-purple" name="checkbox_all_edit" value="" disabled>
												<label for="md_checkbox_features_all_edit"></label>
											</th>
											<th class="th_align th_center">
												<input id="md_checkbox_features_all_delete" type="checkbox" class="chk-col-red" name="checkbox_all_delete" value="" disabled>
												<label for="md_checkbox_features_all_delete"></label>
											</th>
											<th class="th_align th_center">
												<input id="md_checkbox_features_all_print" type="checkbox" class="chk-col-green" name="checkbox_all_print" value="" disabled>
												<label for="md_checkbox_features_all_print"></label>
											</th>
										</tr>
									</thead>
									@php($id_level_systems = $read_level_systems->id_level_systems)
									@foreach($read_menus as $menus)
									<tbody>
										<tr>
											<td align="left" colspan="7"><b style="color:#3300ff;text-transform: uppercase;">{{ $menus->name_menus }}</b></td>
										</tr>
										@php($id_menus = $menus->id_menus)
										@php($get_sub_menus = \App\Master_menu::where('sub_menus_id',$id_menus)
																				->orderBy('order_menus')
																				->get())
										@php($no_checkbox = 1)
										@foreach($get_sub_menus as $sub_menus)
											@php($id_sub_menus = $sub_menus->id_menus)
											@php($read_features = \App\Master_feature::where('menus_id',$id_sub_menus)->get())
											<tr>
												<td><b style="color:#cc0000">&nbsp;&nbsp;&nbsp;&nbsp;<i class="mdi {{ $sub_menus->icon_menus }}"></i>&nbsp;&nbsp; {{ $sub_menus->name_menus }}</b></td>
												<td align="center">
													@foreach($read_features as $features_view)
														@php($check_features = $features_view->name_features)
														@if($check_features == 'view')
															@php($id_features = $features_view->id_features)
															@php($read_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first())
															@php($check_features = 0)
															@if($read_access != null)
																@php($check_features = $read_access->features_id)
															@endif

															@php($checked = '')
															@if($id_features == $check_features)
																@php($checked = 'checked')
															@endif

															<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_view" class="chk-col-black sub" name="features_id[]" value="" {{ $checked }} disabled />
	                            							<label for="md_checkbox_{{ $no_checkbox }}_features_view"></label>
														@endif
													@endforeach
												</td>
												<td align="center">
													@foreach($read_features as $features_read)
														@php($check_features = $features_read->name_features)
														@if($check_features == 'read')
															@php($id_features = $features_read->id_features)
															@php($read_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first())
															@php($check_features = 0)
															@if($read_access != null)
																@php($check_features = $read_access->features_id)
															@endif

															@php($checked = '')
															@if($id_features == $check_features)
																@php($checked = 'checked')
															@endif

															<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_read" class="chk-col-amber sub" name="features_id[]" value="" {{ $checked }} disabled />
	                            							<label for="md_checkbox_{{ $no_checkbox }}_features_read"></label>
														@endif
													@endforeach
												</td>
												<td align="center">
													@foreach($read_features as $features_add)
														@php($check_features = $features_add->name_features)
														@if($check_features == 'add')
															@php($id_features = $features_add->id_features)
															@php($add_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first())
															@php($check_features = 0)
															@if($add_access != null)
																@php($check_features = $add_access->features_id)
															@endif

															@php($checked = '')
															@if($id_features == $check_features)
																@php($checked = 'checked')
															@endif

															<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_add" class="chk-col-cyan sub" name="features_id[]" value="" {{ $checked }} disabled />
	                            							<label for="md_checkbox_{{ $no_checkbox }}_features_add"></label>
														@endif
													@endforeach
												</td>
												<td align="center">
													@foreach($read_features as $features_edit)
														@php($check_features = $features_edit->name_features)
														@if($check_features == 'edit')
															@php($id_features = $features_edit->id_features)
															@php($edit_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first())
															@php($check_features = 0)
															@if($edit_access != null)
																@php($check_features = $edit_access->features_id)
															@endif

															@php($checked = '')
															@if($id_features == $check_features)
																@php($checked = 'checked')
															@endif
															
															<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_edit" class="chk-col-purple sub" name="features_id[]" value=""  {{ $checked }} disabled />
	                            							<label for="md_checkbox_{{ $no_checkbox }}_features_edit"></label>
														@endif
													@endforeach
												</td>
												<td align="center">
													@foreach($read_features as $features_delete)
														@php($check_features = $features_delete->name_features)
														@if($check_features == 'delete')
															@php($id_features = $features_delete->id_features)
															@php($delete_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first())
															@php($check_features = 0)
															@if($delete_access != null)
																@php($check_features = $delete_access->features_id)
															@endif

															@php($checked = '')
															@if($id_features == $check_features)
																@php($checked = 'checked')
															@endif

															<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_delete" class="chk-col-red sub" name="features_id[]" value="" {{ $checked }} disabled />
	                            							<label for="md_checkbox_{{ $no_checkbox }}_features_delete"></label>
														@endif
													@endforeach
												</td>
												<td align="center">
													@foreach($read_features as $features_print)
														@php($check_features = $features_print->name_features)
														@if($check_features == 'print')
															@php($id_features = $features_print->id_features)
															@php($print_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first())
															@php($check_features = 0)
															@if($print_access != null)
																@php($check_features = $print_access->features_id)
															@endif

															@php($checked = '')
															@if($id_features == $check_features)
																@php($checked = 'checked')
															@endif

															<input type="checkbox" id="md_checkbox_{{ $no_checkbox }}_features_print" class="chk-col-green sub" name="features_id[]" value="" {{ $checked }} disabled />
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
		            		@if(request()->session()->get('page') != '')
		            			@php($get_back = request()->session()->get('page'))
	                    	@else
	                    		@php($get_back = 'dashboard/level_system')
	                    	@endif

	                    	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop