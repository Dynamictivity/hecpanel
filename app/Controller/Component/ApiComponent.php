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

class ApiComponent extends Component {

    protected $apiKey = null;
    protected $apiSecret = null;
    protected $serviceAdminId = null;

    public function __construct(ComponentCollection $collection, $settings = array()) {
        //
    }

    public function initialize(Controller $controller) {
        if ($controller->params['prefix'] == 'api_' . Configure::read(APP_CONFIG_SCOPE . '.App.apiVersion')) {
            $this->__verifyKeys($controller);
        }
    }

    public function startup(Controller $controller) {
        //
    }

    private function __verifyKeys(Controller $controller) {
        // Verify public key
        if ($controller->params['apikey'] != Configure::read(APP_CONFIG_SCOPE . '.App.apiKey')) {
            throw new NotFoundException(__('Invalid API Key'));
        }
        // Run API commands as service admin
        $this->serviceAdminId = Configure::read(APP_CONFIG_SCOPE . '.App.serviceAdminId');
        // Set private key
        $this->apiSecret = Configure::read(APP_CONFIG_SCOPE . '.App.apiSecret');
        // Set API key
        $this->apiKey = $controller->params['apikey'];
        // Log admin user in
        $controller->Auth->login(ClassRegistry::init('User')->findById($this->serviceAdminId)['User']);
        //$this->RequestHandler->setContent('json');
        $controller->RequestHandler->renderAs($controller, 'json');
        //$this->response->type('json');
    }

    public function beforeRender(Controller $controller) {
        if ($controller->params['prefix'] == 'api_v1') {
            //debug($controller->viewVars);
            $controller->set('_serialize', array_keys($controller->viewVars));
        }
    }

    public function shutdown(Controller $controller) {
        //$controller->Auth->logout();
    }

}
