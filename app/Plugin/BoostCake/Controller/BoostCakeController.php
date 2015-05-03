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

App::uses('AppController', 'Controller');

class BoostCakeController extends AppController {

    public $uses = array('BoostCake.BoostCake');
    public $components = array('Session');
    public $helpers = array(
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
    );

    /**
     * beforeFilter
     * @throws MethodNotAllowedException
     */
    public function beforeFilter() {
        if (Configure::read('debug') < 1) {
            throw new MethodNotAllowedException(__('Debug setting does not allow access to this url.'));
        }
        parent::beforeFilter();
    }

    public function index() {
        
    }

    public function bootstrap2() {
        $this->Session->setFlash(__('Alert notice message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
                ), 'notice');
        $this->Session->setFlash(__('Alert success message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-success'
                ), 'success');
        $this->Session->setFlash(__('Alert error message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-error'
                ), 'error');
    }

    public function bootstrap3() {
        $this->Session->setFlash(__('Alert success message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-success'
                ), 'success');
        $this->Session->setFlash(__('Alert info message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-info'
                ), 'info');
        $this->Session->setFlash(__('Alert warning message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-warning'
                ), 'warning');
        $this->Session->setFlash(__('Alert danger message testing...'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-danger'
                ), 'danger');
    }

}
