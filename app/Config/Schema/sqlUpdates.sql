ALTER TABLE `instances` ADD `game_id` INT NOT NULL AFTER `host_server_id`;
ALTER TABLE `instance_profiles` ADD `profile_settings` TEXT NOT NULL AFTER `user_id`;
ALTER TABLE `instance_types` ADD `profile_settings` TEXT NOT NULL AFTER `name`;
ALTER TABLE `instance_profiles` ADD `game_id` INT NOT NULL AFTER `user_id`;
ALTER TABLE `instance_types` ADD `game_id` INT NOT NULL AFTER `name`;

DROP TABLE IF EXISTS `configurations`;
CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `configuration_scope` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO `configurations` (`id`, `name`, `configuration_scope`, `role_id`, `value`, `created`, `updated`) VALUES
(1, 'apiKey', 'Hecpanel.App', NULL, 'xPqYzu4RYlBpPTdxH9DaYnO9abLTPEUG', '2015-02-01 09:44:31', '2015-02-01 09:44:31'),
(2, 'apiSecret', 'Hecpanel.App', NULL, 'TGGEMKzLRG1L9DDRwWRpCeEHL6w87v0bJVayDUi2', '2015-02-01 09:44:47', '2015-02-01 09:44:47'),
(3, 'serviceAdminId', 'Hecpanel.App', NULL, '53eef38e-c88c-4f8a-bd9a-09948468e7ff', '2015-02-03 08:10:48', '2015-02-03 08:10:48'),
(4, 'allowedActions', 'Hecpanel.Controller.InstanceProfiles', 3, 'edit,add,delete,index,duplicate', '2014-11-11 09:42:38', '2015-05-03 04:29:32'),
(5, 'allowedActions', 'Hecpanel.Controller.Instances', 3, 'index,start,stop,cycle,check,add,edit,reroll,instance_log', '2014-11-11 09:27:36', '2014-11-17 00:31:34'),
(6, 'allowedActions', 'Hecpanel.Controller.Users', 3, 'edit', '2014-11-29 11:28:32', '2014-11-29 11:28:32'),
(7, 'prohibitedFields', 'Hecpanel.Form.InstanceProfile', NULL, 'server_port,server_name,world_name,group_id,load_world,pause_game_when_empty,ignore_last_session,auto_save_in_minutes,max_players,online_mode', '2015-05-14 09:14:13', '2015-05-14 09:36:32'),
(8, 'appUrl', 'Hecpanel.App', NULL, 'http://demo.hecpanel.com', '2015-05-14 09:46:05', '2015-05-14 09:46:05'),
(9, 'appName', 'Hecpanel.App', NULL, 'HEcPanel', '2015-05-14 09:46:35', '2015-05-14 09:46:35'),
(10, 'environment', 'Hecpanel.App', NULL, 'DEV', '2015-05-14 09:47:00', '2015-05-14 09:47:00'),
(11, 'googleAnalyticsId', 'Hecpanel.App', NULL, 'UA-5187184-20', '2015-05-14 09:47:58', '2015-05-14 09:47:58'),
(12, 'allowedActions', 'Hecpanel.Controller.Users', NULL, 'signup,confirm,logout,login,forgot,reset,eula', '2015-05-14 09:49:24', '2015-05-14 09:49:24'),
(13, 'newAccountSubject', 'Hecpanel.Email', NULL, 'Welcome to the Hosting Engineers Control Panel', '2015-05-14 09:50:00', '2015-05-14 09:50:00'),
(14, 'newInstanceSubject', 'Hecpanel.Email', NULL, 'Your Hosting Engineers Server Instance is Created', '2015-05-14 09:50:18', '2015-05-14 09:50:18'),
(15, 'resetAccountSubject', 'Hecpanel.Email', NULL, 'Reset Your Hosting Engineers Control Panel Password', '2015-05-14 09:50:34', '2015-05-14 09:50:34'),
(16, 'defaultRoleId', 'Hecpanel.Users', NULL, '4', '2015-05-14 09:51:18', '2015-05-14 09:51:18'),
(17, 'confirmedRoleId', 'Hecpanel.Users', NULL, '3', '2015-05-14 09:51:36', '2015-05-14 09:51:36');

ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;

/* Run this after conversion */
ALTER TABLE `instance_profiles`
  DROP `game_mode`,
  DROP `inventory_size_multiplier`,
  DROP `assembler_speed_multiplier`,
  DROP `assembler_efficiency_multiplier`,
  DROP `refinery_speed_multiplier`,
  DROP `online_mode`,
  DROP `max_floating_objects`,
  DROP `environment_hostility`,
  DROP `auto_healing`,
  DROP `enable_copy_paste`,
  DROP `auto_save`,
  DROP `weapons_enabled`,
  DROP `show_player_names_on_hud`,
  DROP `thruster_damage`,
  DROP `cargo_ships_enabled`,
  DROP `enable_spectator`,
  DROP `remove_trash`,
  DROP `world_size_km`,
  DROP `respawn_ship_delete`,
  DROP `reset_ownership`,
  DROP `welder_speed_multiplier`,
  DROP `grinder_speed_multiplier`,
  DROP `realistic_sound`,
  DROP `client_can_save`,
  DROP `hack_speed_multiplier`,
  DROP `permanent_death`,
  DROP `spawn_ship_time_multiplier`,
  DROP `procedural_density`,
  DROP `procedural_seed`,
  DROP `destructible_blocks`,
  DROP `enable_ingame_scripts`,
  DROP `enable_oxygen`,
  DROP `view_distance`,
  DROP `scenario_subtype_id`;

ALTER TABLE `instance_types`
  DROP `game_mode`,
  DROP `inventory_size_multiplier`,
  DROP `assembler_speed_multiplier`,
  DROP `assembler_efficiency_multiplier`,
  DROP `refinery_speed_multiplier`,
  DROP `online_mode`,
  DROP `max_players`,
  DROP `max_floating_objects`,
  DROP `environment_hostility`,
  DROP `auto_healing`,
  DROP `enable_copy_paste`,
  DROP `auto_save`,
  DROP `weapons_enabled`,
  DROP `show_player_names_on_hud`,
  DROP `thruster_damage`,
  DROP `cargo_ships_enabled`,
  DROP `enable_spectator`,
  DROP `remove_trash`,
  DROP `world_size_km`,
  DROP `respawn_ship_delete`,
  DROP `reset_ownership`,
  DROP `welder_speed_multiplier`,
  DROP `grinder_speed_multiplier`,
  DROP `realistic_sound`,
  DROP `client_can_save`,
  DROP `hack_speed_multiplier`,
  DROP `permanent_death`,
  DROP `auto_save_in_minutes`,
  DROP `spawn_ship_time_multiplier`,
  DROP `procedural_density`,
  DROP `procedural_seed`,
  DROP `destructible_blocks`,
  DROP `enable_ingame_scripts`,
  DROP `enable_oxygen`,
  DROP `view_distance`,
  DROP `scenario_subtype_id`,
  DROP `asteroid_amount`,
  DROP `pause_game_when_empty`,
  DROP `ignore_last_session`;