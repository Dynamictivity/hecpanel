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

// Todo: move to config
echo $this->Form->create('User', array(
	'class' => 'well form-horizontal'
));
?>
<fieldset>
	<pre>
<?php echo Configure::read(APP_CONFIG_SCOPE . '.App.eula'); ?>
	</pre>
</fieldset>
<?php if (AuthComponent::user('id') && !AuthComponent::user('eula_accepted')): ?>
<div class="form-group">
    <?php echo $this->Form->submit(__('I Accept and Agree to The Terms and Conditions Outlined Above'), Configure::read('Bootstrap.formButtonStyle')); ?>
</div>
<p><center><?php echo $this->Html->link(__('I don\'t agree, log me out!'), array('controller' => 'users', 'action' => 'logout', 'plugin' => false, 'admin' => false)); ?></center></p>
<?php endif; ?>
<?php echo $this->Form->end(); ?>