<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Change password</h4>
                    </div>
                    <div class="card-content">
                        <?php 
                        	echo $this->element('errors_section');
                        	echo $this->Form->create( 'User' ,[
								'novalidate' => true
							]);
                        ?>
							<div class="row">
							    <div class="col-md-12">
									<div class="form-group label-floating">
										<?php 
											echo $this->Form->label( 'password' , 'Password',[
												'class' => 'control-label'
											]);
										?>
										<?php 
											echo $this->Form->input('password' , [
												'error' => false,
												'div' 	=> false,
												'label' => false,
												'class' => 'form-control'
											]);
										?>
									</div>
							    </div>
							</div>

							<div class="row">
							    <div class="col-md-12">
									<div class="form-group label-floating">
										<?php 
											echo $this->Form->label( 'password_confirm' , 'Confirm Password',[
												'class' => 'control-label'
											]);
										?>
										<?php 
											echo $this->Form->input('password_confirm' , [
												'error' => false,
												'div' 	=> false,
												'label' => false,
												'type' 	=> 'password',
												'class' => 'form-control'
											]);
										?>
									</div>
							    </div>
							</div>
						<button type="button" class="btn btn-primary pull-right" onClick="window.location.href='/admin/users/list'">
							Cancel<div class="ripple-container"></div>
						</button>
						<?php 
							echo $this->Form->end([
								'label'	=> 'Save',
								'class'	=> 'btn btn-primary pull-right'
							]); 
						?>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>