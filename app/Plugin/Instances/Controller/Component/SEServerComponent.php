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

App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('CakeEmail', 'Network/Email');

class SEServerComponent extends Component {

	// Config variables
	public $serverBaseDirectory = null;
	public $serverDataDirectory = null;
	public $serverBinariesDirectory = null;
	public $serverDataSkeletonDirectory = null;
	public $firstOpenPort = null;
	public $lastOpenPort = null;
	public $hostServerInstanceLimit = null;
	public $apiVersion = null;
	public $apiKey = null;
	public $games = null;
	// TODO: Implement apiSecret (hash request with secret)
	public $apiSecret = null;
	// Simulate remote API call
	public $simulateRemoteApiCall = false;
	// Instance model
	private $Instance = null;
	// Instance Type model
	private $InstanceType = null;
	// Instance Profile model
	private $InstanceProfile = null;
	// Configuration model
	private $Configuration = null;
	// MemoryLog model
//	private $MemoryLog = null;
	// HostServer model
	private $HostServer = null;
	// User model
	private $User = null;
	// Instance list
	private $instances = array();
	// Host server name list
	private $hostServerNameList = false;
	// This host server
	private $hostServer = array();
	// Cached instance
	private $__instance = array();
	// Command options for Command Queue form
	public $remoteCommands = array(
		'commands' => array(
			'backupAll' => '[backupAll] Backup all server instances',
			'checkForUpdates' => '[checkForUpdates] Check for game updates',
			'cycleAll' => '[cycleAll] Cycle all server instances',
			'restartAll' => '[restartAll] Restart all server instances',
			'startAll' => '[startAll] Start all server instances',
			'stopAll' => '[stopAll] Stop all server instances',
			'updateAll' => '[updateAll] Update all server instances',
			'updateBinaries' => '[updateBinaries] Update all server instance binaries',
		)
	);
	// Http socket
	private $Http = null;
	protected $apiPathMap = array(
		'start' => 'instances/instances/start',
		'stop' => 'instances/instances/stop',
		'cycle' => 'instances/instances/cycle',
		'processState' => 'instances/instances/check',
		'reroll' => 'instances/instances/reroll',
		'spawn' => 'instances/instances/spawn',
		'getLogs' => 'instances/instances/instance_log',
	);

	public function initialize(Controller $controller) {
		// Load Models
		$this->Instance = ClassRegistry::init('Instances.Instance');
		$this->InstanceType = ClassRegistry::init('Instances.InstanceType');
		$this->InstanceProfile = ClassRegistry::init('Instances.InstanceProfile');
		$this->Configuration = ClassRegistry::init('Config.Configuration');
		//$this->MemoryLog = ClassRegistry::init('Instances.MemoryLog');
		$this->HostServer = ClassRegistry::init('Instances.HostServer');
		$this->User = ClassRegistry::init('User');
		// Determine host servers
		$this->__determineHostServers();
		// Set config
		if (!$this->serverBaseDirectory) {
			$this->serverBaseDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.serverBaseDirectory') . DS . Configure::read(APP_CONFIG_SCOPE . '.App.environment');
		}
		if (!$this->serverDataDirectory) {
			$this->serverDataDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.serverDataDirectory') . DS . Configure::read(APP_CONFIG_SCOPE . '.App.environment');
		}
		if (!$this->serverBinariesDirectory) {
			$this->serverBinariesDirectory = $this->serverBaseDirectory . DS . Configure::read(APP_CONFIG_SCOPE . '.Instances.serverBinariesDirectory');
		}
		if (!$this->serverDataSkeletonDirectory) {
			$this->serverDataSkeletonDirectory = $this->serverBaseDirectory . DS . Configure::read(APP_CONFIG_SCOPE . '.Instances.serverDataSkeletonDirectory');
		}
		if (!$this->firstOpenPort) {
			$this->firstOpenPort = Configure::read(APP_CONFIG_SCOPE . '.Instances.firstOpenPort');
		}
		if (!$this->lastOpenPort) {
			$this->lastOpenPort = Configure::read(APP_CONFIG_SCOPE . '.Instances.lastOpenPort');
		}
		if (!$this->hostServerInstanceLimit) {
			$this->hostServerInstanceLimit = Configure::read(APP_CONFIG_SCOPE . '.Instances.hostServerInstanceLimit');
		}
		if (!$this->apiVersion) {
			$this->apiVersion = Configure::read(APP_CONFIG_SCOPE . '.App.apiVersion');
		}
		if (!$this->apiKey) {
			$this->apiKey = Configure::read(APP_CONFIG_SCOPE . '.App.apiKey');
		}
		if (!$this->apiSecret) {
			$this->apiSecret = Configure::read(APP_CONFIG_SCOPE . '.App.apiSecret');
		}
		if (!$this->games) {
			$this->games = Configure::read(APP_CONFIG_SCOPE . '.Instances.games');
			$controller->set(array('games' => $this->getGameList()));
		}
		// Create Http Socket oject
		$this->Http = new HttpSocket();
	}

	public function getConfigOptions($gameId) {
		$configOptions = $this->games[$gameId]['configOptions'];
		if (!empty($configOptions)) {
			return $configOptions;
		}
	}

	// Merge in configOptions with retrieved data
	public function setForm($gameId, $requestData, $model) {
		if (empty($requestData[$model])) {
			$requestData[$model] = array();
		}
		$formData[$model] = array_merge(
			$this->nullArrayValues(array_flip($this->games[$gameId]['configKeys'])),
			$requestData[$model]
		);
		return $formData;
	}
	
	private function __underscore(&$item, $key) {
		$item = Inflector::underscore($item);
	}

	// Set all values in array to null
	function nullArrayValues($array) {
		return array_map(create_function('$n', 'return null;'), $array);
	}

	public function getGameList() {
		return Hash::extract($this->games, '{n}.name');
	}

	public function getRemoteCommands() {
		return $this->remoteCommands;
	}

	// This function not utilized yet
	// TODO: Implement
	public function pollAllMemoryUsage() {
		// Ensure instance list is set
		$this->__setInstanceList();
		// Cycle each server instance
		foreach ($this->instances as $instanceId) {
			// Update each server instance's memory usage in the database
			// TODO: Single SQL update
			$status = $this->processState($instanceId);
			if ($status !== 'Stopped') {
				//$this->MemoryLog->create();
				$memoryUsage = str_replace(array('K', ','), '', $status);
//				$memoryLog[$this->MemoryLog->alias] = array(
//					'instance_id' => $instanceId,
//					'memory' => $memoryUsage
//				);
//				$this->MemoryLog->save($memoryLog);
			}
		}
	}

	// This should not be used directly, in favor of cycle
	private function start($instanceId) {
		if ($this->processState($instanceId) != 'Stopped') {
			return $instanceId . ' is already started';
		}
		// Check if instance data exists, if not then cycle
		if (!$this->__verifyInstanceExistence($instanceId, false, false, false)) {
			return $this->cycle($instanceId);
		}
		// Update Session XML
		$this->__refreshConfig($instanceId);
		// Get instance
		$instance = $this->readInstance($instanceId);
		// Execute server instance binary
		exec('start /d "' . $this->__getServerBinariesDirectory($instance['Instance']['game_id']) . DS . 'DedicatedServer64" ' . $instanceId . '.exe -noconsole -path "' . $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . '"');
		return $instanceId . ' is starting up';
	}

	private function __getServerBinariesDirectory($gameId) {
		return $this->serverBinariesDirectory . DS . $this->__getGameFolderList()[$gameId];
	}

	private function stop($instanceId, $forced = false) {
		if ($this->processState($instanceId) == 'Stopped') {
			return $instanceId . ' is already stopped';
		}
		// Stop server instance gracefully
		exec('taskkill /IM ' . $instanceId . '.exe');
		if ($forced) {
			// Force kill server instance if still running
			exec('taskkill /IM ' . $instanceId . '.exe /F');
		}
		return $instanceId . ' was sent a termination signal.';
	}

	private function cycle($instanceId) {
		// Check if instance data exists
		$this->__verifyInstanceExistence($instanceId, true, false);
		// Backup the server instance
		$this->backup($instanceId);
		// Stop server instance, force kill
		$this->stop($instanceId, true);
		// Update the server instance
		$this->update($instanceId);
		// Start the server instance
		$this->start($instanceId);
		return $instanceId . ' is starting up.';
	}

	private function reroll($instanceId) {
		// Backup the server instance
		$this->backup($instanceId);
		// Stop server instance, force kill
		$this->stop($instanceId, true);
		// Remove world save
		$this->__removePath($this->getConfigPath($instanceId, 'active_world'));
		// Start the server instance
		$this->cycle($instanceId);
		return $instanceId . ' now has a whole new world.';
	}

	private function backup($instanceId) {
		// Copy current world saves to user backup directory
		// TODO: Change this path, make it configurable
		exec('robocopy "' . $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . 'Saves" "' . $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . 'Backup" /MIR');
		return $instanceId . ' is backed up.';
	}

	// Create binary for server instance
	private function update($instanceId) {
		// Read instance
		$instance = $this->readInstance($instanceId);
		// Delete server instance exe
		exec('DEL "' . $this->__getServerBinariesDirectory($instance['Instance']['game_id']) . DS . 'DedicatedServer64' . DS . $instanceId . '.exe"');
		// Copy new server instance exe
		exec('COPY "' . $this->__getServerBinariesDirectory($instance['Instance']['game_id']) . DS . 'DedicatedServer64' . DS . $this->__getGameDedicatedBinaryList()[$instance['Instance']['game_id']] . '" "' . $this->__getServerBinariesDirectory($instance['Instance']['game_id']) . DS . 'DedicatedServer64' . DS . $instanceId . '.exe"');
		return $instanceId . ' is updated.';
	}

	private function __getGameDedicatedBinaryList() {
		return Hash::extract($this->games, '{n}.dedicatedBinary');
	}

	private function processState($instanceId) {
		if ($instanceId) {
			// find tasks matching
			$searchPattern = '~(' . substr($instanceId, 0, 23) . ')~i';

			// get tasklist
			$taskList = array();
			exec("tasklist 2>NUL", $taskList);

			// Search through tasklist
			foreach ($taskList AS $taskLine) {
				if (preg_match($searchPattern, $taskLine, $out)) {
					//echo "=> Detected: " . $out[1] . "\n   Sending term signal!\n";
					//exec("taskkill /F /IM " . $out[1] . ".exe 2>NUL");
					$taskLineArray = array_values(array_diff(explode(' ', $taskLine), array('')));
					//$memoryUsage = $taskLineArray[4];
					return $taskLineArray[4] . $taskLineArray[5];
				}
			}
		}
		return 'Stopped';
	}

	private function getConfigPath($instanceId, $configType = 'server') {
		// Read instance
		$instance = $this->readInstance($instanceId);
		// TODO: Use this everywhere, find where it is not being used
		switch ($configType) {
			case 'server':
				$configPath = $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . $this->__getGameConfigList()[$instance['Instance']['game_id']];
				break;
			case 'active_world':
				$configPath = $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . 'Saves' . DS . 'Active';
				break;
			case 'session':
				$configPath = $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . 'Saves' . DS . 'Active' . DS . 'Sandbox.sbc';
				break;
		}
		return $configPath;
	}

	// Remove path recursively
	private function __removePath($path) {
		if (is_dir($path) === true) {
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($files as $file) {
				if (in_array($file->getBasename(), array('.', '..')) !== true) {
					if ($file->isDir() === true) {
						rmdir($file->getPathName());
					} else if (($file->isFile() === true) || ($file->isLink() === true)) {
						unlink($file->getPathname());
					}
				}
			}
			return rmdir($path);
		} else if ((is_file($path) === true) || (is_link($path) === true)) {
			return unlink($path);
		}
		return false;
	}

	private function __refreshConfig($instanceId) {
		$configPath = $this->getConfigPath($instanceId);
		// Delete current settings
		unlink($configPath);
		// Retrieve instance data
		$instanceData = $this->readInstance($instanceId, true);
		$serverDataSkeletonDirectory = $this->__getServerDataSkeletonDirectory($instanceData['Instance']['game_id']);
		// Copy skeleton cfg to instance
		$source = $serverDataSkeletonDirectory . DS . $this->__getGameConfigList()[$instanceData['Instance']['game_id']];
		copy($source, $configPath);
		// Refresh mods list
		$this->__refreshMods($instanceId, $instanceData['Instance']['mods']);
		// Merge config from instance_type, instance_profile and instance
		$instanceProfile = $this->InstanceProfile->findById($instanceData['Instance']['instance_profile_id'])['InstanceProfile']['profile_settings'];
		$instanceType = $this->InstanceType->findById($instanceData['Instance']['instance_type_id'])['InstanceType']['profile_settings'];
		$instance = $this->__stripValues($instanceData['Instance'], array('id', 'created', 'updated', 'user_id', 'instance_profile_id', 'instance_type_id'));
		//$instanceProfile = $this->__stripValues($instanceData['InstanceProfile']['profile_settings']);
		$configProfile = array_merge($instanceType, $instanceProfile, $instance);
		$configProfile['world_name'] = 'Active';
		$configProfile['load_world'] = $this->getConfigPath($instanceId, 'active_world');
		// Parse server admins field
		$configProfile['server_admins'] = $this->__parseServerAdmins($configProfile['server_admins']);
		// Inject config into cfg
		$this->__injectConfig($instanceId, $configProfile);
		// Delete session settings from world save
		$this->__deleteSandboxSettings($instanceId);
		// Set session settings into world save
		$this->__setSandboxSettings($instanceId);
	}

	private function __getGameConfigList() {
		return Hash::extract($this->games, '{n}.config');
	}

	// This function strips values from an array and fixes the data to be compatible with the configuration template
	private function __stripValues($data, $keys) {
		foreach ($keys as $key) {
			unset($data[$key]);
		}
		return $this->__fixKeys($data);
	}

	private function __parseServerAdmins($serverAdmins) {
		if (!empty($serverAdmins)) {
			$explodedAdmins = array_unique(explode("\r\n", $serverAdmins));
			//	<Administrators>
			//	  <unsignedLong>76561198031956608</unsignedLong>
			//	</Administrators>
			$parsedAdmins = "<Administrators>\r\n";
			foreach ($explodedAdmins as $admin) {
				$admin = str_replace(' ', '', $admin);
				if (!$admin) {
					continue;
				}
				$parsedAdmins .= "\t<unsignedLong>" . $admin . "</unsignedLong>\r\n";
			}
			$parsedAdmins .= "  </Administrators>";
			return $parsedAdmins;
		}
		return '<Administrators />';
	}

	// This function fixes keys to be compatible with configuration template
	// TODO: refactor to take an array to tell which keys to fix to what
	private function __fixKeys($data) {
		if (isset($data['name'])) {
			$data['server_name'] = $data['name'];
			unset($data['name']);
		}
		if (isset($data['port'])) {
			$data['server_port'] = $data['port'];
			unset($data['port']);
		}
		return $data;
	}

	private function __deleteSandboxSettings($instanceId) {
		$sandboxSbcPath = $this->getConfigPath($instanceId, 'session');
		try {
			$sandboxSbc = $this->loadXml($sandboxSbcPath);
		} catch (Exception $e) {
			return true;
		}
		unset($sandboxSbc->Settings);
		unset($sandboxSbc->SessionSettings);
		return $sandboxSbc->asXml($sandboxSbcPath);
	}

	// TODO: This is terribly dirty - ICKY!
	private function __setSandboxSettings($instanceId) {
		$dedicatedServerCfgPath = $this->getConfigPath($instanceId, 'server');
		$sandboxSbcPath = $this->getConfigPath($instanceId, 'session');
		try {
			$dedicatedServerCfg = $this->loadXml($dedicatedServerCfgPath);
		} catch (Exception $e) {
			return true;
		}
		try {
			$sandboxSbc = $this->loadXml($sandboxSbcPath);
		} catch (Exception $e) {
			return true;
		}
		$this->__sxml_append($sandboxSbc, $dedicatedServerCfg->SessionSettings);
		$sandboxSbc->asXml($sandboxSbcPath);
		return $this->__renameSandboxSettings($instanceId);
	}

	// TODO: This is terribly dirty - ICKY!
	private function __renameSandboxSettings($instanceId) {
		$sandboxSbcPath = $this->getConfigPath($instanceId, 'session');
		try {
			$sandboxSbc = file_get_contents($sandboxSbcPath);
		} catch (Exception $e) {
			return true;
		}
		$sandboxSbc = str_replace('<SessionSettings>', '  <Settings>', $sandboxSbc);
		$sandboxSbc = str_replace('</SessionSettings>', "</Settings>\r\n", $sandboxSbc);
		return file_put_contents($sandboxSbcPath, $sandboxSbc);
	}

	private function __sxml_append(SimpleXMLElement $to, SimpleXMLElement $from) {
		$toDom = dom_import_simplexml($to);
		$fromDom = dom_import_simplexml($from);
		$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
	}

	private function __refreshMods($instanceId, $mods) {
		$sandboxSbcPath = $this->getConfigPath($instanceId, 'session');
		try {
			$sandboxSbc = $this->loadXml($this->getConfigPath($instanceId, 'session'));
		} catch (Exception $e) {
			return true;
		}
		unset($sandboxSbc->Mods);
		$moddedSandboxSbc = $this->__parseMods($sandboxSbc, $mods);
		return $this->__saveFormattedXml($moddedSandboxSbc, $sandboxSbcPath);
	}

	private function __parseMods($sandboxSbc, $modList) {
		$modsXml = $sandboxSbc->addChild('Mods');
		if (!empty($modList)) {
			$explodedMods = array_unique(explode("\r\n", $modList));
			foreach ($explodedMods as $mod) {
				$mod = str_replace(' ', '', $mod);
				if (!$mod) {
					continue;
				}
				$modItem = $modsXml->addChild('ModItem');
				$modItem->addChild('Name', $mod . '.sbm');
				$modItem->addChild('PublishedFileId', $mod);
			}
		}
		return $sandboxSbc;
	}

	private function __saveFormattedXml($xml, $path) {
		unlink($path);
		$dom = new DOMDocument('1.0');
		// TODO: Why are these 2 things coming through to the XML?
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());
		$formattedXml = $dom->saveXML();
		return file_put_contents($path, $formattedXml);
	}

	private function __determineHostServers() {
		// Set host server name list
		$this->hostServerNameList = $this->HostServer->find('list');
		// Determine this host
		@$this->hostServer = $this->HostServer->findByServername(Configure::read(APP_CONFIG_SCOPE . '.App.servername'));
		if (empty($this->hostServer['HostServer']['hostname']) || !in_array($this->hostServer['HostServer']['hostname'], $this->hostServerNameList)) {
			$this->hostServer = array(
				'HostServer' => array(
					'id' => null,
					'hostname' => 'localhost'
				)
			);
			//throw new NotFoundException(__('Invalid source host.'));
		}
	}

	private function __verifyInstanceExistence($instanceId, $spawn = true, $cycle = true, $create = true) {
		$instanceCreated = false;
		$userDirExists = file_exists($this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username']);
		$instanceDirExists = file_exists($this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId);
		// Check if user dir exists
		if ($create && !$userDirExists) {
			// create user dir
			$userDirExists = mkdir($this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username']);
		}
		// Check if instance dir exists
		if ($create && !$instanceDirExists) {
			// create user dir
			$instanceCreated = $instanceDirExists = mkdir($this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId);
		}
		if ($spawn && $instanceCreated) {
			return $this->spawn($instanceId, $cycle);
		}
		return $instanceDirExists;
	}

	public function createInstance($instance = array()) {
		// Set user id to current user if unspecified
		if (empty($instance['Instance']['user_id'])) {
			$instance['Instance']['user_id'] = AuthComponent::user('id');
		}
		// Set host server
		if (empty($instance['Instance']['host_server_id'])) {
			// Host server based on least usage
			$availableHostServers = $this->HostServer->find('list', array(
				'conditions' => array(
					'or' => array(
						'HostServer.instance_count <' => $this->hostServerInstanceLimit,
						'HostServer.instance_count < HostServer.instance_limit'
					)
				),
				'order' => array(
					'HostServer.instance_count ASC'
				)
			));
			if (empty($availableHostServers)) {
				throw new NotFoundException(__('No available host servers'));
			}
			// Get first key
			reset($availableHostServers);
			$instance['Instance']['host_server_id'] = key($availableHostServers);
		}
		$this->Instance->create();
		if ($this->Instance->save($instance)) {
			$instanceId = $this->Instance->id;
			return $this->server('spawn', $instanceId);
		}
		return false;
	}

	private function spawn($instanceId, $cycle = true) {
		$this->Instance->id = $instanceId;
		if (!$this->Instance->exists()) {
			return 'Instance not found';
		}
		$this->__verifyInstanceExistence($instanceId, false, false, true);
		$instance = $this->readInstance($instanceId);
		// TODO: Error checking
		// Set port
		$instance['Instance']['port'] = $this->__getOpenPort();
		$serverDataSkeletonDirectory = $this->__getServerDataSkeletonDirectory($instance['Instance']['game_id']);
		$destination = $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId;
		$this->__copyDir($serverDataSkeletonDirectory, $destination);
		$configurations = array_merge($this->InstanceType->findById($instance['Instance']['instance_type_id'])['InstanceType']['profile_settings'], array(
			'server_port' => $instance['Instance']['port'],
			'server_name' => $instance['Instance']['name'],
			'world_name' => 'Active',
			'group_id' => 0,
			'load_world' => $destination . DS . 'Saves' . DS . 'Active'
		));
		$this->__injectConfig($instanceId, $configurations);
		$instanceProfile['InstanceProfile'] = array(
			'name' => $instance['Instance']['name'],
			'user_id' => $instance['Instance']['user_id']
		);
		$instanceProfile['InstanceProfile']['profile_settings'] = $configurations;
		$this->InstanceProfile->create($instanceProfile);
		if ($this->InstanceProfile->save()) {
			$instance['Instance']['instance_profile_id'] = $this->InstanceProfile->id;
			if ($this->Instance->save($instance)) {
				$this->__sendInstanceCreationMail($instanceId);
				if ($cycle) {
					return $this->server('cycle', $instanceId);
				}
				return 'Instance spawned successfully.';
			}
		}
		return 'Instance creation failed';
	}

	private function __getserverDataSkeletonDirectory($gameId) {
		return $this->serverDataSkeletonDirectory . DS . $this->__getGameFolderList()[$gameId];
	}

	private function __getGameFolderList() {
		return Hash::extract($this->games, '{n}.folder');
	}

	private function __getOpenPort() {
		$this->Instance->displayField = 'port';
		$usedPorts = $this->Instance->find('list', array('conditions' => array('Instance.host_server_id' => $this->hostServer['HostServer']['id'])));
		// Blacklist port 27036
		$usedPorts[] = 27036;
		$nextAvailablePort = @array_shift(array_diff(range($this->firstOpenPort, $this->lastOpenPort), $usedPorts));
		$this->Instance->displayField = 'name';
		return $nextAvailablePort;
	}

	public function findOpenPort($hostServerId) {
		$this->hostServer['HostServer']['id'] = $hostServerId;
		return $this->__getOpenPort();
	}

	// TODO: Use robocopy?
	// Recursively copies directory
	// TODO: error checking / return false on fail
	private function __copyDir($src, $dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while (false !== ( $file = readdir($dir))) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if (is_dir($src . '/' . $file)) {
					$this->__copyDir($src . '/' . $file, $dst . '/' . $file);
				} else {
					copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}

	/*
	 * This function injects the values into the dedicated server config file and replaces the keys
	 */

	private function __injectConfig($instanceId, $configurations) {
		$configValues = $this->__buildConfigKeys($configurations);
		$instance = $this->readInstance($instanceId);
		$configPath = $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId . DS . $this->__getGameConfigList()[$instance['Instance']['game_id']];
		$config = str_replace(array_keys($configValues), $configValues, file_get_contents($configPath));
		return file_put_contents($configPath, $config);
	}

	/*
	 * This method wraps all of the array_keys with {}
	 */

	private function __buildConfigKeys($config) {
		$wrappedKeys = array_map(
				function ($el) {
			return "{{$el}}";
		}, array_keys($config)
		);
		return array_combine($wrappedKeys, array_values($config));
	}

	private function __sendInstanceCreationMail($instanceId) {
		$instance = $this->readInstance($instanceId);
		if (!isset($instance['Instance']['user_id'])) {
			return;
		}
		$user = $this->readUser($instance['Instance']['user_id']);
		$email = new CakeEmail('default');
		$email->to($user['User']['email']);
		$email->subject(Configure::read(APP_CONFIG_SCOPE . '.Email.newInstanceSubject'));
		$email->template('new-instance');
		$email->viewVars($instance['Instance']);
		$email->viewVars(array('username' => $user['User']['username']));
		$email->addHeaders(array(
			'tags' => array(Configure::read(APP_CONFIG_SCOPE . '.App.environment') . '-new-instance-email'),
		));
		if (Configure::read(APP_CONFIG_SCOPE . '.App.emailEnabled')) {
			$email->send();
		} else {
			debug('E-mail suppressed because e-mail is disabled.');
		}
	}

	private function readInstance($instanceId, $refresh = false) {
		if (empty($this->__instance) || $refresh) {
			$this->__instance = $this->Instance->findById($instanceId);
		}
		return $this->__instance;
	}

	private function readUser($userId) {
		return $this->User->findById($userId);
	}

	private function getLogs($instanceId) {
		$logPath = $this->serverDataDirectory . DS . $this->readInstance($instanceId)['User']['username'] . DS . $instanceId;

		// Find all log files
		$logFiles = glob($logPath . DS . "*.log");

		//File path of final result
		$mergedLogs = $logPath . DS . "mergedLogs.txt";

		$out = fopen($mergedLogs, "w");
		//Then cycle through the files reading and writing.

		foreach ($logFiles as $file) {
			$in = fopen($file, "r");
			while ($line = fgets($in)) {
				//print $file;
				fwrite($out, $line);
			}
			fclose($in);
		}

		//Then clean up
		fclose($out);

		return file_get_contents($mergedLogs);
	}

	// Pass-through function to handle server actions
	public function server($action) {
		if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
			return 'Under maintenance.';
		}
		// Get function arguments
		$args = func_get_args();
		// Shift off the first argument because that is the function
		array_shift($args);
		// Convert server UUID to server name
		//$instanceName = $this->uuidToName($args[0]);
		$instanceId = $args[0];
		// Return false if not the owner
		if (!$this->checkOwnership($instanceId)) {
			return false;
		}
		// Set first argument to server name
		//$args[0] = $instanceId;
		// Execute remote API call if needed
		$remoteApiResult = $this->__remoteApiCall($action, $instanceId);
		if ($remoteApiResult) {
			return $remoteApiResult;
		}
		// Call the desired function
		return call_user_func_array(array($this, $action), $args);
	}

	// TODO: Is this used anymore?
	public function uuidToName($serverUuid) {
		// Check for valid UUID
		if (preg_match('/^\{?[a-f\d]{8}-(?:[a-f\d]{4}-){3}[a-f\d]{12}\}?$/i', $serverUuid)) {
			// Retrieve server from database
			$server = $this->Instance->findById($serverUuid);
			// Set servername to variable
			$instanceName = $server['Instance']['name'];
			// Return servername
			return $instanceName;
		}
		return false;
	}

	public function checkOwnership($instanceId) {
		// Admin/support own all servers
		if (AuthComponent::user('role_id') <= 2) {
			return true;
		}
		// Check ownership if not admin/support
		if (AuthComponent::user('role_id') && AuthComponent::user('role_id') > 2) {
			// Todo: retrieve just the user_id field
			$instance = $this->readInstance($instanceId);
			if ($instance['Instance']['user_id'] == AuthComponent::user('id')) {
				return true;
			}
		}
		return false;
	}

	private function __setInstanceList() {
		if (empty($this->instances)) {
			$this->instances = $this->Instance->find('list', array(
				'conditions' => array(
					'Instance.host_server_id' => $this->hostServer['HostServer']['id']
				)
			));
		}
	}

	public function loadXml($xmlFilePath, $convertToArray = false) {
		$xmlContents = Xml::build($xmlFilePath);
		if ($convertToArray) {
			$xmlContents = Xml::toArray($xmlContents);
		}
		return $xmlContents;
	}

	private function __remoteApiCall($method, $instanceId) {
		$instanceHostServerName = false;
		// Are we simulating a remote API call?
		if ($this->simulateRemoteApiCall) {
			$instanceHostServerName = $this->hostServer['HostServer']['hostname'];
		} else {
			$instanceHostServerName = $this->hostServerNameList[$this->Instance->findById($instanceId)['Instance']['host_server_id']];
			// Determine remote host (if exists)
			if (!in_array($instanceHostServerName, $this->hostServerNameList)) {
				throw new NotFoundException(__('Invalid remote host.'));
			}
			if ($this->hostServer['HostServer']['hostname'] == $instanceHostServerName) {
				return false;
			}
		}
		// Execute remote call if required or simulated
		if (in_array($method, array_keys($this->apiPathMap)) && $instanceHostServerName) {
			$remoteApiPath = $this->apiPathMap[$method];
			$result = json_decode($this->Http->get('http://' . $instanceHostServerName . '/api_' . $this->apiVersion . '/' . $this->apiKey . '/' . $remoteApiPath . '/' . $instanceId));
			return $result->Message;
		}
		return false;
	}

}
