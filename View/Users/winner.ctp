<div>
	<h2>Users</h2>
	<?php $i = 1; ?>
	<?php foreach ($winners as $winner): ?>
		<h3>#<?php echo $i; ?> <a href="http://twitter.com/#!/<?php echo $winner; ?>"><?php echo $winner ?></a></h3>
		<?php $i++; ?>
	<?php endforeach; ?>
</div>