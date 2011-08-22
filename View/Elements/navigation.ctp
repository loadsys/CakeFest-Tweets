<?php
	$current = 1;
	$prize = 0;
	if ($this->request->url == 'prizes') {
		$prize = 1;
		$current = 0;
	}
?>
<!--Navigation-->
<div id="nav">
	<ul class="sf-menu">
		<li<?php echo ($current == 1 ? ' class="current"' : ''); ?>>
			<?php echo $this->Html->link('Tweets from the conference', '/'); ?>
		</li>
		<li>
			<?php echo $this->Html->link('CakeFest', 'http://cakefest.org/', array('target' => '_blank')); ?>
		</li>
		<li<?php echo ($prize == 1 ? ' class="current"' : ''); ?>>
			<?php echo $this->Html->link('Prizes', '/prizes'); ?>
		</li>
	</ul>
</div>
<!--End Navigation-->
