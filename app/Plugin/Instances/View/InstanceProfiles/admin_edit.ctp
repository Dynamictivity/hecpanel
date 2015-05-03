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
echo $this->Form->create('InstanceProfile', array(
	'class' => 'well form-horizontal'
));
?>
<fieldset>
	<legend><?php echo __('Admin Edit Instance Profile'); ?></legend>
	<?php
	echo $this->Form->input('id');
	echo $this->Form->input('name');
	echo $this->Form->input('user_id');
	echo $this->Form->input('game_mode');
	echo $this->Form->input('inventory_size_multiplier');
	echo $this->Form->input('assembler_speed_multiplier');
	echo $this->Form->input('assembler_efficiency_multiplier');
	echo $this->Form->input('refinery_speed_multiplier');
	echo $this->Form->input('online_mode');
	echo $this->Form->input('max_floating_objects');
	echo $this->Form->input('environment_hostility');
	echo $this->Form->input('auto_healing');
	echo $this->Form->input('enable_copy_paste');
	echo $this->Form->input('auto_save');
	echo $this->Form->input('weapons_enabled');
	echo $this->Form->input('show_player_names_on_hud');
	echo $this->Form->input('thruster_damage');
	echo $this->Form->input('cargo_ships_enabled');
	echo $this->Form->input('enable_spectator');
	echo $this->Form->input('remove_trash');
	echo $this->Form->input('world_size_km');
	echo $this->Form->input('respawn_ship_delete');
	echo $this->Form->input('reset_ownership');
	echo $this->Form->input('welder_speed_multiplier');
	echo $this->Form->input('grinder_speed_multiplier');
	echo $this->Form->input('realistic_sound');
	echo $this->Form->input('client_can_save');
	echo $this->Form->input('hack_speed_multiplier');
	echo $this->Form->input('permanent_death');
	echo $this->Form->input('spawn_ship_time_multiplier');
	echo $this->Form->input('procedural_density');
	echo $this->Form->input('procedural_seed');
	echo $this->Form->input('destructible_blocks');
	echo $this->Form->input('enable_ingame_scripts');
	echo $this->Form->input('enable_oxygen');
	echo $this->Form->input('view_distance');
	echo $this->Form->input('scenario_subtype_id');
	echo $this->Form->input('asteroid_amount');
	?>
</fieldset>
<div class="form-group">
	<?php echo $this->Form->submit(__('Submit'), Configure::read('Bootstrap.formButtonStyle')); ?>
</div>
<?php echo $this->Form->end(); ?>