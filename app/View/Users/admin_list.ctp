<div class="content">
    <div class="container-fluid">
		<a href="/admin/users/register">
			<button type="submit" class="btn btn-primary pull-right">
				Create User<div class="ripple-container"></div>
			</button>
		</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h3 class="title">List of users</h3>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                        	<?php if(count($users)>0):?>
	                            <thead class="text-primary">
	                            	<th>Username</th>
	                            	<th>First name</th>
	                            	<th>Last name</th>
									<th>Type</th>
									<th>Email</th>
									<th>Created</th>
									<th></th>
	                            </thead>
	                            <tbody>
		                            	<?php foreach( $users as $key => $user ):?>
			                                <tr>
			                                	<td><?php echo $user['User']['username'] ?></td>
			                                	<td><?php echo $user['User']['first_name'] ?></td>
			                                	<td><?php echo $user['User']['last_name'] ?></td>
												<td><?php 
													switch ($user['User']['user_type']) {
														case 1:
															echo 'Admin';
															break;
														case 2:
															echo 'Counter';
															break;
														case 3:
															echo 'Kitchen';
															break;
													}
												?></td>
												<td><?php echo $user['User']['email'] ?></td>
												<td><?php echo $user['User']['created'] ?></td>
												<td>
													<button value="<?php echo $user['User']['id'] ?>" type="submit" class="btn btn-sm btn-primary pull-right btn-delete" data-toggle="modal" data-target="#deleteModal">
														Delete User<div class="ripple-container"></div>
													</button>
													<button type="submit" class="btn btn-sm btn-primary pull-right" onClick="window.location.href='/admin/users/edit/<?php echo $user['User']['id'] ?>'">
														Edit Profile<div class="ripple-container"></div>
													</button>
													<button type="submit" class="btn btn-sm btn-primary pull-right" onClick="window.location.href='/admin/users/change_password/<?php echo $user['User']['id'] ?>'">
														Change Password<div class="ripple-container"></div>
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