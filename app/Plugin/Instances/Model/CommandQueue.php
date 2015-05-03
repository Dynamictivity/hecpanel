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

App::uses('InstancesAppModel', 'Instances.Model');

/**
 * CommandQueue Model
 *
 * @property HostServer $HostServer
 */
class CommandQueue extends InstancesAppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'command' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'HostServer' => array(
            'className' => 'Instances.HostServer',
            'foreignKey' => 'host_server_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'LastExecutedHostServer' => array(
            'className' => 'Instances.HostServer',
            'foreignKey' => 'last_executed_host_server_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function reset_last_executed() {
        return $this->save(
                        array(
                            'last_executed' => NULL,
                            'last_executed_host_server_id' => NULL
                        )
        );
    }

    function beforeSave($options = array()) {
        if (!isset($this->data[$this->alias]['time']) || empty($this->data[$this->alias]['time']) || $this->data[$this->alias]['time'] === '') {
            $this->data[$this->alias]['time'] = '00:00:00';
        }
        return true;
    }

}
