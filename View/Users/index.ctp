<div>
	<h2>Users</h2>
	<table style="wight: 100%;">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Count</th>
			<th>Participating</th>
			<th>Actions</th>
		</tr>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo __($user['User']['id']); ?></td>
				<td><?php echo __($user['User']['username']); ?></td>
				<td><?php echo __($user['User']['tweet_count']); ?></td>
				<td><?php echo $user['User']['is_participant'] ? 'Yes' : 'No'; ?></td>
				<td>
					<?php echo $this->Html->link('Blacklist', array('action' => 'blacklist', $user['User']['id'])); ?>
					<?php if ($user['User']['is_participant']): ?>
						<?php echo $this->Html->link('Revoke Participation', array('action' => 'not_participant', $user['User']['id'])); ?>
					<?php else: ?>
						<?php echo $this->Html->link('Allow Participation', array('action' => 'participant', $user['User']['id'])); ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div class="paging">
		<?php echo $this->Paginator->prev(); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next(); ?>
	</div>
</div>