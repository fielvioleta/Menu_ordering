<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?php echo $title ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<?php
		echo $this->Html->css('../files/admin_dashboard/css/bootstrap.min');
		echo $this->Html->css('../files/admin_dashboard/css/material-dashboard');
		echo $this->Html->css('../files/admin_dashboard/css/font-awesome.min');
		echo $this->Html->css('../files/admin_dashboard/css/materials-icon');
		// <!--   Core JS Files   -->
		echo $this->Html->script('../files/admin_dashboard/js/jquery-1.11.min');
		// echo $this->Html->script('../files/admin_dashboard/js/jquery-3.1.0.min');
		echo $this->Html->script('../files/admin_dashboard/js/bootstrap.min');
		echo $this->Html->script('../files/admin_dashboard/js/material.min');
		// <!--  Charts Plugin -->
		echo $this->Html->script('../files/admin_dashboard/js/chartist.min');
		// <!--  Notifications Plugin    -->
		echo $this->Html->script('../files/admin_dashboard/js/bootstrap-notify');
		// <!-- Material Dashboard javascript methods -->
		echo $this->Html->script('../files/admin_dashboard/js/material-dashboard');
		echo $this->Html->script('../files/admin_dashboard/js/demo');

		echo $this->Html->script($controller);
		echo $this->Html->css('styles');

		// jfiler
		echo $this->Html->script('../files/jfiler/js/jquery.filer.min');
		echo $this->Html->css('../files/jfiler/css/jquery.filer');
		echo $this->Html->css('../files/jfiler/css/themes/jquery.filer-dragdropbox-theme');
	?>
</head>
	<body>
		<div class="wrapper">
		    <?php echo $this->element('admin_sidebar'); ?>
		    <div class="main-panel">
				<div style="display: none">
		    		<?php echo $this->Flash->render(); ?>
				</div>
				<?php echo $this->element('admin_navbar') ?>
		    	<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</body>
	<?php echo $this->element('delete_modal') ?>
</html>
<script type="text/javascript">
	if( $('#flashMessage').text() !='' )
		demo.showNotificationMessage(
			'bottom',
			'right',
			$('#flashMessage').text(),
			$('#flashMessage').hasClass('success') ? 2 : 4
		);
</script>