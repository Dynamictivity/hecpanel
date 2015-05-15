-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2015 at 09:33 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hecpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cake_sessions`
--

CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `command_queues`
--

CREATE TABLE IF NOT EXISTS `command_queues` (
  `id` int(11) NOT NULL,
  `command` varchar(255) NOT NULL,
  `host_server_id` varchar(36) DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `time` time NOT NULL DEFAULT '00:00:00',
  `is_once_per_day` tinyint(1) NOT NULL DEFAULT '0',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `last_executed` datetime DEFAULT NULL,
  `last_executed_host_server_id` varchar(36) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `command_queues`
--

INSERT INTO `command_queues` (`id`, `command`, `host_server_id`, `is_recurring`, `time`, `is_once_per_day`, `is_enabled`, `last_executed`, `last_executed_host_server_id`, `created`, `updated`) VALUES
(1, 'checkForUpdates', '554711b5-9254-49bb-a8c3-114c3924d99f', 1, '00:00:00', 0, 1, '2015-05-15 00:08:10', '554711b5-9254-49bb-a8c3-114c3924d99f', '2015-05-04 08:29:31', '2015-05-11 08:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `configuration_scope` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `name`, `configuration_scope`, `role_id`, `value`, `created`, `updated`) VALUES
(1, 'apiKey', 'Hecpanel.App', NULL, 'xPqYzu4RYlBpPTdxH9DaYnO9abLTPEUG', '2015-02-01 09:44:31', '2015-02-01 09:44:31'),
(2, 'apiSecret', 'Hecpanel.App', NULL, 'TGGEMKzLRG1L9DDRwWRpCeEHL6w87v0bJVayDUi2', '2015-02-01 09:44:47', '2015-02-01 09:44:47'),
(3, 'serviceAdminId', 'Hecpanel.App', NULL, '53eef38e-c88c-4f8a-bd9a-09948468e7ff', '2015-02-03 08:10:48', '2015-02-03 08:10:48'),
(4, 'allowedActions', 'Hecpanel.Controller.InstanceProfiles', 3, 'edit,add,delete,index,duplicate', '2014-11-11 09:42:38', '2015-05-03 04:29:32'),
(5, 'allowedActions', 'Hecpanel.Controller.Instances', 3, 'index,start,stop,cycle,check,add,edit,reroll,instance_log', '2014-11-11 09:27:36', '2014-11-17 00:31:34'),
(6, 'allowedActions', 'Hecpanel.Controller.Users', 3, 'edit', '2014-11-29 11:28:32', '2014-11-29 11:28:32'),
(7, 'prohibitedFields', 'Hecpanel.Form.InstanceProfile', NULL, 'name,game_id,server_admins,user_id,server_port,server_name,world_name,group_id,load_world,pause_game_when_empty,ignore_last_session,auto_save_in_minutes,max_players,online_mode,created,updated', '2015-05-14 09:14:13', '2015-05-15 08:54:50'),
(8, 'appUrl', 'Hecpanel.App', NULL, 'http://demo.hecpanel.com', '2015-05-14 09:46:05', '2015-05-14 09:46:05'),
(9, 'appName', 'Hecpanel.App', NULL, 'HEcPanel', '2015-05-14 09:46:35', '2015-05-14 09:46:35'),
(10, 'environment', 'Hecpanel.App', NULL, 'DEV', '2015-05-14 09:47:00', '2015-05-14 09:47:00'),
(11, 'googleAnalyticsId', 'Hecpanel.App', NULL, 'UA-5187184-20', '2015-05-14 09:47:58', '2015-05-14 09:47:58'),
(12, 'allowedActions', 'Hecpanel.Controller.Users', NULL, 'signup,confirm,logout,login,forgot,reset,eula', '2015-05-14 09:49:24', '2015-05-14 09:49:24'),
(13, 'newAccountSubject', 'Hecpanel.Email', NULL, 'Welcome to the Hosting Engineers Control Panel', '2015-05-14 09:50:00', '2015-05-14 09:50:00'),
(14, 'newInstanceSubject', 'Hecpanel.Email', NULL, 'Your Hosting Engineers Server Instance is Created', '2015-05-14 09:50:18', '2015-05-14 09:50:18'),
(15, 'resetAccountSubject', 'Hecpanel.Email', NULL, 'Reset Your Hosting Engineers Control Panel Password', '2015-05-14 09:50:34', '2015-05-14 09:50:34'),
(16, 'defaultRoleId', 'Hecpanel.Users', NULL, '4', '2015-05-14 09:51:18', '2015-05-14 09:51:18'),
(17, 'confirmedRoleId', 'Hecpanel.Users', NULL, '3', '2015-05-14 09:51:36', '2015-05-14 09:51:36'),
(18, 'prohibitedFields', 'Hecpanel.Form.InstanceType', NULL, 'name,game_id,load_world,server_port,server_admins,group_id,server_name,world_name,created,updated', '2015-05-15 08:20:09', '2015-05-15 09:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `host_servers`
--

CREATE TABLE IF NOT EXISTS `host_servers` (
  `id` varchar(36) NOT NULL,
  `servername` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `instance_count` int(11) NOT NULL DEFAULT '0',
  `instance_limit` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instances`
--

CREATE TABLE IF NOT EXISTS `instances` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `host_server_id` varchar(36) NOT NULL,
  `game_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `server_admins` text NOT NULL,
  `mods` text NOT NULL,
  `port` int(11) NOT NULL,
  `instance_profile_id` varchar(36) NOT NULL,
  `instance_type_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instance_profiles`
--

CREATE TABLE IF NOT EXISTS `instance_profiles` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `game_id` int(11) NOT NULL,
  `profile_settings` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instance_types`
--

CREATE TABLE IF NOT EXISTS `instance_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  `profile_settings` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instance_types`
--

INSERT INTO `instance_types` (`id`, `name`, `game_id`, `profile_settings`, `created`, `updated`) VALUES
(1, 'Small Server', 0, '{"game_mode":"Survival","inventory_size_multiplier":"1","assembler_speed_multiplier":"1","assembler_efficiency_multiplier":"1","refinery_speed_multiplier":"1","online_mode":"PUBLIC","max_players":"1","max_floating_objects":"0","environment_hostility":"SAFE","auto_healing":"true","enable_copy_paste":"true","auto_save":"true","weapons_enabled":"true","show_player_names_on_hud":"true","thruster_damage":"true","cargo_ships_enabled":"false","enable_spectator":"true","remove_trash":"true","world_size_km":"0","respawn_ship_delete":"true","reset_ownership":"true","welder_speed_multiplier":"1","grinder_speed_multiplier":"1","realistic_sound":"true","client_can_save":"true","hack_speed_multiplier":"1","permanent_death":"true","auto_save_in_minutes":"15","spawn_ship_time_multiplier":"0","procedural_density":"0","procedural_seed":"0","destructible_blocks":"true","enable_ingame_scripts":"true","enable_oxygen":"true","view_distance":"1000","scenario_subtype_id":"EasyStart1","asteroid_amount":"0","pause_game_when_empty":"true","ignore_last_session":"true","enable_tool_shake":"true","enable_3rd_person_view":"true","enable_encounters":"true"}', '2014-11-02 12:23:14', '2015-05-15 09:31:14'),
(2, 'Medium Server', 0, '{"game_mode":"Survival","inventory_size_multiplier":"1","assembler_speed_multiplier":"1","assembler_efficiency_multiplier":"1","refinery_speed_multiplier":"1","online_mode":"PUBLIC","max_players":"10","max_floating_objects":"255","environment_hostility":"SAFE","auto_healing":"true","enable_copy_paste":"false","auto_save":"true","weapons_enabled":"true","show_player_names_on_hud":"true","thruster_damage":"true","cargo_ships_enabled":"false","enable_spectator":"false","remove_trash":"true","world_size_km":"20","respawn_ship_delete":"true","reset_ownership":"false","welder_speed_multiplier":"1","grinder_speed_multiplier":"1","realistic_sound":"false","client_can_save":"true","hack_speed_multiplier":"1","permanent_death":"true","auto_save_in_minutes":"15","spawn_ship_time_multiplier":"1","procedural_density":"0","procedural_seed":"0","destructible_blocks":"true","enable_ingame_scripts":"true","enable_oxygen":"true","view_distance":"2000","scenario_subtype_id":"EasyStart1","asteroid_amount":"10","pause_game_when_empty":"true","ignore_last_session":"false","enable_tool_shake":"true","enable_3rd_person_view":"true","enable_encounters":"true"}', '2014-11-02 12:23:14', '2015-05-15 09:18:43'),
(3, 'Large Server', 0, '{"game_mode":"Survival","inventory_size_multiplier":"1","assembler_speed_multiplier":"1","assembler_efficiency_multiplier":"1","refinery_speed_multiplier":"1","online_mode":"PUBLIC","max_players":"15","max_floating_objects":"255","environment_hostility":"SAFE","auto_healing":"true","enable_copy_paste":"false","auto_save":"true","weapons_enabled":"true","show_player_names_on_hud":"true","thruster_damage":"true","cargo_ships_enabled":"false","enable_spectator":"false","remove_trash":"true","world_size_km":"20","respawn_ship_delete":"true","reset_ownership":"false","welder_speed_multiplier":"1","grinder_speed_multiplier":"1","realistic_sound":"false","client_can_save":"true","hack_speed_multiplier":"1","permanent_death":"true","auto_save_in_minutes":"15","spawn_ship_time_multiplier":"1","procedural_density":"0","procedural_seed":"0","destructible_blocks":"true","enable_ingame_scripts":"true","enable_oxygen":"true","view_distance":"2000","scenario_subtype_id":"EasyStart1","asteroid_amount":"10","pause_game_when_empty":"true","ignore_last_session":"false","enable_tool_shake":"true","enable_3rd_person_view":"true","enable_encounters":"true"}', '2014-11-02 12:23:14', '2015-05-15 09:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Support'),
(3, 'Customer'),
(4, 'Unconfirmed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `desired_product_id` int(11) DEFAULT NULL,
  `eula_accepted` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `token`, `role_id`, `desired_product_id`, `eula_accepted`, `created`, `updated`) VALUES
('53eef38e-c88c-4f8a-bd9a-09948468e7ff', 'hecadmin', 'HEcPanel', 'Admin', 'hecadmin@hecpanel.com', '$2a$10$hohTkjmui./ZWUInZHdPIuUzjthMzbM4c9gssXqq5Wm03XWGHrvMG', NULL, 1, NULL, 1, '2014-08-16 08:00:46', '2015-05-03 02:22:35'),
('53ef1f4c-e420-4acc-8136-1cc86ca18129', 'hecuser', 'HEcPanel', 'User', 'hecuser@hecpanel.com', '$2a$10$2HqNTY8T6tPXsuB1dAoGYuBROO5vKTmeino5qlm8gC/Tn6TxvPB8.', NULL, 3, NULL, 1, '2014-08-16 11:07:24', '2015-05-03 02:22:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cake_sessions`
--
ALTER TABLE `cake_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `command_queues`
--
ALTER TABLE `command_queues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_servers`
--
ALTER TABLE `host_servers`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instance_profiles`
--
ALTER TABLE `instance_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instance_types`
--
ALTER TABLE `instance_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `command_queues`
--
ALTER TABLE `command_queues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `instance_types`
--
ALTER TABLE `instance_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;