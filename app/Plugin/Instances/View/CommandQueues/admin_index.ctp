<?php
/**
 *  HE cPanel -- Hosting Engineers Control Panel
 *  Copyright (C) 2015  Dynamictivity LLC (http://www.hecpanel.com)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as
 *   published by the Free Software Foundation, either version 3 of the
 *   License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<div class="table-responsive">
    <h2><?php echo __('Command Queue'); ?></h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('command'); ?></th>
				<th><?php echo $this->Paginator->sort('host_server_id'); ?></th>
				<th><?php echo $this->Paginator->sort('is_recurring'); ?></th>
				<th><?php echo $this->Paginator->sort('is_once_per_day'); ?></th>
				<th><?php echo $this->Paginator->sort('time'); ?></th>
				<th><?php echo $this->Paginator->sort('is_enabled'); ?></th>
				<th><?php echo $this->Paginator->sort('last_executed'); ?> <?php echo $this->Paginator->sort('last_executed_host_server_id', 'By Host Server'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($commandQueues as $commandQueue): ?>
				<tr>
					<td><?php echo h($commandQueue['CommandQueue']['command']); ?>&nbsp;</td>
					<td><?php echo h($commandQueue['HostServer']['servername']); ?>&nbsp;</td>
					<td><?php echo h($commandQueue['CommandQueue']['is_recurring']); ?>&nbsp;</td>
					<td><?php echo h($commandQueue['CommandQueue']['is_once_per_day']); ?>&nbsp;</td>
					<td><?php echo h($commandQueue['CommandQueue']['time']); ?>&nbsp;</td>
					<td><?php echo h($commandQueue['CommandQueue']['is_enabled']); ?>&nbsp;</td>
					<td><?php echo h($commandQueue['CommandQueue']['last_executed']); ?>&nbsp;<?php echo h($commandQueue['LastExecutedHostServer']['servername']); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->buttonGroup(
							array(
								$this->Html->button(array('cog', 'default', 'xs'), array('action' => 'edit', $commandQueue['CommandQueue']['id']), array('escape' => false, 'title' => __('Edit'))),
								$this->Html->postButton(array('refresh', 'default', 'xs'), array('action' => 'reset', $commandQueue['CommandQueue']['id']), array('escape' => false, 'title' => __('Reset')), __('Are you sure you want to reset # %s?', $commandQueue['CommandQueue']['id'])),
								$this->Html->postButton(array('trash', 'default', 'xs'), array('action' => 'delete', $commandQueue['CommandQueue']['id']), array('escape' => false, 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $commandQueue['CommandQueue']['id']))
							)	
						); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<?php echo $this->element('paging'); ?>
	</table>
</div>
<?php echo $this->element('add_button'); ?>