
<?php $__env->startSection('content'); ?>

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Level System</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
	            <li class="breadcrumb-item active">Level System</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
		                <h6 class="card-subtitle" style="text-align:center">set each account to access some menus.</h6>
	                    <div class="row">
	                       	<div class="col-lg-12">
								<form method="GET" action="<?php echo e(URL('dashboard/level_system/search')); ?>" class="form-horizontal m-t-40">
								<?php echo e(csrf_field()); ?>

									<div class="input-group">
										<input name="search_word" placeholder="search" value="<?php echo e($result_word); ?>" class="form-control" type="text">
										<span class="input-group-btn">
											<button class="btn btn-info" name="submit_search" value="submit_search" type="submit">Search</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<br/>
						<div align="center"><?php echo e(Shwetech::add($link_level_system,'dashboard/level_system/add')); ?></div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php ($no = 1); ?>
	                        	<?php $__currentLoopData = $view_level_systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level_systems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            <tr>
		                                <td><?php echo e($no); ?></td>
		                                <td><?php echo e($level_systems->name_level_systems); ?></td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														<?php echo e(Shwetech::read($link_level_system,'dashboard/level_system/read/'.$level_systems->id_level_systems)); ?>

														<?php echo e(Shwetech::edit($link_level_system,'dashboard/level_system/edit/'.$level_systems->id_level_systems)); ?>

														<?php if($level_systems->id_level_systems != 1 && $level_systems->id_level_systems != 2 && $level_systems->id_level_systems != 3): ?>
															<?php echo e(Shwetech::delete($link_level_system,'dashboard/level_system/delete/'.$level_systems->id_level_systems,$level_systems->name_level_systems)); ?>

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