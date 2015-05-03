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
		'div' => false,
		'label' => false,
		'wrapInput' => false
	),
	'class' => 'well form-inline'
)); ?>
	<?php echo $this->Form->input('email', array(
		'class' => 'input-small',
		'placeholder' => 'Email'
	)); ?>
	<?php echo $this->Form->input('password', array(
		'class' => 'input-small',
		'placeholder' => 'Password'
	)); ?>
	<?php echo $this->Form->input('remember', array(
		'label' => array(
			'text' => 'Remember me',
			'class' => 'checkbox'
		),
		'checkboxDiv' => false
	)); ?>
	<?php echo $this->Form->submit('Sign in', array(
		'div' => false,
		'class' => 'btn'
	)); ?>
<?php echo $this->Form->end(); ?>