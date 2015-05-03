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

App::uses('AppModel', 'Model');

class IdbrokerAppModel extends AppModel {

    public $bindDN;
    public $bindPasswd;
    public $specific = true;

    public function __construct($id = false, $table = null, $ds = null) {
        $ds = Configure::read('LDAP.Db.Config');
        $config = ConnectionManager::getDataSource($ds)->config;
        @session_start();
        //if already auth, use that login creds
        if (isset($_SESSION['Auth']['User']['bindDN']) && isset($_SESSION['Auth']['User']['bindPasswd'])) {
            $this->bindDN = $_SESSION['Auth']['User']['bindDN'];
            $this->bindPasswd = $_SESSION['Auth']['User']['bindPasswd'];
            // Set correct database name
            $config['login'] = $this->bindDN;
            $config['password'] = $this->bindPasswd;
            $dbName = 'LoggedInUser';
            // Add new config to registry
            ConnectionManager::create($dbName, $config);
            // Point model to new config
            $this->useDbConfig = $dbName;
        }

        parent::__construct($id, $table, $ds);
    }

}
