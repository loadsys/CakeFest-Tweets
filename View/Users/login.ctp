<div class="users login">
	<?php echo $this->Form->create('Account', array('url' => array('controller' => 'users', 'action' => 'login'))); ?>
		<?php echo $this->Form->input('email'); ?>
		<?php echo $this->Form->input('password'); ?>
	<?php echo $this->Form->end('Login'); ?>
</div>