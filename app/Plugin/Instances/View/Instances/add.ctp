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
	<legend><?php echo __('Add Instance') . ' ' . $product['Product']['name']; ?></legend>
	<?php
	echo $this->Form->input('name');
	?>
	<ul class="list-group">
		<?php foreach ($instanceType as $key => $value) : ?>
		<li class="list-group-item"><strong><?php echo Inflector::humanize($key); ?>:</strong> <?php echo $value; ?></li>
		<?php endforeach; ?>
	</ul>
</fieldset>
<div class="form-group">
	<?php echo $this->Form->submit(__('Submit'), Configure::read('Bootstrap.formButtonStyle')); ?>
</div>
<?php echo $this->Form->end(); ?>