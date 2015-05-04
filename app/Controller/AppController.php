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

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 */
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array(
        'Config.Config',
        'Api',
        'Paginator',
        'Session',
        'Auth' => array(
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'flash' => array(
                'element' => 'alert',
                'key' => 'auth',
                'params' => array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                )
            ),
            'authenticate' => array(
                'Form' => array('passwordHasher' => 'Blowfish'),
                //'Idbroker.Ldap' => array('userModel' => 'Idbroker.LdapAuth'),
            ),
            'authorize' => 'Controller'
        ),
        'RequestHandler',
    );
    public $helpers = array(
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm',
            'inputDefaults' => array(
                'div' => 'form-group',
                'label' => array(
                    'class' => 'col col-md-3 control-label'
                ),
                'wrapInput' => 'col col-md-9',
                'class' => 'form-control'
            ),
        ),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Time'
    );

    // Alert
    // Types: success, info, warning, danger
    protected function setFlash($message, $type = 'success', $showMessagePrefix = true) {
        $messagePrefix = null;
        if ($showMessagePrefix) {
            $messagePrefix = '<span class="glyphicon glyphicon-exclamation-sign"></span> <strong>' . ucfirst($type) . ':</strong> ';
        }
        $this->Session->setFlash($messagePrefix . $message, 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-' . $type
        ));
    }

    public function isAuthorized($user = null) {
        // Admin can access every action
        if ($user && $user['role_id'] == 1) {
            $this->Auth->allow();
            return true;
        }
    }

    public function beforeRender() {
        parent::beforeRender();
    }

}
