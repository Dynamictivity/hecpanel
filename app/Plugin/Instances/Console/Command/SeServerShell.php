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

class SeServerShell extends AppShell {

	// Config variables
	public $serverBaseDirectory = null;
	public $serverDataDirectory = null;
	public $serverBinariesDirectory = null;
	public $sourceBinariesDirectory = null;
	public $backupDirectory = null;
	public $binariesLastUpdated = null;
	// Instance model
	private $Instance = null;
	// Instance Type model
	private $InstanceType = null;
	// Instance Profile model
	private $InstanceProfile = null;
	// Configuration model
	private $Configuration = null;
	// MemoryLog model
	private $MemoryLog = null;
	// HostServer model
	private $HostServer = null;
	// User model
	private $User = null;
	// CommandQueue model
	private $CommandQueue = null;
	// Instance list
	private $instances = array();
	// This host server
	private $hostServer = array();

	public function main() {
		// TODO: Put usage here
		$this->__out('hi');
	}

	public function initialize() {
		// Load Models
		$this->Instance = ClassRegistry::init('Instances.Instance');
		$this->Instance->recursive = -1;
		$this->InstanceType = ClassRegistry::init('Instances.InstanceType');
		$this->InstanceType->recursive = -1;
		$this->InstanceProfile = ClassRegistry::init('Instances.InstanceProfile');
		$this->InstanceProfile->recursive = -1;
		$this->Configuration = ClassRegistry::init('Config.Configuration');
		$this->Configuration->recursive = -1;
		$this->MemoryLog = ClassRegistry::init('Instances.MemoryLog');
		$this->MemoryLog->recursive = -1;
		$this->HostServer = ClassRegistry::init('Instances.HostServer');
		$this->HostServer->recursive = -1;
		$this->User = ClassRegistry::init('User');
		$this->User->recursive = -1;
		$this->CommandQueue = ClassRegistry::init('Instances.CommandQueue');
		$this->CommandQueue->recursive = -1;
		// Determine host server
		$this->__determineHostServer();
		// Set config
		if (!$this->serverBaseDirectory) {
			$this->serverBaseDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.serverBaseDirectory') . DS . Configure::read(APP_CONFIG_SCOPE . '.App.environment');
		}
		if (!$this->serverDataDirectory) {
			$this->serverDataDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.serverDataDirectory');
		}
		if (!$this->serverBinariesDirectory) {
			$this->serverBinariesDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.serverBinariesDirectory');
		}
		if (!$this->sourceBinariesDirectory) {
			$this->sourceBinariesDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.sourceBinariesDirectory');
		}
		if (!$this->backupDirectory) {
			$this->backupDirectory = Configure::read(APP_CONFIG_SCOPE . '.Instances.backupDirectory');
		}
		if (!$this->binariesLastUpdated) {
			$this->binariesLastUpdated = Cache::read(APP_CONFIG_SCOPE . '.Instances.binariesLastUpdated', 'month');
		}
	}

	public function cron() {
		//$this->__out('Cron initiated.');
		$queuedCommands = $this->__getQueuedCommands();
		$this->__executeCommands($queuedCommands);
		$this->__markCommandsAsExecuted($queuedCommands);
		$this->__disableNonRecurringCommands($queuedCommands);
		$this->__out('Cron completed.');
	}

	private function __getQueuedCommands() {
		$queuedCommands = $this->CommandQueue->find('all', array(
			'conditions' => array(
				'CommandQueue.is_enabled',
				'or' => array(
					'CommandQueue.host_server_id IS NULL',
					array(
						'CommandQueue.host_server_id' => $this->hostServer['HostServer']['id'],
						'or' => array(
							'CommandQueue.last_executed IS NULL',
							array(
								'CommandQueue.is_once_per_day',
								'TIMESTAMP(CURDATE(), CommandQueue.time) < NOW()',
								'TIMESTAMP(CURDATE(), CommandQueue.time) > CommandQueue.last_executed',
							),
							array(
								'CommandQueue.is_once_per_day' => '0',
								'CommandQueue.time',
								'SUBTIME(NOW(), CommandQueue.time) > CommandQueue.last_executed',
							),
							array(
								'CommandQueue.is_once_per_day' => '0',
								'CommandQueue.time' => '00:00:00',
							)
						),
					),
				)
			)
				)
		);
		//$this->__out($this->CommandQueue->getLastQuery());die;
		$this->__out('Get queued commands:', $queuedCommands);
		return $queuedCommands;
	}

	private function __executeCommands($commands) {
		$commandsToExecute = Hash::extract($commands, '{n}.CommandQueue.command');
		$this->__out('Execute commands:', $commandsToExecute);
		foreach ($commandsToExecute as $command) {
			$this->host($command);
		}
		return $commandsToExecute;
	}

	private function __markCommandsAsExecuted($commands) {
		$executedCommandIds = Hash::extract($commands, '{n}.CommandQueue.id');
		$this->__out('Mark commands as executed:', $executedCommandIds);
		$this->CommandQueue->updateAll(
				array(
			'CommandQueue.last_executed' => "NOW()",
			'CommandQueue.last_executed_host_server_id' => "'" . $this->hostServer['HostServer']['id'] . "'"
				), array(
			'CommandQueue.id' => $executedCommandIds
				)
		);
		return $executedCommandIds;
	}

	private function __disableNonRecurringCommands($commands) {
		$nonRecurringCommandIds = array_keys(array_diff(Hash::combine($commands, '{n}.CommandQueue.id', '{n}.CommandQueue.is_recurring'), array(true)));
		$this->__out('Disable non-recurring commands:', $nonRecurringCommandIds);
		$this->CommandQueue->updateAll(
				array(
			'CommandQueue.is_enabled' => NULL,
				), array(
			'CommandQueue.id' => $nonRecurringCommandIds
				)
		);
		return $nonRecurringCommandIds;
	}

	private function __determineHostServer() {
		// Determine this host
		$this->hostServer = $this->HostServer->findByServername(Configure::read(APP_CONFIG_SCOPE . '.App.servername'));
	}

	// TODO: Medieval Engineers
	public function checkForUpdates() {
		$this->__out('Checking for updates:', 'Started');
		$dedicatedServerExeStats = stat(Configure::read(APP_CONFIG_SCOPE . '.Instances.sourceBinariesDirectory') . DS . 'DedicatedServer64\\SpaceEngineersDedicated.exe');
		// TODO: MD5 Checksum of directory?
		$lastUpdated = $dedicatedServerExeStats[9];
		if ($this->binariesLastUpdated != $lastUpdated) {
			$this->__out('Update found.');
			$this->binariesLastUpdated = $lastUpdated;
			$this->updateAll();
			return;
		}
		$this->__out('No updates found.');
	}

	public function updateAll() {
		Cache::write(APP_CONFIG_SCOPE . '.App.maintenanceMode', true, 'hour');
		// Ensure server list is set
		$this->__setServerList();
		// Backup servers
		//$this->backupAll();
		// Stop servers
		$this->stopAll();
		// Update servers
		$this->updateBinaries();
		// Cycle servers
		$this->cycleAll();
		Cache::delete(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour');
		$this->__out('Update process completed.');
	}

	//TODO: Implement this in $this->updateAll()
	public function backupAll() {
		$this->__out('Backing up servers.');
		// Backup servers
		passthru('robocopy "' . $this->serverDataDirectory . '" "' . $this->backupDirectory . '" /MIR');
		$this->__out('Server backup completed.');
	}

	// TODO: Medieval Engineers
	public function updateBinaries() {
		$this->__out('Updating server binaries.');
		// Get updated server binaries
		passthru('robocopy "' . $this->sourceBinariesDirectory . '" "' . $this->serverBaseDirectory . DS . $this->serverBinariesDirectory . '" /MIR');
		// Update last modified date
		$this->__saveLastUpdated();
		$this->__out('Server binaries updated.');
	}

	// TODO: Medieval Engineers
	private function __saveLastUpdated() {
		// Set binaries last updated
		Cache::write(APP_CONFIG_SCOPE . '.Instances.binariesLastUpdated', $this->binariesLastUpdated, 'month');
	}

	public function stopAll() {
		$this->__out('Stopping all server instances.');
		// Ensure server list is set
		$this->__setServerList();
		// Stop main server, force kill
		// TODO: Medieval Engineers
		$this->stop('SpaceEngineersDedicated', true);
		// Stop each server force kill
		foreach ($this->instances as $server) {
			$this->stop($server, true);
		}
		$this->__out('All server instances stopped.');
	}

	public function stop($instanceId, $forced = false) {
		if ($this->processState($instanceId) == 'Stopped') {
			return $this->__out($instanceId . ' is already stopped.');
		}
		// Stop server gracefully
		passthru('taskkill /IM ' . $instanceId . '.exe');
		$this->__out($instanceId . ' was sent a graceful termination signal.');
		if ($forced) {
			// Force kill server if still running
			passthru('taskkill /IM ' . $instanceId . '.exe /F');
			$this->__out($instanceId . ' was sent a forceful termination signal.');
		}
	}

	public function cycleAll() {
		$this->__out('Cycling all servers.');
		// Ensure server list is set
		$this->__setServerList();
		// Cycle each server
		foreach ($this->instances as $server) {
			// Update each server exe, stop server to ensure binary can copy properly
			$this->cycle($server);
		}
		$this->__out('All servers cycled.');
	}

	public function cycle($instanceId) {
		// Check if instance data exists, if not then exit
		if (!$this->__verifyInstanceExistence($instanceId)) {
			return $this->__out($instanceId . ' data directory does not exist.');
		}
		// Backup the server
		$this->backup($instanceId);
		// Stop server, force kill
		$this->stop($instanceId, true);
		// Update the server
		$this->update($instanceId);
		// Start the server
		$this->start($instanceId);
		$this->__out($instanceId . ' is cycled.');
	}

	public function startAll() {
		$this->__out('Starting all servers.');
		// Ensure server list is set
		$this->__setServerList();
		// Start each server
		foreach ($this->instances as $server) {
			$this->start($server);
		}
		$this->__out('All servers started.');
	}

	public function start($instanceId) {
		if ($this->processState($instanceId) != 'Stopped') {
			return $this->__out($instanceId . ' is already started.');
		}
		// Check if instance data exists, if not then exit
		if (!$this->__verifyInstanceExistence($instanceId)) {
			return $this->__out($instanceId . ' data directory does not exist.');
		}
		// Execute server binary
		// TODO: Medieval Engineers
		passthru('start /d "' . $this->serverBaseDirectory . DS . $this->serverBinariesDirectory . DS . 'DedicatedServer64" ' . $instanceId . '.exe -noconsole -path "' . $this->serverDataDirectory . DS . $this->readServer($instanceId)['User']['username'] . DS . $instanceId . DS . '"');
		$this->__out($instanceId . ' is starting up.');
	}

	public function restartAll() {
		$this->__out('Restarting all servers.');
		// Ensure server list is set
		$this->__setServerList();
		// Stop all servers
		$this->stopAll();
		// Start all servers
		$this->startAll();
		$this->__out('All servers restarted.');
	}

	public function backup($instanceId) {
		// Copy current world saves to user backup directory
		passthru('robocopy "' . $this->serverDataDirectory . DS . $this->readServer($instanceId)['User']['username'] . DS . $instanceId . '\\Saves" "' . $this->serverDataDirectory . DS . $this->readServer($instanceId)['User']['username'] . DS . $instanceId . '\\Backup" /MIR');
		$this->__out($instanceId . ' is backed up.');
	}

	// TODO: Medieval Engineers
	public function update($instanceId) {
		// Delete server exe
		passthru('DEL "' . $this->serverBaseDirectory . DS . $this->serverBinariesDirectory . '\\DedicatedServer64\\' . $instanceId . '.exe"');
		// Copy new server exe
		passthru('COPY "' . $this->serverBaseDirectory . DS . $this->serverBinariesDirectory . '\\DedicatedServer64\\SpaceEngineersDedicated.exe" "' . $this->serverBaseDirectory . DS . $this->serverBinariesDirectory . '\\DedicatedServer64\\' . $instanceId . '.exe"');
		$this->__out($instanceId . ' exe is updated.');
	}

	private function __setServerList() {
		if (empty($this->instances)) {
			$this->instances = array_keys(
				$this->Instance->find('list', array(
					'conditions' => array(
						'Instance.host_server_id' => $this->hostServer['HostServer']['id']
					)
				))
			);
		}
	}

	public function processState($instanceId) {
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
					$this->__out($taskLineArray[4] . $taskLineArray[5]);
					return $taskLineArray[4] . $taskLineArray[5];
				}
			}
		}
		$this->__out('Stopped');
		return 'Stopped';
	}

	private function __out() {
		// Get function arguments
		$args = func_get_args();
		if (Configure::read('debug') > 0) {
			debug($args);
		}
		if (isset($args[1]) && empty($args[1])) {
			return;
		}
		CakeLog::write('se_server_shell', json_encode($args));
	}

	// Pass-through function to handle server actions
	private function host($action) {
		// Get function arguments
		$args = func_get_args();
		// Shift off the first argument because that is the function
		array_shift($args);
		// Call the desired function
		return call_user_func_array(array($this, $action), $args);
	}

	private function readServer($instanceId) {
		$this->Instance->recursive = 1;
		return $this->Instance->findById($instanceId);
	}

	private function __verifyInstanceExistence($instanceId) {
		$userDirExists = file_exists($this->serverDataDirectory . DS . $this->readServer($instanceId)['User']['username']);
		$instanceDirExists = file_exists($this->serverDataDirectory . DS . $this->readServer($instanceId)['User']['username'] . DS . $instanceId);
		// Check if user dir exists
		if (!$userDirExists) {
			return false;
		}
		// Check if instance dir exists
		if (!$instanceDirExists) {
			return false;
		}
		return true;
	}

}
