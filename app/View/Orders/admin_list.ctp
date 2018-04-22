<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h3 class="title">List of Orders</h3>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                        	<?php if(count($orders)>0):?>
	                            <thead class="text-primary">
	                            	<th>Name</th>
	                            	<th>Description</th>
									<th></th>
	                            </thead>
	                            <tbody>
		                            	<?php foreach( $orders as $key => $order ):?>
			                                <tr>
			                                	<td><?php echo $order['Product']['name'] ?></td>
			                                	<td><?php echo $order['Product']['description'] ?></td>
												<td>
													<button value="<?php echo $order['Product']['id'] ?>" type="submit" class="btn btn-sm btn-primary pull-right btn-delete" data-toggle="modal" data-target="#deleteModal">
														Delete Product<div class="ripple-container"></div>
													</button>
													<button type="submit" class="btn btn-sm btn-primary pull-right" onClick="window.location.href='/admin/products/edit/<?php echo $order['Product']['id'] ?>'">
														Edit Product<div class="ripple-container"></div>
													</button>
												</td>
			                                </tr>
		                            	<?php endforeach;?>
	                            </tbody>
                            <?php else: ?>
								<tr>
									<td colspan="6" style="text-align:center"> No data found </td>
								</tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>