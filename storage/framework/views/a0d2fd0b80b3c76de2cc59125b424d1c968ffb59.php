<?php ($get_app_configuration = \App\Master_app_configuration::first()); ?>
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo e(URL('/')); ?>" target="_blank">
                <b>
                    <img src="<?php echo e(URL::asset($get_app_configuration->path_logo_app_configurations.$get_app_configuration->name_logo_app_configurations)); ?>" alt="homepage" class="light-logo" width="55%" />
                </b>
                <span>
                    <img src="<?php echo e(URL::asset($get_app_configuration->path_logo_text_app_configurations.$get_app_configuration->name_logo_text_app_configurations)); ?>" alt="homepage" class="dark-logo" width="55%" />
                </span>
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link waves-effect waves-dark" style="color:white">
                        <?php echo Shwetech::changeDBToDate(date('Y-m-d')); ?>, <onload="timeJavascript()" id="output">
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b><?php echo e(Auth::user()->name); ?></b> <i class="mdi mdi-arrow-down-drop-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user" style="text-align: center">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?php echo e(URL::asset($get_app_configuration->path_logo_app_configurations.$get_app_configuration->name_logo_app_configurations)); ?>" alt="user"></div>
                                    <div class="u-text">
                                        <br/>
                                        <h4><?php echo e(Auth::user()->name); ?></h4>
                                        <p class="text-muted"><?php echo e(Auth::user()->email); ?></p>
                                        <br/>
                                        <a href="<?php echo e(URL('dashboard/profile')); ?>" class="btn btn-rounded btn-danger btn-sm">View Account</a>
                                    </div>
                                </div>
                            </li>
                            <?php if(Auth::user()->level_systems_id != '1'): ?>
                                <li role="separator" class="divider"></li>
                                <div class="u-info">
                                    <?php ($id_admin = Auth::user()->id); ?>
                                    <?php ($get_admin = \App\Master_user::join('master_bots','bots_id','=','master_bots.id_bots')
                                                                        ->where('id',$id_admin)
                                                                        ->first()); ?>
                                    <b>BOT : <?php echo e($get_admin->name_bots.' - '.$get_admin->phone_number_bots); ?></b>
                                    <br/>
                                    <b>Credit : <?php echo e($get_admin->credit_users); ?></b>
                                </div>
                            <?php endif; ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo e(URL('dashboard/logout')); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>