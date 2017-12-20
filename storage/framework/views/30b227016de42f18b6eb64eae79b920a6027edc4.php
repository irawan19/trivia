<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">App Configuration</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(URL('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item active">App Configuration</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <h4 style="text-align: center">Logo</h4>
                            <?php if(Session::get('after_save.alert') == 'success'): ?>
                                <?php echo e(Shwetech::formSuccess(Session::get('after_save.text'))); ?>

                            <?php endif; ?>
                            <form action="<?php echo e(URL('dashboard/app_configuration/processedit')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('sessions_days_duration_app_configurations'))); ?>">
                                    <label class="form-control-label">Default Sessions Duration (Day) <b style="color:red">*</b></label>
                                    <input id="sessions_days_duration_app_configurations" type="text" name="sessions_days_duration_app_configurations" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('sessions_days_duration_app_configurations'))); ?>" value="<?php echo e(Request::old('sessions_days_duration_app_configurations')); ?>" placeholder="Default Sessions Duration (Day)" required>
                                    <?php echo e(Shwetech::formError($errors->first('sessions_days_duration_app_configurations'))); ?>

                                </div>
                                <div class="form-group <?php echo e(Shwetech::errorStyleGroup($errors->first('game_minutes_duration_app_configurations'))); ?>">
                                    <label class="form-control-label">Default Game Duration (Minutes) <b style="color:red">*</b></label>
                                    <input id="game_minutes_duration_app_configurations" type="text" name="game_minutes_duration_app_configurations" class="form-control number_format <?php echo e(Shwetech::errorStyleFormControl($errors->first('game_minutes_duration_app_configurations'))); ?>" value="<?php echo e(Request::old('game_minutes_duration_app_configurations')); ?>" placeholder="Default Game Duration (Minutes)" required>
                                    <?php echo e(Shwetech::formError($errors->first('game_minutes_duration_app_configurations'))); ?>

                                </div>
                                <br/>
                                <div class="form-group" align="center">
                                    <button type="submit" name="update_logo" value="update_logo" class="btn btn-warning waves-effect waves-light m-r-10"> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    	                <div class="form-group">
                            <h4 style="text-align: center">Logo</h4>
                            <?php if(Session::get('after_save_logo.alert') == 'success'): ?>
                                <?php echo e(Shwetech::formSuccess(Session::get('after_save_logo.text'))); ?>

                            <?php endif; ?>
                            <div class="form-group row" align="center">
                                <div class="col-md-12">
                                    <a href="<?php echo e(URL::to($view_app_configurations->path_logo_app_configurations)); ?>/<?php echo e($view_app_configurations->name_logo_app_configurations); ?>" class="image-popup-no-margins"><img src="<?php echo e(URL::to($view_app_configurations->path_logo_app_configurations)); ?>/<?php echo e($view_app_configurations->name_logo_app_configurations); ?>"></a>
                                </div>
                            </div>
                            <form enctype="multipart/form-data" action="<?php echo e(URL('dashboard/app_configuration/processeditlogo')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                    	<i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    	<span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                    	<span class="fileinput-new">Select Logo</span>
                                    	<span class="fileinput-exists">Change</span>
                                    	<input type="hidden">
                                    	<input type="file" name="userfile_logo" id="app_configuration_logo" />
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                                <?php echo e(Shwetech::formError($errors->first('userfile_logo'))); ?>

                                <br/>
                                <div class="form-group" align="center">
                                    <button type="submit" name="update_logo" value="update_logo" class="btn btn-success waves-effect waves-light m-r-10"> Update Logo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    	                <div class="form-group">
                            <h4 style="text-align: center">Icon</h4>
                            <?php if(Session::get('after_save_icon.alert') == 'success'): ?>
                                <?php echo e(Shwetech::formSuccess(Session::get('after_save_icon.text'))); ?>

                            <?php endif; ?>
                            <div class="form-group row" align="center">
                                <div class="col-md-12">
                                    <a href="<?php echo e(URL::to($view_app_configurations->path_icon_app_configurations)); ?>/<?php echo e($view_app_configurations->name_icon_app_configurations); ?>" class="image-popup-no-margins"><img src="<?php echo e(URL::to($view_app_configurations->path_icon_app_configurations)); ?>/<?php echo e($view_app_configurations->name_icon_app_configurations); ?>"></a>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                                <label style="color:orange">better image size 40x40px</label>
                            </div>
                            <form enctype="multipart/form-data" action="<?php echo e(URL('dashboard/app_configuration/processediticon')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                    	<i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    	<span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                    	<span class="fileinput-new">Select Icon</span>
                                    	<span class="fileinput-exists">Change</span>
                                    	<input type="hidden">
                                    	<input type="file" name="userfile_icon" id="app_configuration_icon" />
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                                <?php echo e(Shwetech::formError($errors->first('userfile_icon'))); ?>

                                <br/>
                                <div class="form-group" align="center">
                                    <button type="submit" name="update_icon" value="update_icon" class="btn btn-primary waves-effect waves-light m-r-10"> Update Icon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>