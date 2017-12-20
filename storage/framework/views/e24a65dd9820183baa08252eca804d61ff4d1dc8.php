<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Sessions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/sessions')); ?>">Manage Sessions</a></li>
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

    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/sessions/processadd')); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

	    					<div class="form-group row">
		                        <label for="example-month-input" class="col-2 col-form-label">Group <i style="color:red">*</i></label>
		                        <div class="col-12">
		                            <select name="groups_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
		                                <option value="">Please Choose...</option>
		                                <?php $__currentLoopData = $add_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ($check_last_sessions =\App\Master_session::where('groups_id',$groups->id_groups)
                                                                                            ->where('status_active_sessions','0')
                                                                                            ->orWhere('status_active_sessions','1')
                                                                                            ->where('groups_id',$groups->id_groups)
                                                                                            ->count()); ?>
                                            <?php if($check_last_sessions == 0): ?>
    		                                	<?php if(Auth::user()->level_systems_id != 3): ?>
    		                                		<?php ($get_host 	= \App\Master_user::where('id',$groups->users_id)->first()); ?>
    		                                		<?php ($get_agent = \App\Master_user::where('id',$get_host->sub_users_id)->first()); ?>
    			                                	<option value="<?php echo e($groups->id_groups); ?>" <?php echo e(Request::old('groups_id') == $groups->id_groups ? $select='selected' : $select=''); ?>><?php echo e($get_agent->name.' - '.$get_host->name.' | '.$groups->name_groups); ?></option>
    			                                <?php else: ?>
    			                                	<option value="<?php echo e($groups->id_groups); ?>" <?php echo e(Request::old('groups_id') == $groups->id_groups ? $select='selected' : $select=''); ?>><?php echo e($groups->name_groups); ?></option>
                                                <?php endif; ?>
    			                             <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                            </select>
		                            <?php echo e(Shwetech::formError($errors->first('groups_id'))); ?>

		                        </div>
		                    </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleFormControl($errors->first('date_sessions'))); ?>">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                <input id="getDateRange" type="text" name="date_sessions" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('date_sessions'))); ?>" value="<?php echo e(Request::old('date_sessions')); ?>" placeholder="Date" required>
                                <?php echo e(Shwetech::formError($errors->first('date_sessions'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleFormControl($errors->first('max_member_sessions'))); ?>">
                                <label class="form-control-label">Max Member <b style="color:red">*</b></label>
                                <input id="max_member_sessions" type="text" name="max_member_sessions" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('max_member_sessions'))); ?>" value="<?php echo e(Request::old('max_member_sessions')); ?>" placeholder="Max Member" required>
                                <?php echo e(Shwetech::formError($errors->first('max_member_sessions'))); ?>

                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
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