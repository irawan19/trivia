<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Sessions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/sessions')); ?>">Manage Sessions</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/sessions/processedit/'.$edit_sessions->id_sessions)); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

    						<div class="form-group row">
	                            <label for="example-month-input" class="col-2 col-form-label">Group <i style="color:red">*</i></label>
	                            <div class="col-12">
	                                <select name="groups_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
	                                    <option value="">Please Choose...</option>
	                                    <?php $__currentLoopData = $edit_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                        <?php ($selected = ''); ?>
			                                <?php if(Request::old('groups_id') == ''): ?>
			                                	<?php if($groups->id_groups == $edit_sessions->groups_id): ?>
			                                		<?php ($selected = 'selected'); ?>
			                                	<?php endif; ?>
			                                <?php else: ?>
			                                	<?php if($groups->id_groups == Request::old('groups_id')): ?>
			                                		<?php ($selected = 'selected'); ?>
			                                	<?php endif; ?>
			                                <?php endif; ?>

	                                        <?php if(Auth::user()->level_systems_id != 3): ?>
		                                		<?php ($get_host 	= \App\Master_user::where('id',$groups->users_id)->first()); ?>
		                                		<?php ($get_agent = \App\Master_user::where('id',$get_host->sub_users_id)->first()); ?>
			                                	<option value="<?php echo e($groups->id_groups); ?>" <?php echo e($selected); ?>><?php echo e($get_agent->name.' - '.$get_host->name.' | '.$groups->name_groups); ?></option>
			                                <?php else: ?>
			                                	<option value="<?php echo e($groups->id_groups); ?>" <?php echo e($selected); ?>><?php echo e($groups->name_groups); ?></option>
			                                <?php endif; ?>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </select>
	                                <?php echo e(Shwetech::formError($errors->first('groups_id'))); ?>

	                            </div>
	                        </div>
	                        <div class="form-group <?php echo e(Shwetech::errorStyleFormControl($errors->first('date_sessions'))); ?>">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                <?php ($get_date_sessions = $edit_sessions->start_date_sessions.' - '.$edit_sessions->end_date_sessions); ?>;
                                <input id="getDateRange" type="text" name="date_sessions" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('date_sessions'))); ?>" value="<?php echo e(Request::old('date_sessions') == '' ? $get_date_sessions : Request::old('date_sessions')); ?>" placeholder="Date" required>
                                <?php echo e(Shwetech::formError($errors->first('date_sessions'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('max_member_sessions'))); ?>">
                                <label class="form-control-label">Max Member <b style="color:red">*</b></label>
                                <input id="max_member_sessions" type="text" name="max_member_sessions" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('max_member_sessions'))); ?>" value="<?php echo e(Request::old('max_member_sessions') == '' ? $edit_sessions->max_member_sessions : Request::old('max_member_sessions')); ?>" placeholder="Max Member" required>
                                <?php echo e(Shwetech::formError($errors->first('max_member_sessions'))); ?>

                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
    	            			<?php if(request()->session()->get('page') != ''): ?>
    	            				<?php ($get_back = request()->session()->get('page')); ?>
                            	<?php else: ?>
                            		<?php ($get_back = 'dashboard/sessions'); ?>
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