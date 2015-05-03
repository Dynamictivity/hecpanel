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

<?php
echo $this->Form->create('Instance', array(
	'class' => 'well form-horizontal'
));
?>
<fieldset>
	<legend><?php echo __('Edit Instance') . ' (' . $this->request->data['Instance']['id'] . ')'; ?></legend>
	<?php
	echo $this->Form->input('id');
	echo $this->Form->input('name');
	echo $this->Form->input('group_id', array('type' => 'text', 'label' => 'Group ID'));
	echo $this->Form->input('server_admins');
	echo $this->Form->input('mods');
	echo $this->Form->input('instance_profile_id');
	?>
</fieldset>
<div class="col col-md-2 col-md-offset-10">
	<?php echo $this->Html->button(array('cog', 'default', 'xl'), array('controller' => 'instance_profiles', 'action' => 'edit', $this->request->data['Instance']['instance_profile_id']), array('escape' => false, 'title' => __('Edit Instance Profile'))); ?> <?php echo __('Edit Profile'); ?>
</div>
<hr class="devlog" />
<div class="form-group">
	<?php echo $this->Form->submit(__('Submit'), Configure::read('Bootstrap.formButtonStyle')); ?>
</div>
<?php echo $this->Form->end(); ?>
<div class="row"><span class="pull-right"</span>
	<?php
		echo $this->Form->postLink('<i class="fa fa-retweet"></i>&nbsp;&nbsp;&nbsp;' . __('Re-generate World'), array('action' => 'reroll', $this->data['Instance']['id']), array('escape' => false, 'title' => __('Re-generate World')), __('Are you sure you want to re-generate the world on # %s?', $this->data['Instance']['id']));
	?>
</span></div>