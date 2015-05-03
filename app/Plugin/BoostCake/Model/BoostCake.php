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

App::uses('AppModel', 'Model');

class BoostCake extends AppModel {

    public $useTable = false;
    protected $_schema = array(
        'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '10'),
        'text' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
        'email' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
        'password' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
        'price' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '10'),
        'textarea' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
        'checkbox' => array('type' => 'boolean', 'null' => false, 'default' => false),
        'remember' => array('type' => 'boolean', 'null' => false, 'default' => false),
        'select' => array('type' => 'integer', 'length' => '10', 'null' => true),
        'radio' => array('type' => 'integer', 'length' => '10', 'null' => true),
        'datetime' => array('type' => 'datetime')
    );

}
