<?php echo $this->element('admin_navbar') ?>

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-plain">
					<div class="card-header" data-background-color="purple">
						<h4 class="title">Welcome <?php echo $this->Session->read('Auth.User.first_name') . ' ' . $this->Session->read('Auth.User.last_name') ?></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>