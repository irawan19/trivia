<!DOCTYPE html>
<html lang="en">
	<base href="<?php echo e(URL::asset('/')); ?>" target="_top">
	<head>
		<?php echo $__env->make('dashboard.partials.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('dashboard.partials.css', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<script src="<?php echo e(URL::asset('public/dashboard/plugins/jquery/jquery.min.js')); ?>"></script>
	</head>
	<body class="fix-header fix-sidebar card-no-border logo-center">
		<?php echo $__env->make('dashboard.partials.preloader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div id="main-wrapper">
			<?php echo $__env->make('dashboard.partials.topbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php echo $__env->make('dashboard.partials.left-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<div class="page-wrapper">
		    	<?php echo $__env->yieldContent('content'); ?>
				<?php echo $__env->make('dashboard.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo $__env->make('dashboard.partials.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
		</div>
		<?php echo $__env->make('dashboard.partials.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</body>
</html>