
<?php $__env->startSection('content'); ?>

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Group</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
	            <li class="breadcrumb-item active">Manage Group</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    <div class="row">
	                       	<div class="col-lg-12">
								<form method="GET" action="<?php echo e(URL('dashboard/group/search')); ?>" class="form-horizontal m-t-40">
									<?php echo e(csrf_field()); ?>

									<div class="input-group">
										<?php if(Auth::user()->level_systems_id == 1): ?>
											<select name="search_agent" class="custom-select" id="inlineFormCustomSelect" required autofocus>
			                                    <?php ($selected_none = ''); ?>
		                                        <?php if($result_agent == 0): ?>
		                                             <?php ($selected_none = 'selected'); ?>
		                                        <?php endif; ?>
			                                    <option value="0" <?php echo e($selected_none); ?>>All</option>
			                                    <?php $__currentLoopData = $view_agent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                                    	<?php ($selected = ''); ?>
			                                    	<?php if($agent->id == $result_agent): ?>
			                                    		<?php ($selected = 'selected'); ?>
			                                    	<?php endif; ?>
			                                    	<?php if(Auth::user()->level_systems_id == 1): ?>
			                                    		<?php ($get_master_agent = \App\Master_user::where('id',$agent->sub_users_id)->first()); ?>
			                                    		<option value="<?php echo e($agent->id); ?>" <?php echo e($selected); ?> ><?php echo e($get_master_agent->name); ?> - <?php echo e($agent->name); ?></option>
			                                    	<?php elseif(Auth::user()->level_systems_id == 2): ?>
			                                    		<option value="<?php echo e($agent->id); ?>" <?php echo e($selected); ?> ><?php echo e($agent->name); ?></option>
			                                    	<?php endif; ?>
			                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                                </select>
										<?php endif; ?>
										<input name="search_word" placeholder="search" value="<?php echo e($result_word); ?>" class="form-control" type="text">
										<span class="input-group-btn">
											<button class="btn btn-info" name="submit_search" value="submit_search" type="submit">Search</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<br/>
						<?php if(Auth::user()->level_systems_id != '3'): ?>
							<div align="center"><?php echo e(Shwetech::add($link_group,'dashboard/group/add')); ?></div>
						<?php else: ?>
							<?php ($get_users = \App\Master_user::where('id',Auth::user()->id)->first()); ?>
							<?php ($check_total_group = \App\Master_group::where('users_id',Auth::user()->id)->count()); ?>
							<?php if($check_total_group < $get_users->max_group_users): ?>
								<div align="center"><?php echo e(Shwetech::add($link_group,'dashboard/group/add')); ?></div>
							<?php endif; ?>
						<?php endif; ?>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Date</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Credit</th>
	                                <?php if(Auth::user()->level_systems_id != 3): ?>
	                                	<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Agent</th>
	                                <?php endif; ?>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php ($no = 1); ?>
	                        	<?php $__currentLoopData = $view_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            <tr>
		                                <td><?php echo e($no); ?></td>
		                                <td><?php echo e(Shwetech::changeDBToDatetime($groups->created_on_groups)); ?></td>
		                                <td><?php echo e($groups->name_groups); ?></td>
		                                <td><?php echo e($groups->credit_groups); ?></td>
		                                <?php if(Auth::user()->level_systems_id != 3): ?>
		                                	<?php ($get_agent 	= \App\Master_user::where('id',$groups->users_id)->first()); ?>
		                                	<?php ($get_master_agent = \App\Master_user::where('id',$get_agent->sub_users_id)->first()); ?>
		                                	<td><?php echo e($get_master_agent->name.' - '.$get_agent->name); ?></td>
		                                <?php endif; ?>
		                                <td width="5%">
		                                	<?php ($check_sessions = \App\Master_session::where('groups_id',$groups->id_groups)->count()); ?>
											<?php if($check_sessions == 0): ?>
			                                	<div class="input-group">
													<div class="input-group-btn">
														<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
															<span class="caret"></span>
														</button>
														<div class="dropdown-menu dropdown-menu-right action">
															<?php echo e(Shwetech::edit($link_group,'dashboard/group/edit/'.$groups->id_groups)); ?>

															<?php echo e(Shwetech::delete($link_group,'dashboard/group/delete/'.$groups->id_groups,$groups->name_groups)); ?>

														</div>
													</div>
												</div>
											<?php endif; ?>
		                                </td>
		                            </tr>
		                            <?php ($no++); ?>
		                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>