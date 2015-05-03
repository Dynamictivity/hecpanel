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

<?php echo $this->Form->create('BoostCake', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well'
)); ?>
	<fieldset>
		<legend>Legend</legend>
		<?php echo $this->Form->input('text', array(
			'label' => 'Label name',
			'placeholder' => 'Type something…',
			'after' => '<span class="help-block">Example block-level help text here.</span>'
		)); ?>
		<?php echo $this->Form->input('checkbox', array(
			'label' => 'Check me out',
			'class' => false
		)); ?>
		<?php echo $this->Form->submit('Submit', array(
			'div' => 'form-group',
			'class' => 'btn btn-default'
		)); ?>
	</fieldset>
<?php echo $this->Form->end(); ?>