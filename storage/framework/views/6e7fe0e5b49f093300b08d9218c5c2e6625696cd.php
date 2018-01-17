
<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Profile</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
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
    		            
    		            <form class="form-horizontal m-t-40" action="<?php echo e(URL('dashboard/profile/processedit/'.$view_profile->id)); ?>" method="POST">
    						<?php echo e(csrf_field()); ?>

    						<div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('level_system_id'))); ?>">
                                <label class="form-control-label">Level System</label>
                                <input id="level_system_id" type="text" name="level_system_id" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('level_system_id'))); ?>" value="<?php echo e($view_profile->name_level_systems); ?>" placeholder="Level System" disabled>
                                <?php echo e(Shwetech::formError($errors->first('level_system_id'))); ?>

                            </div>
                            <?php ($id_sub_users = $view_profile->sub_users_id); ?>
                            <?php if($id_sub_users != 0): ?>
                                <?php ($get_sub_users = \App\Master_user::where('id',$id_sub_users)->first()); ?>
                                <?php ($sub_users = $get_sub_users->name); ?>
                            <?php else: ?>
                                <?php ($sub_users = '-'); ?>
                            <?php endif; ?>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('sub_users_id'))); ?>">
                                <label class="form-control-label">Sub User</label>
                                <input id="sub_users_id" type="text" name="sub_users_id" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('sub_users_id'))); ?>" value="<?php echo e($sub_users); ?>" placeholder="Agent" disabled>
                                <?php echo e(Shwetech::formError($errors->first('sub_users_id'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('max_group_users'))); ?>">
                                <label class="form-control-label">Total Group</label>
                                <input id="max_group_users" readonly="readonly" type="text" name="max_group_users" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('max_group_users'))); ?>" value="<?php echo e(Request::old('max_group_users') == '' ? $view_profile->max_group_users : Request::old('max_group_users')); ?>" placeholder="Total Group" required>
                                <?php echo e(Shwetech::formError($errors->first('max_group_users'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('credit_users'))); ?>">
                                <label class="form-control-label">Credit</label>
                                <input id="credit_users" readonly="readonly" type="text" name="credit_users" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('credit_users'))); ?>" value="<?php echo e(Request::old('credit_users') == '' ? $view_profile->credit_users : Request::old('credit_users')); ?>" placeholder="Credit" required>
                                <?php echo e(Shwetech::formError($errors->first('credit_users'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('name'))); ?>">
                                <label class="form-control-label">Name <b style="color:red">*</b></label>
                                <input id="name" type="text" name="name" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('name'))); ?>" value="<?php echo e(Request::old('name') == '' ? $view_profile->name : Request::old('name')); ?>" placeholder="Name" required autofocus>
                                <?php echo e(Shwetech::formError($errors->first('name'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('email'))); ?>">
                                <label class="form-control-label">Email <b style="color:red">*</b></label>
                                <input id="email" type="text" name="email" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('email'))); ?>" value="<?php echo e(Request::old('email') == '' ? $view_profile->email : Request::old('email')); ?>" placeholder="Email" required>
                                <?php echo e(Shwetech::formError($errors->first('email'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('phone_number_users'))); ?>">
                                <label class="form-control-label">Phone Number <b style="color:red">*</b></label>
                                <input id="phone_number_users" type="text" name="phone_number_users" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('phone_number_users'))); ?>" value="<?php echo e(Request::old('phone_number_users') == '' ? $view_profile->phone_number_users : Request::old('phone_number_users')); ?>" placeholder="Phone Number" required>
                                <?php echo e(Shwetech::formError($errors->first('phone_number_users'))); ?>

                            </div>
                            <?php if(Auth::user()->level_systems_id == 2): ?>
                                <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('name_bots'))); ?>">
                                    <label class="form-control-label">BOT <b style="color:red">*</b></label>
                                    <input id="name_bots" type="text" name="name_bots" readonly="readonly" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('name_bots'))); ?>" value="<?php echo e(Request::old('name_bots') == '' ? $view_profile->name_bots : Request::old('name_bots')); ?>" placeholder="BOT Phone Number" required>
                                    <?php echo e(Shwetech::formError($errors->first('name_bots'))); ?>

                                </div>
                                <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('phone_number_bots'))); ?>">
                                    <label class="form-control-label">BOT Phone Number <b style="color:red">*</b></label>
                                    <input id="phone_number_bots" type="text" name="phone_number_bots" readonly="readonly" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('phone_number_bots'))); ?>" value="<?php echo e(Request::old('phone_number_bots') == '' ? $view_profile->phone_number_bots : Request::old('phone_number_bots')); ?>" placeholder="BOT Phone Number" required>
                                    <?php echo e(Shwetech::formError($errors->first('phone_number_bots'))); ?>

                                </div>
                            <?php endif; ?>
                            <br/>
                            <div align="center">
                            	<label style="color:orange">clear the password if you do not want to change the password</label>
                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('password'))); ?>">
                                <label class="form-control-label">Password</label>
                                <input id="password" type="password" name="password" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('password'))); ?>" value="<?php echo e(Request::old('password')); ?>" placeholder="Password">
                                <?php echo e(Shwetech::formError($errors->first('password'))); ?>

                            </div>
                            <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('password_confirmation'))); ?>">
                                <label class="form-control-label">Conf. Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control <?php echo e(Shwetech::errorStyleFormControl($errors->first('password_confirmation'))); ?>" value="<?php echo e(Request::old('password_confirmation')); ?>" placeholder="Password">
                                <?php echo e(Shwetech::formError($errors->first('password_confirmation'))); ?>

                            </div>
                            <br>
                            <div class="form-group" align="center">
    	            			<button type="submit" name="update" value="update" class="btn btn-success waves-effect waves-light m-r-10"> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>