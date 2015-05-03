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

class PosixSettingsController extends PosixAppController {

    var $name = 'PosixSettings';
    var $uses = array('Posix.PosixSetting');
    var $components = array('RequestHandler', 'SettingsHandler');
    var $helpers = array('Form', 'Html', 'Javascript', 'Ajax');
    var $uuidCallback = '/posix/PosixaccountSchema/findUniqueUidNumber';
    var $ugidCallback = '/posix/PosixgroupSchema/findUniqueGidNumber';
    var $groupSyncCallback = '/posix/PosixgroupSchema/syncGroup';

    function index() {
        if (!empty($this->request->data)) {
            $this->log("Trying To Save Settings:" . print_r($this->request->data, true), 'debug');
            if ($this->request->data['PosixSetting']['autouidnumber'] == true) {
                $this->SettingsHandler->AutoSet('uidnumber', $this->uuidCallback);
            }
            if ($this->request->data['PosixSetting']['autogidnumber'] == true) {
                $this->SettingsHandler->AutoSet('gidnumber', $this->ugidCallback);
            }
            if ($this->request->data['PosixSetting']['syncwithuniquemember'] == true) {
                $this->SettingsHandler->SyncWith('uniquemember', $this->groupSyncCallback, array('dn'));
            }
            unset($this->request->data['PosixSetting']['autouidnumber']);
            unset($this->request->data['PosixSetting']['autogidnumber']);
            unset($this->request->data['PosixSetting']['syncwithuniquemember']);

            $this->SettingsHandler->setSettings($this->request->data);
        }
        $settings = $this->SettingsHandler->getSettings();
        $this->request->data = $settings;
        if ($this->SettingsHandler->isAutoSet('uidnumber', $this->uuidCallback)) {
            $this->request->data['PosixSetting']['autouidnumber'] = true;
        }
        if ($this->SettingsHandler->isAutoSet('gidnumber', $this->ugidCallback)) {
            $this->request->data['PosixSetting']['autogidnumber'] = true;
        }
        if ($this->SettingsHandler->isSyncWith('uniquemember', $this->groupSyncCallback)) {
            $this->request->data['PosixSetting']['syncwithuniquemember'] = true;
        }
        $this->log("Posix Settings:" . print_r($this->request->data, true), 'debug');
    }

}
