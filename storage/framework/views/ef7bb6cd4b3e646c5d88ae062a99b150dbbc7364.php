<?php $__env->startSection('content'); ?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">List Stakes</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">List Stakes</li>
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
							<form method="GET" action="<?php echo e(URL('dashboard/list_stakes/search')); ?>" class="input-form">
							<?php echo e(csrf_field()); ?>

								<div class="input-group">
									<input name="search_word" placeholder="search" value="<?php echo e($result_word); ?>" class="form-control" type="text">
									<span class="input-group-btn">
										<button class="btn btn-info" name="submit_search" value="submit_search" type="button">Search</button>
									</span>
								</div>
							</form>
						</div>
					</div>
					<br/>
					<div align="center"><?php echo e(Shwetech::add($link_list_stakes,'dashboard/list_stakes/add')); ?></div>
					<br/>
                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Image</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php ($no = 1); ?>
                        	<?php $__currentLoopData = $view_list_stakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_stakes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                            <tr>
	                                <td width="5%"><?php echo e($no); ?></td>
	                                <td width="5%">
                                        <a href="<?php echo e(URL::to($list_stakes->path_image_list_stakes)); ?>/<?php echo e($list_stakes->name_image_list_stakes); ?>" class="image-popup-no-margins">
                                            <img width="100%" src="<?php echo e(URL::to($list_stakes->path_image_list_stakes)); ?>/<?php echo e($list_stakes->name_image_list_stakes); ?>">
                                        </a>
                                    </td>
	                                <td><?php echo e($list_stakes->name_list_stakes); ?></td>
	                                <td width="5%">
	                                	<div class="input-group">
											<div class="input-group-btn">
												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="caret"></span>
												</button>
												<div class="dropdown-menu dropdown-menu-right action">
													<?php echo e(Shwetech::edit($link_list_stakes,'dashboard/list_stakes/edit/'.$list_stakes->id_list_stakes)); ?>

													<?php echo e(Shwetech::delete($link_list_stakes,'dashboard/list_stakes/delete/'.$list_stakes->id_list_stakes,$list_stakes->name_list_stakes)); ?>

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