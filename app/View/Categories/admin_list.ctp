<div class="content">
    <div class="container-fluid">
		<a href="/admin/categories/register">
			<button type="submit" class="btn btn-primary pull-right">
				Create Category<div class="ripple-container"></div>
			</button>
		</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h3 class="title">List of Categories</h3>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                        	<?php if(count($categories)>0):?>
	                            <thead class="text-primary">
	                            	<th>Name</th>
	                            	<th>Description</th>
									<th></th>
	                            </thead>
	                            <tbody>
		                            	<?php foreach( $categories as $key => $category ):?>
			                                <tr>
			                                	<td><?php echo $category['Category']['name'] ?></td>
			                                	<td><?php echo $category['Category']['description'] ?></td>
												<td>
													<button value="<?php echo $category['Category']['id'] ?>" type="submit" class="btn btn-sm btn-primary pull-right btn-delete" data-toggle="modal" data-target="#deleteModal">
														Delete Category<div class="ripple-container"></div>
													</button>
													<button type="submit" class="btn btn-sm btn-primary pull-right" onClick="window.location.href='/admin/users/edit/<?php echo $category['Category']['id'] ?>'">
														Edit Category<div class="ripple-container"></div>
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