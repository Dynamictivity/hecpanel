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

<div class="groups view">
    <h2><?php echo __('Group');?></h2>
    <dl><?php $i = 0; $class = ' class="altrow"';?>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name Name'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['cn']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Group ID Number'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['gidnumber']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['description']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Members'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
			<?php
				if(is_array($group['Group']['uniquemember'])){
					foreach($group['Group']['uniquemember'] as $member){
						echo "<li><b>Member DN:</b> $member </li>";
					}
				}else{
					echo "<li><b>Member DN:</b> ".$group['Group']['uniquemember']."</li>";
				}
				
				if(is_array($group['Group']['memberuid'])){
					foreach($group['Group']['memberuid'] as $member){
						echo "<li><b>Member UID:</b>  $member </li>";
					}
				}else{
					echo "<li><b>Member UID:</b> ".$group['Group']['memberuid']."</li>";
				}
				
			
			?></ul>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Edit Group'), array('action'=>'edit', $group['Group']['uid'])); ?> </li>
        <li><?php echo $this->Html->link(__('Delete Group'), array('action'=>'delete', $group['Group']['uid']), null, sprintf(__('Are you sure you want to delete # %s?'), $group['Group']['uid'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Groups'), array('action'=>'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Group'), array('action'=>'add')); ?> </li>
    </ul>
</div>
