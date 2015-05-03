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

<div class="col col-md-6">
	<?php
	echo $this->Form->create('User', array(
		'inputDefaults' => array(
			'div' => 'form-group',
			'label' => array(
				'class' => 'col col-md-3 control-label'
			),
			'class' => 'form-control'
		),
		'class' => 'well form-horizontal',
		'action' => 'signup'
	));
	?>
    <fieldset>
        <legend><?php echo __('Sign Up'); ?></legend>
		<?php
		echo $this->Form->input('username');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('password_confirmation', array('type' => 'password'));
		?>
    </fieldset>
    <div class="form-group">
		<?php echo $this->Form->submit(__('Submit'), Configure::read('Bootstrap.formButtonStyle')); ?>
    </div>
	<?php echo $this->Form->end(); ?>
</div>

<div class="col col-md-6">
	<?php
	echo $this->Form->create('User', array(
		'inputDefaults' => array(
			'div' => 'form-group',
			'label' => array(
				'class' => 'col col-md-3 control-label'
			),
			'class' => 'form-control'
		),
		'class' => 'well form-horizontal',
		'action' => 'login'
	));
	?>
    <fieldset>
        <legend><?php echo __('Sign In'); ?></legend>
		<?php
		echo $this->Form->input('username', array(
			'placeholder' => 'Username',
			'autofocus' => 'autofocus'
		));
		?>
		<?php
		echo $this->Form->input('password', array(
			'placeholder' => 'Password'
		));
		?>
        <span class="pull-right"><?php echo $this->Html->link(__('Forgot password?'), array('action' => 'forgot')); ?></span>
        <!--<?php
		echo $this->Form->input('remember', array(
			'wrapInput' => 'col col-md-6 col-md-offset-3',
			'label' => 'Remember me',
			'class' => false,
			'type' => 'checkbox'
		));
		?>-->
    </fieldset>
    <div class="form-group">
		<?php
		echo $this->Form->submit('Sign In', array(
			'div' => 'col col-md-6 col-md-offset-3',
			'class' => 'btn btn-default'
		));
		?>
    </div>
	<?php echo $this->Form->end(); ?>
</div>
