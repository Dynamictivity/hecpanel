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
$config = array(
	APP_CONFIG_SCOPE => array(
		'Instances' => array(
//			'serverArchiveDirectory' => 'SERVER_ARCHIVES',
			'serverBinariesDirectory' => 'SERVER_BINARIES',
			'serverDataSkeletonDirectory' => 'SERVER_SKELETON',
			'games' => array(
				array(
					'name' => 'Space Engineers',
					'folder' => 'SPACE_ENGINEERS',
					'config' => 'SpaceEngineers-Dedicated.cfg',
					'dedicatedBinary' => 'SpaceEngineersDedicated.exe',
					'sourceBinariesDirectory' => 'C:' . DS . 'Program Files (x86)' . DS . 'Steam' . DS . 'SteamApps' . DS . 'common' . DS . 'SpaceEngineers',
					'configKeys' => array('game_mode', 'inventory_size_multiplier', 'assembler_speed_multiplier', 'assembler_efficiency_multiplier', 'refinery_speed_multiplier', 'online_mode', 'max_players', 'max_floating_objects', 'environment_hostility', 'auto_healing', 'enable_copy_paste', 'auto_save', 'weapons_enabled', 'show_player_names_on_hud', 'thruster_damage', 'cargo_ships_enabled', 'enable_spectator', 'remove_trash', 'world_size_km', 'respawn_ship_delete', 'reset_ownership', 'welder_speed_multiplier', 'grinder_speed_multiplier', 'realistic_sound', 'client_can_save', 'hack_speed_multiplier', 'permanent_death', 'auto_save_in_minutes', 'spawn_ship_time_multiplier', 'procedural_density', 'procedural_seed', 'destructible_blocks', 'enable_ingame_scripts', 'enable_oxygen', 'view_distance', 'scenario_subtype_id', 'load_world', 'server_port', 'asteroid_amount', 'server_admins', 'group_id', 'server_name', 'world_name', 'pause_game_when_empty', 'ignore_last_session', 'enable_tool_shake', 'enable_3rd_person_view', 'enable_encounters'),
					'configOptions' => array(
						'gameModes' => array(
							'Survival' => 'Survival',
							'Creative' => 'Creative'
						),
						'onlineModes' => array(
							'PUBLIC' => 'PUBLIC',
							'PRIVATE' => 'PRIVATE'
						),
						'environmentHostilities' => array(
							'SAFE' => 'SAFE',
							'NORMAL' => 'NORMAL',
							'CATACLYSM' => 'CATACLYSM',
							'CATACLYSM_UNREAL' => 'CATACLYSM_UNREAL'
						),
						'autoHealings' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableCopyPastes' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'autoSaves' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'weaponsEnableds' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'showPlayerNamesOnHuds' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'thrusterDamages' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'cargoShipsEnableds' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableSpectators' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'removeTrashes' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'respawnShipDeletes' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'resetOwnerships' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'realisticSounds' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'clientCanSaves' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'permanentDeaths' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'pauseGameWhenEmpties' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'ignoreLastSessions' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'destructibleBlocks' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableIngameScripts' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableOxygens' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableToolShakes' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enable3rdPersonViews' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableEncounters' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'scenarioSubtypes' => array(
							'EasyStart1' => 'EasyStart1',
							'EasyStart2' => 'EasyStart2',
							'Survival' => 'Survival',
							'CrashedRedShip' => 'CrashedRedShip',
							'TwoPlatforms' => 'TwoPlatforms',
							'Asteroids' => 'Asteroids',
							'EmptyWorld' => 'EmptyWorld',
						),
						'inventorySizeMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'assemblerSpeedMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'assemblerEfficiencyMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'refinerySpeedMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'maxPlayers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'maxFloatingObjects' => array_combine(range(0, 500, 1), range(0, 500, 1)), // 0-500, increment of 1
						'worldSizeKms' => array_combine(range(0, 500, 1), range(0, 500, 1)), // 0-500, increment of 1
						'welderSpeedMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'grinderSpeedMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'hackSpeedMultipliers' => array_combine(range(.2, 100, .2), range(.2, 100, .2)), // .2-100, increment of .2
						'autoSaveInMinutes' => array_combine(range(15, 90, 15), range(15, 90, 15)), // 15-90, increment of 15
						'spawnShipTimeMultipliers' => array_combine(range(0, 20, 1), range(0, 20, 1)), // 0-20, increment of 1
						'asteroidAmounts' => array_combine(range(0, 10, 1), range(0, 10, 1)), // 0-10, increment of 1
						'proceduralDensities' => array_combine(range(0, 1, .05), range(0, 1, .05)), // 0-1, increment of .05
						'viewDistances' => array_combine(range(1000, 30000, 1000), range(1000, 30000, 1000)), // 1000-30000, increment of 1000
					),
				),
				array(
					'name' => 'Medieval Engineers',
					'folder' => 'MEDIEVAL_ENGINEERS',
					'config' => 'MedievalEngineers-Dedicated.cfg',
					'dedicatedBinary' => 'MedievalEngineersDedicated.exe',
					'sourceBinariesDirectory' => 'C:' . DS . 'Program Files (x86)' . DS . 'Steam' . DS . 'SteamApps' . DS . 'common' . DS . 'MedievalEngineers',
					'configKeys' => array('enable_structural_simulation', 'enable_barbarians', 'max_active_fracture_pieces', 'game_day_in_real_minutes', 'day_night_ratio', 'enable_animals', 'maximum_bots', 'game_mode', 'max_players', 'enable_spectator', 'client_can_save', 'auto_save_in_minutes', 'scenario_subtype_id', 'load_world', 'server_port', 'server_admins', 'group_id', 'server_name', 'world_name', 'pause_game_when_empty', 'ignore_last_session'),
					'configOptions' => array(
						'gameModes' => array(
							'Survival' => 'Survival',
							'Creative' => 'Creative'
						),
						'clientCanSaves' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'pauseGameWhenEmpties' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'ignoreLastSessions' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableStructuralSimulations' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableBarbarians' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableAnimals' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'enableSpectators' => array(
							'true' => 'true',
							'false' => 'false'
						),
						'scenarioSubtypes' => array(
							'Quickstart' => 'Quickstart',
							'PreviewDestructionM' => 'PreviewDestructionMap',
							'Plains' => 'Plains',
							'Castle' => 'Castle',
							'Bridges' => 'Bridges',
							'LargeTerrain' => 'LargeTerrain',
							'NormalTerrain' => 'NormalTerrain',
							'SmallTerrain' => 'SmallTerrain',
							'VerySmallTerrain' => 'VerySmallTerrain',
						),
						'maxActiveFracturePieces' => array_combine(range(100, 1000, 100), range(100, 1000, 100)), // 100-1000, increment of 100
						'gameDayInRealMinutes' => array_combine(range(1, 200, 1), range(1, 200, 1)), // 1-200, increment of 1
						'dayNightRatios' => array_combine(range(.1, 1, .1), range(.1, 1, .1)), // .1-1, increment of .1
						'maxPlayers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
						'autoSaveInMinutes' => array_combine(range(15, 90, 15), range(15, 90, 15)), // 15-90, increment of 15
						'maximumBots' => array_combine(range(1, 20, 1), range(1, 20, 1)), // 1-20, increment of 1
					),
				),
			)
		)
	)
);
