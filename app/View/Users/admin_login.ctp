<?php 
	echo $this->Form->create( 'User' ,[
		'novalidate' => true
	]);
?>
<h1>Login Form</h1>
<?php echo $this->Flash->render(); ?>
<div>
	<?php 
		echo $this->Form->input('username' , [
			'error' 		=> false,
			'div' 			=> false,
			'label' 		=> false,
			'placeholder' 	=> 'Username',
			'id' 			=> 'username'
		]);
	?>
</div>
<div>
	<?php 
		echo $this->Form->input('password' , [
			'error' 		=> false,
			'div' 			=> false,
			'label' 		=> false,
			'placeholder' 	=> 'Password',
			'id' 			=> 'password'
		]);
		echo $this->Form->submit('Log in');
	?>
</div>
<?php echo $this->Form->end(); ?>