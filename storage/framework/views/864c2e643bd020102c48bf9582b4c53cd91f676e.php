<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Group</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/group')); ?>">Manage Group</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/group/processedit/'.$edit_groups->id_groups)); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

                            <?php if(Auth::user()->level_systems_id != 3): ?>
        						<div class="form-group row">
    	                            <label for="example-month-input" class="col-2 col-form-label">Host <i style="color:red">*</i></label>
    	                            <div class="col-12">
    	                                <select name="users_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
    	                                    <option value="">Please Choose...</option>
    	                                    <?php $__currentLoopData = $edit_hosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hosts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	                                        <?php ($selected = ''); ?>
    			                                <?php if(Request::old('users_id') == ''): ?>
    			                                	<?php if($hosts->id == $edit_groups->users_id): ?>
    			                                		<?php ($selected = 'selected'); ?>
    			                                	<?php endif; ?>
    			                                <?php else: ?>
    			                                	<?php if($hosts->id == Request::old('users_id')): ?>
    			                                		<?php ($selected = 'selected'); ?>
    			                                	<?php endif; ?>
    			                                <?php endif; ?>

    			                                <?php if(Auth::user()->level_systems_id == 1): ?>
    		                                		<?php ($get_host = \App\Master_user::where('id',$hosts->sub_users_id)->first()); ?>
    		                                    	<option value="<?php echo e($hosts->id); ?>" <?php echo e($selected); ?>><?php echo e($get_host->name); ?> - <?php echo e($hosts->name); ?></option>
    		                                	<?php else: ?>
    		                                		<option value="<?php echo e($hosts->id); ?>" <?php echo e($selected); ?>><?php echo e($hosts->name); ?></option>
    		                                	<?php endif; ?>
    	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	                                </select>
    	                                <?php echo e(Shwetech::formError($errors->first('users_id'))); ?>

    	                            </div>
    	                        </div>
                            <?php else: ?>
                                <input id="users_id" type="hidden" name="users_id" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('users_id'))); ?>" value="<?php echo e(Auth::user()->id); ?>">
                            <?php endif; ?>
                            <input id="id_groups" type="hidden" name="id_groups" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('id_groups'))); ?>" value="<?php echo e($edit_groups->id_groups); ?>">
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('name_groups'))); ?>">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name_groups" type="text" name="name_groups" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('name_groups'))); ?>" value="<?php echo e(Request::old('name_groups') == '' ? $edit_groups->name_groups : Request::old('name_groups')); ?>" placeholder="Name" required>
                                <?php echo e(Shwetech::formError($errors->first('name_groups'))); ?>

                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			<?php if(request()->session()->get('page') != ''): ?>
    	            				<?php ($get_back = request()->session()->get('page')); ?>
                            	<?php else: ?>
                            		<?php ($get_back = 'dashboard/group'); ?>
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