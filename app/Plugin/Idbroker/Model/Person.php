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

class Person extends IdbrokerAppModel {

    public $name = 'Person';
    public $useDbConfig = 'ldap';
    // This would be the ldap equivalent to a primary key if your dn is
    // in the format of uid=username, ou=people, dc=example, dc=com
    public $primaryKey = 'uid';
    // The table would be the branch of your basedn that you defined in
    // the database config
    public $useTable = '';
    public $validate = array(
        'cn' => array(
            'alphaNumeric' => array(
                'rule' => array('custom', '/^[a-zA-Z ]+$/'),
                'required' => true,
                'on' => 'create',
                'message' => 'Only Letters, Numbers and spaces	 can be used for Display Name.'
            ),
            'between' => array(
                'rule' => array('between', 5, 40),
                'on' => 'create',
                'message' => 'Between 5 to 40 characters'
            )
        ),
        'sn' => array(
            'rule' => array('custom', '/^[a-zA-Z]*$/'),
            'required' => true,
            'on' => 'create',
            'message' => 'Only Letters and Numbers can be used for Last Name.'
        ),
        'userpassword' => array(
            'rule' => array('minLength', '8'),
            'message' => 'Mimimum 8 characters long.'
        ),
        'uid' => array(
            'rule' => array('custom', '/^[a-zA-Z0-9]*$/'),
            'required' => true,
            'on' => 'create',
            'message' => 'Only Letters and Numbers can be used for Username.'
        )
    );

}
