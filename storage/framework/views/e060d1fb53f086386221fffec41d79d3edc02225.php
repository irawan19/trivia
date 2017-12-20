
<?php $__env->startSection('content'); ?>

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Manage Host</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
	            <li class="breadcrumb-item active">Manage Host</li>
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
								<form method="GET" action="<?php echo e(URL('dashboard/host/search')); ?>" class="form-horizontal m-t-40">
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
			                                    	<option value="<?php echo e($agent->id); ?>" <?php echo e($selected); ?> ><?php echo e($agent->name); ?></option>
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
						<div align="center"><?php echo e(Shwetech::add($link_host,'dashboard/host/add')); ?></div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Name</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Phone Number</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Total Group</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="5">Credit</th>
	                                <?php if(Auth::user()->level_systems_id == 1): ?>
	                                	<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="6">Agent</th>
	                                <?php endif; ?>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php ($no = 1); ?>
	                        	<?php $__currentLoopData = $view_hosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hosts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            <tr>
		                                <td><?php echo e($no); ?></td>
		                                <td><?php echo e($hosts->name); ?></td>
		                                <td><?php echo e($hosts->phone_number_users); ?></td>
		                                <td><?php echo e($hosts->max_group_users); ?></td>
		                                <td><?php echo e($hosts->credit_users); ?></td>
		                                <?php if(Auth::user()->level_systems_id == 1): ?>
	                                		<?php ($sub_users_id = $hosts->sub_users_id); ?>
	                                		<?php ($get_sub_users = \App\Master_user::where('id',$sub_users_id)->first()); ?>
		                                	<td><?php echo e($get_sub_users->name); ?></td>
		                                <?php endif; ?>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														<?php echo e(Shwetech::read($link_host,'dashboard/host/read/'.$hosts->id)); ?>

														<?php echo e(Shwetech::edit($link_host,'dashboard/host/edit/'.$hosts->id)); ?>

														<?php ($check_group_host = \App\Master_group::where('users_id',$hosts->id)->count()); ?>
														<?php if($check_group_host == 0): ?>
															<?php echo e(Shwetech::delete($link_host,'dashboard/host/delete/'.$hosts->id,$hosts->name_level_systems.' - '.$hosts->name)); ?>

														<?php endif; ?>
													</div>
												</div>
											</div>
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