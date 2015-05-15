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
    <h2><?php echo __('Instances'); ?></h2>
	<table class="table table-striped">
        <thead>
            <tr>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
                <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('game_id'); ?></th>
				<th><?php echo $this->Paginator->sort('host_server_id', 'Server Instance IP:Port'); ?></th>
                <th><?php echo $this->Paginator->sort('instance_type_id'); ?></th>
                <th><?php echo $this->Paginator->sort('instance_profile_id'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
			<?php foreach ($instances as $instance): ?>
			<tr>
				<td>
					<?php //if ($instance['Instance']['status'] !== 'Stopped') : ?><!--<span class="badge">--><?php //endif; ?><?php //echo $instance['Instance']['status']; ?><?php //if ($instance['Instance']['status'] !== 'Stopped') : ?><!--</span>--><?php //endif; ?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-repeat btn-xs"></span>', array('action' => 'check', $instance['Instance']['id']), array('escape' => false, 'title' => __('Update Status'))); ?>
				</td>
				<td><?php echo h($instance['User']['username']); ?>&nbsp;</td>
				<td><?php echo h($instance['Instance']['name']); ?>&nbsp;</td>
				<td><?php echo h($games[$instance['Instance']['game_id']]); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($instance['HostServer']['ip'] . ':' . $instance['Instance']['port'], 'steam://connect/' . $instance['HostServer']['ip'] . ':' . $instance['Instance']['port']); ?>&nbsp;</td>
				<td><?php echo h($instance['InstanceType']['name']); ?>&nbsp;</td>
				<td><?php echo h($instance['InstanceProfile']['name']); ?>&nbsp;</td>
				<td class="actions">
					<?php
						echo $this->Html->buttonGroup(
							array(
								//($instance['Instance']['status'] == 'Stopped') ? $this->Html->button(array('play', 'default', 'xs'), array('action' => 'start', $instance['Instance']['id']), array('escape' => false, 'title' => __('Start Instance'))) : $this->Html->button(array('stop', 'default', 'xs'), array('action' => 'stop', $instance['Instance']['id']), array('escape' => false, 'title' => __('Stop Instance'))),
								$this->Html->button(array('play', 'default', 'xs'), array('action' => 'start', $instance['Instance']['id']), array('escape' => false, 'title' => __('Start Instance'))),
								$this->Html->button(array('stop', 'default', 'xs'), array('action' => 'stop', $instance['Instance']['id']), array('escape' => false, 'title' => __('Stop Instance'))),
								$this->Html->button(array('refresh', 'default', 'xs'), array('action' => 'cycle', $instance['Instance']['id']), array('escape' => false, 'title' => __('Restart Instance'))),
								$this->Html->button(array('list-alt', 'default', 'xs'), array('action' => 'instance_log', $instance['Instance']['id']), array('escape' => false, 'title' => __('Instance Log'))),
								$this->Html->postButton(array('asterisk', 'default', 'xs'), array('action' => 'reroll', $instance['Instance']['id']), array('escape' => false, 'title' => __('Reroll World')), __('Are you sure you want to reroll the world on # %s?', $instance['Instance']['id'])),
								$this->Html->postButton(array('star', 'default', 'xs'), array('action' => 'spawn', $instance['Instance']['id']), array('escape' => false, 'title' => __('Respawn Instance')), __('Are you sure you want to respawn the instance on # %s?', $instance['Instance']['id'])),
								$this->Html->button(array('pencil', 'default', 'xs'), array('action' => 'edit', $instance['Instance']['id']), array('escape' => false, 'title' => __('Edit Instance'))),
								$this->Html->button(array('cog', 'default', 'xs'), array('controller' => 'instance_profiles', 'action' => 'edit', $instance['Instance']['instance_profile_id']), array('escape' => false, 'title' => __('Edit Instance Profile'))),
								$this->Html->postButton(array('trash', 'default', 'xs'), array('action' => 'delete', $instance['Instance']['id']), array('escape' => false, 'title' => __('Delete Instance')), __('Are you sure you want to delete # %s?', $instance['Instance']['id']))
							)	
						);
					?>
				</td>
			</tr>
			<?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->element('paging'); ?>
</div>
<?php echo $this->element('add_button'); ?>