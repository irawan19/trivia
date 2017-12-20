
<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Menu</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <?php if(Request::segment(4) == ''): ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/menu')); ?>">Menu</a></li>
                    <li class="breadcrumb-item active">Order</li>
                <?php else: ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/menu')); ?>">Menu</a></li>
                    <li class="breadcrumb-item active"><?php echo e($view_menus->name_menus); ?></li>
                <?php endif; ?>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    			       <ul class="handles list sortable" id="order_page" style="cursor:pointer;margin-left:-35px">
                            <?php $__currentLoopData = $view_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php (printf('<li id="menu_%s" class="btn btn-outline-secondary btn-lg btn-block btn-order"><span>:: '.$orders->name_menus.'</li></span>', $orders->id_menus, $orders->name_menus)); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
    					<br/>
                        <div class="form-group" align="center">
    	            		<?php if(request()->session()->get('page') != ''): ?>
    	            			<?php ($get_back = request()->session()->get('page')); ?>
                        	<?php else: ?>
                                <?php if(Request::segment(4) == ''): ?>
                        	       <?php ($get_back = 'dashboard/menu'); ?>
                        	    <?php else: ?>
                                    <?php ($get_back = 'dashboard/menu/submenu/'.$view_menus->id_menus); ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        	<a href="<?php echo e($get_back); ?>" class="btn waves-effect waves-light btn-danger"> Back</a>
                        </div>
    				</div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>