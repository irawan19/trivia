
<?php $__env->startSection('content'); ?>

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Level System</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/level_system')); ?>">Level System</a></li>
	            <li class="breadcrumb-item active">Edit</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
			            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/level_system/processedit/'.$edit_level_systems->id_level_systems)); ?>" method="POST">
							<?php echo e(csrf_field()); ?>

	                        <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('name_level_systems'))); ?>">
	                            <label class="form-control-label">Name <b style="color:red">*</b></label>
	                            <input id="name_level_systems" type="text" name="name_level_systems" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('name_level_systems'))); ?>" value="<?php echo e(Request::old('name_level_systems') == '' ? $edit_level_systems->name_level_systems : Request::old('name_level_systems')); ?>" placeholder="Name" required autofocus>
	                            <?php echo e(Shwetech::formError($errors->first('name_level_systems'))); ?>

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
													<input id="md_checkbox_features_all_view" type="checkbox" class="chk-col-black" name="checkbox_all_view" value="" <?php echo e(Request::old('checkbox_all_view') != '' ? $checked='checked' : $checked=''); ?>>
													<label for="md_checkbox_features_all_view"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_read" type="checkbox" class="chk-col-amber" name="checkbox_all_read" value="" <?php echo e(Request::old('checkbox_all_read') != '' ? $checked='checked' : $checked=''); ?>>
													<label for="md_checkbox_features_all_read"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_add" type="checkbox" class="chk-col-cyan" name="checkbox_all_add" value="" <?php echo e(Request::old('checkbox_all_add') != '' ? $checked='checked' : $checked=''); ?>>
													<label for="md_checkbox_features_all_add"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_edit" type="checkbox" class="chk-col-purple" name="checkbox_all_edit" value="" <?php echo e(Request::old('checkbox_all_edit') != '' ? $checked='checked' : $checked=''); ?>>
													<label for="md_checkbox_features_all_edit"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_delete" type="checkbox" class="chk-col-red" name="checkbox_all_delete" value="" <?php echo e(Request::old('checkbox_all_delete') != '' ? $checked='checked' : $checked=''); ?>>
													<label for="md_checkbox_features_all_delete"></label>
												</th>
												<th class="th_align th_center">
													<input id="md_checkbox_features_all_print" type="checkbox" class="chk-col-green" name="checkbox_all_print" value="" <?php echo e(Request::old('checkbox_all_print') != '' ? $checked='checked' : $checked=''); ?>>
													<label for="md_checkbox_features_all_print"></label>
												</th>
											</tr>
										</thead>
										<?php ($id_level_systems = $edit_level_systems->id_level_systems); ?>
										<?php ($no_checkbox = 1); ?>
										<?php $__currentLoopData = $edit_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tbody>
											<tr>
												<td align="left" colspan="7"><b style="color:#3300ff;text-transform: uppercase;"><?php echo e($menus->name_menus); ?></b></td>
											</tr>
											<?php ($id_menus = $menus->id_menus); ?>
											<?php ($get_sub_menus = \App\Master_menu::where('sub_menus_id',$id_menus)
																					->orderBy('order_menus')
																					->get()); ?>
											<?php $__currentLoopData = $get_sub_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_menus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php ($id_sub_menus = $sub_menus->id_menus); ?>
												<?php ($add_features = \App\Master_feature::where('menus_id',$id_sub_menus)->get()); ?>
												<tr>
													<td><b style="color:#cc0000">&nbsp;&nbsp;&nbsp;&nbsp;<i class="mdi <?php echo e($sub_menus->icon_menus); ?>"></i>&nbsp;&nbsp; <?php echo e($sub_menus->name_menus); ?></b></td>
													<td align="center">
														<?php $__currentLoopData = $add_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $features_view): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php ($check_features = $features_view->name_features); ?>
															<?php if($check_features == 'view'): ?>
																<?php ($id_features = $features_view->id_features); ?>
																<?php ($read_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first()); ?>
																<?php ($check_features = 0); ?>
																<?php if($read_access != null): ?>
																	<?php ($check_features = $read_access->features_id); ?>
																<?php endif; ?>

																<?php ($checked = ''); ?>
																<?php if($id_features == $check_features): ?>
																	<?php ($checked = 'checked'); ?>
																<?php endif; ?>

																<input type="checkbox" id="md_checkbox_<?php echo e($no_checkbox); ?>_features_view" class="chk-col-black sub" name="features_id[]" value="<?php echo e($features_view->id_features); ?>" <?php echo e($checked); ?> />
	                                							<label for="md_checkbox_<?php echo e($no_checkbox); ?>_features_view"></label>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</td>
													<td align="center">
														<?php $__currentLoopData = $add_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $features_read): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php ($check_features = $features_read->name_features); ?>
															<?php if($check_features == 'read'): ?>
																<?php ($id_features = $features_read->id_features); ?>
																<?php ($read_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first()); ?>
																<?php ($check_features = 0); ?>
																<?php if($read_access != null): ?>
																	<?php ($check_features = $read_access->features_id); ?>
																<?php endif; ?>

																<?php ($checked = ''); ?>
																<?php if($id_features == $check_features): ?>
																	<?php ($checked = 'checked'); ?>
																<?php endif; ?>

																<input type="checkbox" id="md_checkbox_<?php echo e($no_checkbox); ?>_features_read" class="chk-col-amber sub" name="features_id[]" value="<?php echo e($features_read->id_features); ?>" <?php echo e($checked); ?> />
	                                							<label for="md_checkbox_<?php echo e($no_checkbox); ?>_features_read"></label>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</td>
													<td align="center">
														<?php $__currentLoopData = $add_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $features_add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php ($check_features = $features_add->name_features); ?>
															<?php if($check_features == 'add'): ?>
																<?php ($id_features = $features_add->id_features); ?>
																<?php ($add_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first()); ?>
																<?php ($check_features = 0); ?>
																<?php if($add_access != null): ?>
																	<?php ($check_features = $add_access->features_id); ?>
																<?php endif; ?>

																<?php ($checked = ''); ?>
																<?php if($id_features == $check_features): ?>
																	<?php ($checked = 'checked'); ?>
																<?php endif; ?>

																<input type="checkbox" id="md_checkbox_<?php echo e($no_checkbox); ?>_features_add" class="chk-col-cyan sub" name="features_id[]" value="<?php echo e($features_add->id_features); ?>" <?php echo e($checked); ?> />
	                                							<label for="md_checkbox_<?php echo e($no_checkbox); ?>_features_add"></label>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</td>
													<td align="center">
														<?php $__currentLoopData = $add_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $features_edit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php ($check_features = $features_edit->name_features); ?>
															<?php if($check_features == 'edit'): ?>
																<?php ($id_features = $features_edit->id_features); ?>
																<?php ($edit_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first()); ?>
																<?php ($check_features = 0); ?>
																<?php if($edit_access != null): ?>
																	<?php ($check_features = $edit_access->features_id); ?>
																<?php endif; ?>

																<?php ($checked = ''); ?>
																<?php ($disabled = ''); ?>
																<?php ($class_admin = 'sub'); ?>
																<?php if($id_features == $check_features): ?>
																	<?php ($class_admin = 'sub'); ?>
																	<?php ($disabled = ''); ?>
																	<?php ($checked = 'checked'); ?>
																<?php endif; ?>

																<?php if($sub_menus->link_menus == 'admin'): ?>
																	<?php ($class_admin = ''); ?>
																	<?php ($disabled 	= 'disabled'); ?>
																	<?php ($checked 	= 'checked'); ?>
																<?php endif; ?>

																<?php if($sub_menus->link_menus == 'admin'): ?>
																	<input type="hidden" name="features_id[]" id="features_edit_user" class="features_edit" value="<?php echo e($features_edit->id_features); ?>">
																<?php endif; ?>
																
																<input type="checkbox" id="md_checkbox_<?php echo e($no_checkbox); ?>_features_edit" class="chk-col-purple <?php echo e($class_admin); ?>" name="features_id[]" value="<?php echo e($features_edit->id_features); ?>"  <?php echo e($checked); ?> <?php echo e($disabled); ?> />
	                                							<label for="md_checkbox_<?php echo e($no_checkbox); ?>_features_edit"></label>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</td>
													<td align="center">
														<?php $__currentLoopData = $add_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $features_delete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php ($check_features = $features_delete->name_features); ?>
															<?php if($check_features == 'delete'): ?>
																<?php ($id_features = $features_delete->id_features); ?>
																<?php ($delete_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first()); ?>
																<?php ($check_features = 0); ?>
																<?php if($delete_access != null): ?>
																	<?php ($check_features = $delete_access->features_id); ?>
																<?php endif; ?>

																<?php ($checked = ''); ?>
																<?php if($id_features == $check_features): ?>
																	<?php ($checked = 'checked'); ?>
																<?php endif; ?>

																<input type="checkbox" id="md_checkbox_<?php echo e($no_checkbox); ?>_features_delete" class="chk-col-red sub" name="features_id[]" value="<?php echo e($features_delete->id_features); ?>" <?php echo e($checked); ?> />
	                                							<label for="md_checkbox_<?php echo e($no_checkbox); ?>_features_delete"></label>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</td>
													<td align="center">
														<?php $__currentLoopData = $add_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $features_print): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php ($check_features = $features_print->name_features); ?>
															<?php if($check_features == 'print'): ?>
																<?php ($id_features = $features_print->id_features); ?>
																<?php ($print_access = \App\Master_access::where('level_systems_id',$id_level_systems)->where('features_id',$id_features)->first()); ?>
																<?php ($check_features = 0); ?>
																<?php if($print_access != null): ?>
																	<?php ($check_features = $print_access->features_id); ?>
																<?php endif; ?>

																<?php ($checked = ''); ?>
																<?php if($id_features == $check_features): ?>
																	<?php ($checked = 'checked'); ?>
																<?php endif; ?>

																<input type="checkbox" id="md_checkbox_<?php echo e($no_checkbox); ?>_features_print" class="chk-col-green sub" name="features_id[]" value="<?php echo e($features_print->id_features); ?>" <?php echo e($checked); ?> />
	                                							<label for="md_checkbox_<?php echo e($no_checkbox); ?>_features_print"></label>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</td>
												</tr>
												<?php ($no_checkbox++); ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
									</table>
								</div>
							</div>
	                        <br/>
	                        <div class="form-group" align="center">
		            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
		            			<?php if(request()->session()->get('page') != ''): ?>
		            				<?php ($get_back = request()->session()->get('page')); ?>
	                        	<?php else: ?>
	                        		<?php ($get_back = 'dashboard/level_system'); ?>
	                        	<?php endif; ?>

	                        	<a href="<?php echo e($get_back); ?>" class="btn waves-effect waves-light btn-danger"> Cancel</a>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>