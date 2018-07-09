<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<?php echo $this->Html->css('../files/admin/style'); ?>
</head>
<body>
	<div class="container">
		<section id="content">
			<?php echo $this->fetch('content'); ?>
		</section>
	</div>
</body>
</html>
