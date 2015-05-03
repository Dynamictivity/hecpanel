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

App::uses('IdbrokerAppModel', 'Idbroker.Model');

class Group extends IdbrokerAppModel {

    public $name = 'Group';
    public $useDbConfig = 'ldap';
    public $primaryKey = 'cn';     // Adapt this parameter to your data
    public $useTable = 'ou=Groups'; // Adapt this parameter to your data
    public $validate = array(
        'cn' => array(
            'rule' => array('custom', '/^[a-zA-Z0-9]*$/'),
            'required' => true,
            'on' => 'create',
            'message' => 'Group names must be alpha numeric.'
        ),
        'gidnumber' => array(
            'rule' => array('custom', '/^[0-9]*$/'),
            'required' => true,
            'on' => 'create',
            'message' => 'Group ID number must be numeric.'
        ),
    );

}
