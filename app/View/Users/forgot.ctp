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
	));
	?>
    <fieldset>
        <legend><?php echo __('Reset Account'); ?></legend>
		<?php
		echo $this->Form->input('email', array(
			'placeholder' => 'e-mail address'
		));
		?>
    </fieldset>
    <div class="form-group">
		<?php
		echo $this->Form->submit('Reset Account', array(
			'div' => 'col col-md-6 col-md-offset-3',
			'class' => 'btn btn-default'
		));
		?>
    </div>
	<?php echo $this->Form->end(); ?>
</div>