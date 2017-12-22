
<?php $__env->startSection('content'); ?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                Laravel <?php echo e(App::VERSION()); ?>

            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align:center">
                            Welcome <b><?php echo e(Auth::user()->name); ?></b> to Trivia Web Admin Panel
                        </div>
                        <br/>
                        <?php if(Auth::user()->level_systems_id != '1'): ?>
                            <table width="25%" align="center">
                                <tr>
                                    <th width="50%">Your Bot</th>
                                    <th width="1%">:</th>
                                    <td>
                                        <?php ($id_admin = Auth::user()->id); ?>
                                        <?php ($get_admin = \App\Master_user::where('id',$id_admin)->first()); ?>
                                        <?php echo e($get_admin->bot_phone_number_users); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Your Credit</th>
                                    <th>:</th>
                                    <td>
                                        <?php ($id_admin = Auth::user()->id); ?>
                                        <?php ($get_admin = \App\Master_user::where('id',$id_admin)->first()); ?>
                                        <?php echo e($get_admin->credit_users); ?>

                                    </td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align:center">
                            <?php if($total_list_stakes != 0): ?>
                                <b>The following is a list of stakes</b>
                                <br/>
                                <div class="col-12" style="float:none;margin: 0 auto;">
                                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2" width="5%">Image</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Command</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php ($no = 1); ?>
                                            <?php $__currentLoopData = $view_list_stakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_stakes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td width="5%"><?php echo e($no); ?></td>
                                                    <td width="5%">
                                                        <a href="<?php echo e(URL::to($list_stakes->path_image_list_stakes)); ?>/<?php echo e($list_stakes->name_image_list_stakes); ?>" class="image-popup-no-margins">
                                                            <img width="100%" src="<?php echo e(URL::to($list_stakes->path_image_list_stakes)); ?>/<?php echo e($list_stakes->name_image_list_stakes); ?>">
                                                        </a>
                                                    </td>
                                                    <td><?php echo e($list_stakes->name_list_stakes); ?></td>
                                                    <td><?php echo e($list_stakes->command_list_stakes); ?></td>
                                                </tr>
                                                <?php ($no++); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <b style="color:red">no list of stakes</b>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>