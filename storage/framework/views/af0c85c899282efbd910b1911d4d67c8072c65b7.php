
<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Manage Master Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard/master_agent')); ?>">Manage Master Agent</a></li>
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

    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/master_agent/processadd')); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('name'))); ?>">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name" type="text" name="name" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('name'))); ?>" value="<?php echo e(Request::old('name')); ?>" placeholder="Name" required>
                                <?php echo e(Shwetech::formError($errors->first('name'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('email'))); ?>">
                                <label class="form-control-label">Email <b style="color:red">*</b></label>
                                <input id="email" type="text" name="email" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('email'))); ?>" value="<?php echo e(Request::old('email')); ?>" placeholder="Email" required>
                                <?php echo e(Shwetech::formError($errors->first('email'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('phone_number_users'))); ?>">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_users" type="text" name="phone_number_users" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('phone_number_users'))); ?>" value="<?php echo e(Request::old('phone_number_users')); ?>" placeholder="Phone Number" required>
                                <?php echo e(Shwetech::formError($errors->first('phone_number_users'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('bot_phone_number_users'))); ?>">
                                <label class="form-control-label">BOT Phone Number <b style="color:red">*</b></label>
                                <input id="bot_phone_number_users" type="text" name="bot_phone_number_users" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('bot_phone_number_users'))); ?>" value="<?php echo e(Request::old('bot_phone_number_users')); ?>" placeholder="BOT Phone Number" required>
                                <?php echo e(Shwetech::formError($errors->first('bot_phone_number_users'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('credit_users'))); ?>">
                                <label class="form-control-label">Credit <b style="color:red">*</b></label>
                                <input id="credit_users" type="text" name="credit_users" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('credit_users'))); ?>" value="<?php echo e(Request::old('credit_users')); ?>" placeholder="Credit" required>
                                <?php echo e(Shwetech::formError($errors->first('credit_users'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('password'))); ?>">
                                <label class="form-control-label">Password <b style="color:red">*</b></label>
                                <input id="password" type="password" name="password" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('password'))); ?>" value="<?php echo e(Request::old('password')); ?>" placeholder="Password" required>
                                <?php echo e(Shwetech::formError($errors->first('password'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('password_confirmation'))); ?>">
                                <label class="form-control-label">Conf. Password <b style="color:red">*</b></label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('password_confirmation'))); ?>" value="<?php echo e(Request::old('password_confirmation')); ?>" placeholder="Conf. Password" required>
                                <?php echo e(Shwetech::formError($errors->first('password_confirmation'))); ?>

                            </div>
                            <br/>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="save" value="save" class="btn btn-success waves-effect waves-light m-r-10"> Save</button>
    	            			<button type="submit" name="save_exit" value="save_exit" class="btn btn-success waves-effect waves-light m-r-10"> Save & Exit</button>
    	            			<?php if(request()->session()->get('page') != ''): ?>
    	            				<?php ($get_back = request()->session()->get('page')); ?>
                            	<?php else: ?>
                            		<?php ($get_back = 'dashboard/master_agent'); ?>
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