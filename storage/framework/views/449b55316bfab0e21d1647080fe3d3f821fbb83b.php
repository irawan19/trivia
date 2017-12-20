<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Game</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/game')); ?>">Manage Game</a></li>
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

    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/game/processadd')); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

	    					<div class="form-group row">
		                        <label for="example-month-input" class="col-2 col-form-label">Sessions <i style="color:red">*</i></label>
		                        <div class="col-12">
		                            <select name="sessions_id" class="custom-select col-12 select2" id="inlineFormCustomSelect" required autofocus>
		                                <option value="">Please Choose...</option>
		                                <?php $__currentLoopData = $add_sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sessions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                	<?php ($check_game = \App\Master_game::where('sessions_id',$sessions->id_sessions)
		                                										->where('status_active_games',0)
		                                										->count()); ?>
		                                	<?php if($check_game == 0): ?>
			                                	<?php if(Auth::user()->level_systems_id != 3): ?>
			                                		<?php ($get_host 	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
			                                												->join('users','users_id','users.id')
			                                												->where('id_sessions',$sessions->id_sessions)
			                                												->first()); ?>
			                                		<?php ($get_agent = \App\Master_user::where('id',$get_host->sub_users_id)->first()); ?>
				                                	<option value="<?php echo e($sessions->id_sessions); ?>" <?php echo e(Request::old('sessions_id') == $sessions->id_sessions ? $select='selected' : $select=''); ?>><?php echo e($get_agent->name.' - '.$get_host->name.' | '.$get_host->name_groups.' | '.$sessions->start_date_sessions.' - '.$sessions->end_date_sessions); ?></option>
				                                <?php else: ?>
				                                	<option value="<?php echo e($sessions->id_sessions); ?>" <?php echo e(Request::old('sessions_id') == $sessions->id_sessions ? $select='selected' : $select=''); ?>><?php echo e($sessions->start_date_sessions.' - '.$sessions->end_date_sessions); ?></option>
				                                <?php endif; ?>
				                            <?php endif; ?>
		                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                            </select>
		                            <?php echo e(Shwetech::formError($errors->first('sessions_id'))); ?>

		                        </div>
		                    </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleFormControl($errors->first('date_games'))); ?>">
                                <label class="form-control-label">Date <b style="color:red">*</b></label>
                                <input id="getDateRange" type="text" name="date_games" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('date_games'))); ?>" value="<?php echo e(Request::old('date_games')); ?>" placeholder="Date" required>
                                <?php echo e(Shwetech::formError($errors->first('date_game'))); ?>

                            </div>
                            <label class="form-control-label">Return to Player <b style="color:red">*</b></label>
                            <div class="input-group <?php echo e(Shwetech::errorStyleFormControl($errors->first('rtp_games'))); ?>">
                                <input id="rtp_games" type="text" name="rtp_games" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('rtp_games'))); ?>" value="<?php echo e(Request::old('rtp_games')); ?>" placeholder="Return To Player" required aria-describedby="basic-addon2">
                                <span class="input-group-addon" id="basic-addon2">%</span>
                                <?php echo e(Shwetech::formError($errors->first('rtp_games'))); ?>

                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			<?php if(request()->session()->get('page') != ''): ?>
    	            				<?php ($get_back = request()->session()->get('page')); ?>
                            	<?php else: ?>
                            		<?php ($get_back = 'dashboard/game'); ?>
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