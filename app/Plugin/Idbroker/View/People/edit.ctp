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

<div class="users form">
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Edit User');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('group_id');
	?>
    </fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('User.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), array('action'=>'index'));?></li>
        <li><?php echo $this->Html->link(__('List Groups'), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Group'), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
    </ul>
</div>
<pre><?php print_r($this);?></pre>
