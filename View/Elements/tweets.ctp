<div class="tweets">
	<?php foreach ($tweets as $tweet): ?>
		<?php echo $this->element('tweet', array('tweet' => $tweet)); ?>
	<?php endforeach; ?>
</div>