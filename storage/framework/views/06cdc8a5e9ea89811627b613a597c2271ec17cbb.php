
<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Top Up Master Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/top_up_master_agent')); ?>">Top Up Master Agent</a></li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    	<?php if(Session::get('after_save.alert') == 'success'): ?>
    		            	<?php echo e(Shwetech::formSuccess(Session::get('after_save.text'))); ?>

    		            <?php endif; ?>

    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/top_up_master_agent/processadd')); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

    						<div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Master Agent <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="to_users_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    <?php $__currentLoopData = $add_master_agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master_agents): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                        <option value="<?php echo e($master_agents->id); ?>" <?php echo e(Request::old('to_users_id') == $master_agents->id ? $select='selected' : $select=''); ?>><?php echo e($master_agents->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </select>
	                                <?php echo e(Shwetech::formError($errors->first('to_users_id'))); ?>

	                            </div>
	                        </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('credit_top_ups'))); ?>">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input id="credit_top_ups" type="text" name="credit_top_ups" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('credit_top_ups'))); ?>" value="<?php echo e(Request::old('credit_top_ups')); ?>" placeholder="Credit" required>
                                <?php echo e(Shwetech::formError($errors->first('credit_top_ups'))); ?>

                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			<?php if(request()->session()->get('page') != ''): ?>
    	            				<?php ($get_back = request()->session()->get('page')); ?>
                            	<?php else: ?>
                            		<?php ($get_back = 'dashboard/top_up_master_agent'); ?>
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