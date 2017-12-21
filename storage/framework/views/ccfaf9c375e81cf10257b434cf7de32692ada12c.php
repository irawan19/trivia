<?php ($get_app_configuration = \App\Master_app_configuration::first()); ?>
<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo e(config('app.name')); ?></title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="<?php echo e(URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations)); ?>" />
        <link rel="Shortcut icon" type="image/png" href="<?php echo e(URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations)); ?>" type="image/x-icon" />
        <link rel="apple-touch-icon" href="<?php echo e(URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations)); ?>">
        <meta name="msapplication-TileColor" content="#ff2658">
        <meta name="msapplication-TileImage" content="<?php echo e(URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations)); ?>">
        <link href="<?php echo e(URL::asset('public/dashboard/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
        
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .img-fluid{
                width: 100% \9;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard/home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>
                        <?php ($check_admin = \App\User::where('level_systems_id','1')->count()); ?>
                        <?php if($check_admin == 0): ?>
                            <a href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div style="color:black;font-size:22px;"><b>Welcome To</b></div>
                <div class="title m-b-md">
                    <img class="img-fluid" src="<?php echo e(URL::asset($get_app_configuration->path_logo_app_configurations.$get_app_configuration->name_logo_app_configurations)); ?>">
                </div>
            </div>
        </div>
    </body>
</html>
