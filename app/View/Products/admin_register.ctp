<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Add Product</h4>
                    </div>
                    <div class="card-content">
                        <?php 
                        	echo $this->element('errors_section');
                        	echo $this->Form->create( 'Product' ,[
								'novalidate' => true,
								'enctype' => 'multipart/form-data'
							]);
                        ?>
	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group label-floating">
											<?php 
												echo $this->Form->label( 'name' , 'Name',[
													'class' => 'control-label'
												]);
											?>
											<?php 
												echo $this->Form->input( 'name' , [
													'error'	=> false,
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
												echo $this->Form->label( 'description' , 'Description',[
													'class' => 'control-label'
												]);
											?>
											<?php 
												echo $this->Form->input( 'description' , [
													'error'	=> false,
													'div' 	=> false,
													'label' => false,
													'class' => 'form-control',
													'type'	=> 'textarea'
												]);
											?>
										</div>
	                                </div>
	                            </div>

	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group label-floating">
											<?php 
												echo $this->Form->input('category_id', array(
													'options' 	=> $categories,
													'empty' 	=> '(Choose category)',
													'class' 	=> 'form-control',
													'error'		=> false,
													'div' 		=> false,
												))
											?>
										</div>
	                                </div>
	                            </div>

	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group label-floating">
											<?php 
												echo $this->Form->label( 'price' , 'Price',[
													'class' => 'control-label'
												]);
											?>
											<?php 
												echo $this->Form->input( 'price' , [
													'error'	=> false,
													'div' 	=> false,
													'label' => false,
													'class' => 'form-control',
													'type'	=> 'number'
												]);
											?>
										</div>
	                                </div>
	                            </div>

	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group label-floating">
											<?php 
												echo $this->Form->label( 'is_not_available' , 'Availability',[
													'class' => 'control-label'
												]);
											?>
											<?php 
												$attributes = array(
													'legend' 		=> false,
													'separator'		=> '<br/>',
												);

												echo $this->Form->radio(
													'is_not_available', 
													$available, 
													$attributes
												);
											?>
										</div>
	                                </div>
	                            </div>


								<button type="button" class="btn btn-primary pull-right" onClick="window.location.href='/admin/products/list'">
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