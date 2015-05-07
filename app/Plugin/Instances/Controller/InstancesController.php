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

App::uses('InstancesAppController', 'Instances.Controller');

/**
 * Instances Controller
 *
 * @property Instance $Instance
 * @property PaginatorComponent $Paginator
 */
class InstancesController extends InstancesAppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Instances.SEServer',
    );

    public function beforeFilter() {
        parent::beforeFilter();
        if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour') && AuthComponent::user('role_id') > 2) {
            $this->setFlash(__('Currently undergoing maintenance, please check back shortly.'), 'warning');
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Instance->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'Instance.user_id' => AuthComponent::user('id')
            )
        );
        $instanceList = $this->Paginator->paginate();
        $updatedInstanceList = array();
        foreach ($instanceList as $instance) {
            $instance['Instance']['status'] = $this->SEServer->server('processState', $instance['Instance']['id']);
            $updatedInstanceList[] = $instance;
        }
        $this->set('instances', $updatedInstanceList);
        $this->Instance->User->id = AuthComponent::user('id');
        $this->set('desiredProductId', $this->Instance->User->field('desired_product_id'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Instance->recursive = 0;
        $instanceList = $this->Paginator->paginate();
        $updatedInstanceList = array();
        foreach ($instanceList as $instance) {
            //$instance['Instance']['status'] = $this->SEServer->server('processState', $instance['Instance']['id']);
            $updatedInstanceList[] = $instance;
        }
        $this->set('instances', $updatedInstanceList);
    }

    public function api_v1_index() {
        $this->admin_index();
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
            throw new NotFoundException(__('Currently undergoing maintenance, please check back shortly.'));
        }
        $this->Instance->User->id = AuthComponent::user('id');
        $desiredProductId = $this->Instance->User->field('desired_product_id');
        if (!$desiredProductId) {
            $this->setFlash(__('You must first select an instance type.'), 'warning');
            return $this->redirect(array('controller' => 'products', 'action' => 'index', 'plugin' => 'shop', 'admin' => false));
        }
        if (!$this->Instance->InstanceType->Product->exists($desiredProductId)) {
            throw new NotFoundException(__('Invalid instance type'));
        }
        // TODO: refactor
        $product = $this->Instance->InstanceType->Product->find('first', array('conditions' => array('Product.' . $this->Instance->InstanceType->Product->primaryKey => $desiredProductId)));
        $this->set('product', $product);
        $instanceType = $this->Instance->InstanceType->find('first', array('conditions' => array('InstanceType.id' => $product['Product']['instance_type_id'])));
        unset($instanceType['InstanceType']['id'], $instanceType['InstanceType']['created'], $instanceType['InstanceType']['updated']);
        $this->set('instanceType', $instanceType['InstanceType']);
        // end refactor
        if ($this->request->is('post')) {
            if (!empty($product['Product']['instance_type_id'])) {
                $this->request->data['Instance']['instance_type_id'] = $product['Product']['instance_type_id'];
            }
            // Remove pending product
            $this->Instance->User->saveField('desired_product_id', NULL);
            $this->__createInstance();
        }
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
            throw new NotFoundException(__('Currently undergoing maintenance, please check back shortly.'));
        }
        if ($this->request->is('post')) {
            $this->__createInstance();
        }
        $users = $this->Instance->User->find('list');
        $hostServers = $this->Instance->HostServer->find('list');
        $instanceTypes = $this->Instance->InstanceType->find('list');
		$games = $this->SEServer->getGameList();
        $this->set(compact('users', 'hostServers', 'instanceTypes', 'games'));
    }

    private function __createInstance() {
        $this->setFlash($this->SEServer->createInstance($this->request->data));
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_spawn($instanceId = null) {
        if (!$this->Instance->exists($instanceId)) {
            throw new NotFoundException(__('Invalid instance'));
        }
        $this->setFlash($this->SEServer->server('spawn', $instanceId));
        return $this->redirect(array('action' => 'index'));
    }

    public function api_v1_spawn($instanceId = null) {
        if (!$this->Instance->exists($instanceId)) {
            throw new NotFoundException(__('Invalid instance'));
        }
        $this->set('Message', $this->SEServer->server('spawn', $instanceId));
    }

    public function admin_sync_mounts() {
        $this->setFlash($this->SEServer->syncUserMountPoints());
        return $this->redirect(array('action' => 'index'));
    }

    public function edit($id = null) {
        if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
            throw new NotFoundException(__('Currently undergoing maintenance, please check back shortly.'));
        }
        if (!$this->Instance->exists($id) | !$this->SEServer->checkOwnership($id)) {
            throw new NotFoundException(__('Invalid instance'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Instance->save($this->request->data)) {
                $this->cycle($id);
                $this->setFlash(__('The instance has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('Instance.' . $this->Instance->primaryKey => $id));
            $this->request->data = $this->Instance->find('first', $options);
        }
        $instanceProfiles = $this->Instance->InstanceProfile->find('list', array('conditions' => array('InstanceProfile.user_id' => AuthComponent::user('id'))));
        $this->set(compact('instanceProfiles'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
            throw new NotFoundException(__('Currently undergoing maintenance, please check back shortly.'));
        }
        if (!$this->Instance->exists($id) | !$this->SEServer->checkOwnership($id)) {
            throw new NotFoundException(__('Invalid instance'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->SEServer->server('stop', $id, true);
            // Find open port on destination host and set to instance
            $this->request->data['Instance']['port'] = $this->SEServer->findOpenPort($this->request->data['Instance']['host_server_id']);
            if ($this->Instance->save($this->request->data)) {
                $this->SEServer->server('cycle', $id);
                $this->setFlash(__('The instance has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('Instance.' . $this->Instance->primaryKey => $id));
            $this->request->data = $this->Instance->find('first', $options);
        }
        $users = $this->Instance->User->find('list');
        $hostServers = $this->Instance->HostServer->find('list');
        $instanceProfiles = $this->Instance->InstanceProfile->find('list');
        $instanceTypes = $this->Instance->InstanceType->find('list');
		$games = $this->SEServer->getGameList();
        $this->set(compact('users', 'hostServers', 'instanceProfiles', 'instanceTypes', 'games'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
            throw new NotFoundException(__('Currently undergoing maintenance, please check back shortly.'));
        }
        $this->Instance->id = $id;
        if (!$this->Instance->exists()) {
            throw new NotFoundException(__('Invalid instance'));
        }
        $this->request->allowMethod('post', 'delete');
        $this->SEServer->server('stop', $id, true);
        if ($this->Instance->delete()) {
            $this->setFlash(__('The instance has been deleted.'));
        } else {
            $this->setFlash(__('The instance could not be deleted. Please, try again.'), 'danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function instance_log($instanceId = null) {
        if (!$this->Instance->exists($instanceId) | !$this->SEServer->checkOwnership($instanceId)) {
            throw new NotFoundException(__('Invalid instance'));
        }
        $instanceLog = $this->SEServer->server('getLogs', $instanceId);
        $this->set(compact('instanceProfiles', 'instanceLog'));
        $this->render('instance_log');
    }

    public function admin_instance_log($instanceId = null) {
        $this->instance_log($instanceId);
    }

    public function api_v1_instance_log($instanceId = null) {
        $this->set('Message', $this->SEServer->server('getLogs', $instanceId));
    }

    public function start($instanceId = null) {
        $this->autoRender = false;
        //$this->SEServer->simulateRemoteApiCall = true;
        $this->setFlash($this->SEServer->server('cycle', $instanceId), 'warning', false);
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_start($instanceId = null) {
        $this->start($instanceId);
    }

    public function api_v1_start($instanceId = null) {
        $this->set('Message', $this->SEServer->server('cycle', $instanceId));
    }

    public function stop($instanceId = null) {
        $this->autoRender = false;
        //$this->SEServer->simulateRemoteApiCall = true;
        $this->setFlash($this->SEServer->server('stop', $instanceId, true), 'warning', false);
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_stop($instanceId = null) {
        $this->stop($instanceId);
    }

    public function api_v1_stop($instanceId = null) {
        $this->set('Message', $this->SEServer->server('stop', $instanceId, true));
    }

    public function cycle($instanceId = null) {
        $this->autoRender = false;
        //$this->SEServer->simulateRemoteApiCall = true;
        $this->setFlash($this->SEServer->server('cycle', $instanceId), 'info');
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_cycle($instanceId = null) {
        $this->cycle($instanceId);
    }

    public function api_v1_cycle($instanceId = null) {
        $this->set('Message', $this->SEServer->server('cycle', $instanceId));
    }

    public function check($instanceId = null) {
        $this->autoRender = false;
        //$this->SEServer->simulateRemoteApiCall = true;
        $this->setFlash($this->SEServer->server('processState', $instanceId), 'info');
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_check($instanceId = null) {
        $this->check($instanceId);
    }

    public function api_v1_check($instanceId = null) {
        $this->set('Message', $this->SEServer->server('processState', $instanceId));
    }

    public function reroll($instanceId = null) {
        $this->autoRender = false;
        //$this->SEServer->simulateRemoteApiCall = true;
        $this->setFlash($this->SEServer->server('reroll', $instanceId), 'info');
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_reroll($instanceId = null) {
        $this->reroll($instanceId);
    }

    public function api_v1_reroll($instanceId = null) {
        $this->set('Message', $this->SEServer->server('reroll', $instanceId));
    }

    public function admin_maintenance($start = null) {
        Cache::delete(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour');
        if ($start == 'start') {
            Cache::write(APP_CONFIG_SCOPE . '.App.maintenanceMode', true, 'hour');
            $this->setFlash(__('Maintenance mode enabled for 1 hour.'));
        }
        if (!Cache::read(APP_CONFIG_SCOPE . '.App.maintenanceMode', 'hour')) {
            $this->setFlash(__('Maintenance mode disabled.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
