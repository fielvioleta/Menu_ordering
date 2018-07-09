<div class="content">
    <div class="container-fluid">
		<a href="/admin/tables/register">
			<button type="submit" class="btn btn-primary pull-right">
				Create table<div class="ripple-container"></div>
			</button>
		</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h3 class="title">List of Tables</h3>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                        	<?php if(count($tables)>0):?>
	                            <thead class="text-primary">
	                            	<th>Table number</th>
									<th>Created</th>
									<th></th>
	                            </thead>
	                            <tbody>
	                            	<?php foreach( $tables as $key => $table ):?>
		                                <tr>
		                                	<td><?php echo $table['TableNumber']['table_number'] ?></td>
											<td><?php echo $table['TableNumber']['created'] ?></td>
											<td>
												<button value="<?php echo $table['TableNumber']['id'] ?>" type="submit" class="btn btn-sm btn-primary pull-right btn-delete" data-toggle="modal" data-target="#deleteModal">
													Delete Table Number<div class="ripple-container"></div>
												</button>
											</td>
		                                </tr>
	                            	<?php endforeach;?>
	                            </tbody>
                            <?php else: ?>
								<tr>
									<td colspan="3" style="text-align:center"> No data found </td>
								</tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>