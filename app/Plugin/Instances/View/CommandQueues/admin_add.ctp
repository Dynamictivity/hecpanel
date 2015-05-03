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

echo $this->Form->create('CommandQueue', array(
	'class' => 'well form-horizontal'
));
?>
<fieldset>
    <legend><?php echo __('Admin Add Queued Command'); ?></legend>
	<?php
	echo $this->Form->input('command');
	echo $this->Form->input('host_server_id', array('empty' => 'All Host Servers'));
	echo $this->Form->input('is_enabled', array(
		'wrapInput' => 'col col-md-3 col-md-offset-3',
		'label' => 'Enabled',
		'class' => false,
		'type' => 'checkbox'
	));
	echo $this->Form->input('is_recurring', array(
		'wrapInput' => 'col col-md-3 col-md-offset-3',
		'label' => 'Recurring',
		'class' => false,
		'type' => 'checkbox'
	));
	// TODO: Make cleaner
	echo '<hr class="devlog" />';
	echo '<div class="row"><p><em>&nbsp;&nbsp;&nbsp;The following options only work with a single host server selected</em></p></div>';
	echo $this->Form->input('time', array('type' => 'text', 'label' => 'Time or Interval'));
	echo $this->Form->input('is_once_per_day', array(
		'wrapInput' => 'col col-md-3 col-md-offset-3',
		'label' => 'Once Per Day',
		'class' => false,
		'type' => 'checkbox'
	));
	echo '<hr class="devlog" />';
	?>
</fieldset>
<div class="form-group">
	<?php echo $this->Form->submit(__('Submit'), Configure::read('Bootstrap.formButtonStyle')); ?>
</div>
<?php echo $this->Form->end(); ?>