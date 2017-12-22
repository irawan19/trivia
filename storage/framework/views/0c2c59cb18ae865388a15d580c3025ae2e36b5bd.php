
<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Top Up Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/top_up_agent')); ?>">Top Up Agent</a></li>
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

    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/top_up_agent/processadd')); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

    						<div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Agent <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="to_users_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    <?php $__currentLoopData = $add_agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agents): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    	<?php if(Auth::user()->level_systems_id == 1): ?>
	                                    		<?php ($get_master_agent = \App\Master_user::where('id',$agents->sub_users_id)->first()); ?>
	                                        	<option value="<?php echo e($agents->id); ?>" <?php echo e(Request::old('to_users_id') == $agents->id ? $select='selected' : $select=''); ?>><?php echo e($get_master_agent->name); ?> - <?php echo e($agents->name); ?></option>
	                                    	<?php else: ?>
	                                    		<option value="<?php echo e($agents->id); ?>" <?php echo e(Request::old('to_users_id') == $agents->id ? $select='selected' : $select=''); ?>><?php echo e($agents->name); ?></option>
	                                    	<?php endif; ?>
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
                            		<?php ($get_back = 'dashboard/top_up_agent'); ?>
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