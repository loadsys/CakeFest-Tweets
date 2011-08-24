<div class="login">
	<h2>Login</h2>
	<?php echo $this->Form->create('Account', array('url' => array('controller' => 'users', 'action' => 'login'))); ?>
		<label>Email</label>
		<?php echo $this->Form->text('email'); ?>
		<br />
		<label>Password</label>
		<?php echo $this->Form->password('password'); ?>
	<?php echo $this->Form->end('Login'); ?>
</div>