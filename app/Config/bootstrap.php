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

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 */
// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */
/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 * 		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 * 		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 * 		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

// Load plugins
CakePlugin::loadAll();

// Load configurations from database
App::uses('ClassRegistry', 'Utility');
$Configuration = ClassRegistry::init('Config.Configuration');
define('APP_CONFIG_SCOPE', 'Hecpanel');
$Configuration->load('Instances');
$Configuration->load('Users');
$Configuration->load('Email');
$Configuration->load('App');

Configure::load('hecpanelconfig');
Configure::write(APP_CONFIG_SCOPE . '.App.apiVersion', 'v1');
// TODO: Move to config file in Instances plugin
Configure::write(APP_CONFIG_SCOPE . '.Instances.games', array(
	array(
		'name' => 'Space Engineers',
		'folder' => 'SPACE_ENGINEERS',
		'config' => 'SpaceEngineers-Dedicated.cfg',
		'dedicatedBinary' => 'SpaceEngineersDedicated.exe',
		'sourceBinariesDirectory' => 'C:' . DS . 'Program Files (x86)' . DS . 'Steam' . DS . 'SteamApps' . DS . 'common' . DS . 'SpaceEngineers',
		'configOptions' => array(
			'SessionSettings' => array(
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
				'scenarioSubtypes' => array(
					'EasyStart1' => 'EasyStart1',
					'EasyStart2' => 'EasyStart2',
					'Survival' => 'Survival',
					'CrashedRedShip' => 'CrashedRedShip',
					'TwoPlatforms' => 'TwoPlatforms',
					'Asteroids' => 'Asteroids',
					'EmptyWorld' => 'EmptyWorld'
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
				'hackSpeedMultipliers' => array_combine(range(1, 100, 1), range(1, 100, 1)), // 1-100, increment of 1
				'autoSaveInMinutes' => array_combine(range(15, 90, 15), range(15, 90, 15)), // 15-90, increment of 15
				'spawnShipTimeMultipliers' => array_combine(range(0, 20, 1), range(0, 20, 1)), // 0-20, increment of 1
				'asteroidAmounts' => array_combine(range(0, 10, 1), range(0, 10, 1)), // 0-10, increment of 1
				'proceduralDensities' => array_combine(range(0, 1, .05), range(0, 1, .05)), // 0-1, increment of .05
				'viewDistances' => array_combine(range(1000, 30000, 1000), range(1000, 30000, 1000)), // 1000-30000, increment of 1000
			),
		)
	),
	array(
		'name' => 'Medieval Engineers',
		'folder' => 'MEDIEVAL_ENGINEERS',
		'config' => 'MedievalEngineers-Dedicated.cfg',
		'dedicatedBinary' => 'MedievalEngineersDedicated.exe',
		'sourceBinariesDirectory' => 'C:' . DS . 'Program Files (x86)' . DS . 'Steam' . DS . 'SteamApps' . DS . 'common' . DS . 'MedievalEngineers',
	),
));

//Configure::write(APP_CONFIG_SCOPE . '.Instances.serverArchiveDirectory', 'SERVER_ARCHIVES');
Configure::write(APP_CONFIG_SCOPE . '.Instances.serverBinariesDirectory', 'SERVER_BINARIES');
Configure::write(APP_CONFIG_SCOPE . '.Instances.serverDataSkeletonDirectory', 'SERVER_SKELETON');

Configure::write('Bootstrap.formButtonStyle', array(
    'div' => 'col col-md-9 col-md-offset-3',
    'class' => 'btn btn-default'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'File',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'File',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));

class QuickGit {

    public static function version() {
        @exec('git describe --always', $version_mini_hash);
        @exec('git rev-list HEAD | wc -l', $version_number);
        @exec('git log -1', $line);
        @$version['short'] = "v1." . trim($version_number[0]) . "." . $version_mini_hash[0];
        @$version['full'] = "v1." . trim($version_number[0]) . ".$version_mini_hash[0] (" . str_replace('commit ', '', $line[0]) . ")";
        @$version['mini'] = "v" . $version_mini_hash[0];
        return $version;
    }

}

$git = new QuickGit();
define('APP_GIT_VERSION', $git->version()['mini']);

// hour cache file storage
Cache::config('hour', array(
    'engine' => 'File',
    'duration' => '+1 hours',
    'probability' => 100,
    'path' => CACHE . 'hour' . DS,
));

define('APP_SERVER_NAME', strtolower(gethostname()));

// day cache file storage
Cache::config('day', array(
    'engine' => 'File',
    'duration' => '+1 day',
    'probability' => 100,
    'path' => CACHE . 'day' . DS,
));

// week cache file storage
Cache::config('week', array(
    'engine' => 'File',
    'duration' => '+1 week',
    'probability' => 100,
    'path' => CACHE . 'week' . DS,
));

// month cache file storage
Cache::config('month', array(
    'engine' => 'File',
    'duration' => '+1 month',
    'probability' => 100,
    'path' => CACHE . 'month' . DS,
));

CakeLog::config('se_server_shell', array('engine' => 'File'));
