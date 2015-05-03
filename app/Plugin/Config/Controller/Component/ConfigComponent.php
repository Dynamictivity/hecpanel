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

App::uses('Component', 'Controller');

class ConfigComponent extends Component {

    public $components = array('Auth');
    private $Configuration = null;

    public function __construct(ComponentCollection $collection, $settings = array()) {
        //
    }

    public function initialize(Controller $controller) {
        $this->__checkEulaAcceptance($controller);
        $this->Configuration = ClassRegistry::init('Configuration');
        $this->__secureActions($controller);
    }

    private function __checkEulaAcceptance(Controller $controller) {
        if ($controller->Auth->user('id') && !$controller->Auth->user('eula_accepted') && !in_array($controller->action, array('logout', 'eula'))) {
            $controller->redirect(array('controller' => 'users', 'action' => 'eula', 'plugin' => false, 'admin' => false));
        }
    }

    private function __secureActions(Controller $controller) {
        // Scale permissions up, inherit permissions of lesser roles, all permissions are whitelist only
        $configurationActions = $this->Configuration->find('all', array(
            'conditions' => array(
                'Configuration.configuration_scope' => APP_CONFIG_SCOPE . '.Controller.' . $controller->name,
                'Configuration.name' => 'allowedActions',
                'OR' => array(
                    'Configuration.role_id' => $controller->Auth->user('role_id'),
                    'Configuration.role_id >' => $controller->Auth->user('role_id'),
                    'Configuration.role_id IS NULL'
                )
            )
        ));
        $allowedActions = array();
        foreach ($configurationActions as $configurationAction) {
            $allowedActions = array_merge($allowedActions, explode(',', $configurationAction['Configuration']['value']));
        }
        if (!empty($allowedActions)) {
            $controller->Auth->allowedActions = array_merge($controller->Auth->allowedActions, $allowedActions);
        }
    }

}
