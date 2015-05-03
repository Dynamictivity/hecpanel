-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2015 at 05:33 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `name`, `configuration_scope`, `role_id`, `value`, `created`, `updated`) VALUES
(1, 'apiKey', 'Hecpanel.App', NULL, 'xPqYzu4RYlBpPTdxH9DaYnO9abLTPEUG', '2015-02-01 09:44:31', '2015-02-01 09:44:31'),
(2, 'apiSecret', 'Hecpanel.App', NULL, 'TGGEMKzLRG1L9DDRwWRpCeEHL6w87v0bJVayDUi2', '2015-02-01 09:44:47', '2015-02-01 09:44:47'),
(3, 'serviceAdminId', 'Hecpanel.App', NULL, '53eef38e-c88c-4f8a-bd9a-09948468e7ff', '2015-02-03 08:10:48', '2015-02-03 08:10:48'),
(4, 'allowedActions', 'Hecpanel.Controller.InstanceProfiles', 3, 'edit,add,delete,index,duplicate', '2014-11-11 09:42:38', '2015-05-03 04:29:32'),
(5, 'allowedActions', 'Hecpanel.Controller.Instances', 3, 'index,start,stop,cycle,check,add,edit,reroll,instance_log', '2014-11-11 09:27:36', '2014-11-17 00:31:34'),
(6, 'allowedActions', 'Hecpanel.Controller.Users', 3, 'edit', '2014-11-29 11:28:32', '2014-11-29 11:28:32');

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
  `game_mode` varchar(255) NOT NULL,
  `inventory_size_multiplier` decimal(4,2) NOT NULL,
  `assembler_speed_multiplier` decimal(4,2) NOT NULL,
  `assembler_efficiency_multiplier` decimal(4,2) NOT NULL,
  `refinery_speed_multiplier` decimal(4,2) NOT NULL,
  `online_mode` varchar(255) NOT NULL,
  `max_floating_objects` int(11) NOT NULL,
  `environment_hostility` varchar(255) NOT NULL,
  `auto_healing` varchar(255) NOT NULL,
  `enable_copy_paste` varchar(255) NOT NULL,
  `auto_save` varchar(255) NOT NULL,
  `weapons_enabled` varchar(255) NOT NULL,
  `show_player_names_on_hud` varchar(255) NOT NULL,
  `thruster_damage` varchar(255) NOT NULL,
  `cargo_ships_enabled` varchar(255) NOT NULL,
  `enable_spectator` varchar(255) NOT NULL,
  `remove_trash` varchar(255) NOT NULL,
  `world_size_km` int(11) NOT NULL,
  `respawn_ship_delete` varchar(255) NOT NULL,
  `reset_ownership` varchar(255) NOT NULL,
  `welder_speed_multiplier` decimal(4,2) NOT NULL,
  `grinder_speed_multiplier` decimal(4,2) NOT NULL,
  `realistic_sound` varchar(255) NOT NULL,
  `client_can_save` varchar(255) NOT NULL,
  `hack_speed_multiplier` decimal(4,2) NOT NULL,
  `permanent_death` varchar(255) NOT NULL,
  `spawn_ship_time_multiplier` decimal(4,2) NOT NULL,
  `procedural_density` decimal(3,2) NOT NULL,
  `procedural_seed` bigint(20) NOT NULL,
  `destructible_blocks` varchar(255) NOT NULL,
  `enable_ingame_scripts` varchar(255) NOT NULL,
  `enable_oxygen` varchar(255) NOT NULL,
  `view_distance` int(11) NOT NULL,
  `scenario_subtype_id` varchar(255) NOT NULL,
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
  `game_mode` varchar(255) NOT NULL,
  `inventory_size_multiplier` decimal(4,2) NOT NULL,
  `assembler_speed_multiplier` decimal(4,2) NOT NULL,
  `assembler_efficiency_multiplier` decimal(4,2) NOT NULL,
  `refinery_speed_multiplier` decimal(4,2) NOT NULL,
  `online_mode` varchar(255) NOT NULL,
  `max_players` int(11) NOT NULL,
  `max_floating_objects` int(11) NOT NULL,
  `environment_hostility` varchar(255) NOT NULL,
  `auto_healing` varchar(255) NOT NULL,
  `enable_copy_paste` varchar(255) NOT NULL,
  `auto_save` varchar(255) NOT NULL,
  `weapons_enabled` varchar(255) NOT NULL,
  `show_player_names_on_hud` varchar(255) NOT NULL,
  `thruster_damage` varchar(255) NOT NULL,
  `cargo_ships_enabled` varchar(255) NOT NULL,
  `enable_spectator` varchar(255) NOT NULL,
  `remove_trash` varchar(255) NOT NULL,
  `world_size_km` int(11) NOT NULL,
  `respawn_ship_delete` varchar(255) NOT NULL,
  `reset_ownership` varchar(255) NOT NULL,
  `welder_speed_multiplier` decimal(4,2) NOT NULL,
  `grinder_speed_multiplier` decimal(4,2) NOT NULL,
  `realistic_sound` varchar(255) NOT NULL,
  `client_can_save` varchar(255) NOT NULL,
  `hack_speed_multiplier` decimal(4,2) NOT NULL,
  `permanent_death` varchar(255) NOT NULL,
  `auto_save_in_minutes` int(11) NOT NULL,
  `spawn_ship_time_multiplier` decimal(4,2) NOT NULL,
  `procedural_density` decimal(3,2) NOT NULL,
  `procedural_seed` bigint(20) NOT NULL,
  `destructible_blocks` varchar(255) NOT NULL,
  `enable_ingame_scripts` varchar(255) NOT NULL,
  `enable_oxygen` varchar(255) NOT NULL,
  `view_distance` int(11) NOT NULL,
  `scenario_subtype_id` varchar(255) NOT NULL,
  `asteroid_amount` int(11) NOT NULL,
  `pause_game_when_empty` varchar(255) NOT NULL,
  `ignore_last_session` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instance_types`
--

INSERT INTO `instance_types` (`id`, `name`, `game_mode`, `inventory_size_multiplier`, `assembler_speed_multiplier`, `assembler_efficiency_multiplier`, `refinery_speed_multiplier`, `online_mode`, `max_players`, `max_floating_objects`, `environment_hostility`, `auto_healing`, `enable_copy_paste`, `auto_save`, `weapons_enabled`, `show_player_names_on_hud`, `thruster_damage`, `cargo_ships_enabled`, `enable_spectator`, `remove_trash`, `world_size_km`, `respawn_ship_delete`, `reset_ownership`, `welder_speed_multiplier`, `grinder_speed_multiplier`, `realistic_sound`, `client_can_save`, `hack_speed_multiplier`, `permanent_death`, `auto_save_in_minutes`, `spawn_ship_time_multiplier`, `procedural_density`, `procedural_seed`, `destructible_blocks`, `enable_ingame_scripts`, `enable_oxygen`, `view_distance`, `scenario_subtype_id`, `asteroid_amount`, `pause_game_when_empty`, `ignore_last_session`, `created`, `updated`) VALUES
(1, 'Small Server', 'Survival', '1.00', '1.00', '1.00', '1.00', 'PUBLIC', 5, 255, 'SAFE', 'true', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 20, 'true', 'false', '1.00', '1.00', 'false', 'true', '0.33', 'true', 20, '1.00', '0.00', 0, 'true', 'true', 'true', 2000, 'EasyStart1', 10, 'true', 'false', '2014-11-02 12:23:14', '2014-11-12 07:54:37'),
(2, 'Medium Server', 'Survival', '1.00', '1.00', '1.00', '1.00', 'PUBLIC', 10, 255, 'SAFE', 'true', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 20, 'true', 'false', '1.00', '1.00', 'false', 'true', '0.33', 'true', 20, '1.00', '0.00', 0, 'true', 'true', 'true', 2000, 'EasyStart1', 10, 'true', 'false', '2014-11-02 12:23:14', '2014-11-12 08:14:41'),
(3, 'Large Server', 'Survival', '1.00', '1.00', '1.00', '1.00', 'PUBLIC', 15, 255, 'SAFE', 'true', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 20, 'true', 'false', '1.00', '1.00', 'false', 'true', '0.33', 'true', 20, '1.00', '0.00', 0, 'true', 'true', 'true', 2000, 'EasyStart1', 10, 'true', 'false', '2014-11-02 12:23:14', '2014-11-12 07:54:16');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
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