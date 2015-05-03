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
 * InstanceProfiles Controller
 *
 * @property InstanceProfile $InstanceProfile
 * @property PaginatorComponent $Paginator
 */
class InstanceProfilesController extends InstancesAppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Instances.SEServer'
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->InstanceProfile->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'InstanceProfile.user_id' => AuthComponent::user('id')
            )
        );
        $this->set('instanceProfiles', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->request->data['InstanceProfile']['user_id'] = AuthComponent::user('id');
            $this->InstanceProfile->create();
            if ($this->InstanceProfile->save($this->request->data)) {
                $this->setFlash(__('The instance profile has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance profile could not be saved. Please, try again.'), 'danger');
            }
        }
        // Set form configuration options
        $this->set($this->SEServer->getConfigOptions('SessionSettings'));
    }

    public function duplicate($id = null) {
        if (!$this->InstanceProfile->exists($id)) {
            throw new NotFoundException(__('Invalid instance profile'));
        }
        $this->request->data['InstanceProfile'] = $this->InstanceProfile->findById($id)['InstanceProfile'];
        if (AuthComponent::user('role_id') > 2 && $this->request->data['InstanceProfile']['user_id'] != AuthComponent::user('id')) {
            throw new NotFoundException(__('Invalid instance profile'));
        }
        unset($this->request->data['InstanceProfile']['id']);
        $this->request->data['InstanceProfile']['name'] = $this->InstanceProfile->generateCloneName($this->request->data['InstanceProfile']['name']);
        $this->request->data['InstanceProfile']['user_id'] = AuthComponent::user('id');
        $this->InstanceProfile->create();
        if ($this->request->is(array('post', 'put'))) {
            if ($this->InstanceProfile->save($this->request->data)) {
                $this->setFlash(__('The instance profile has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance profile could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('InstanceProfile.' . $this->InstanceProfile->primaryKey => $id));
            $this->request->data = $this->InstanceProfile->find('first', $options);
        }
        $this->autoRender = false;
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        // Check ownership // TODO: Create proper method for this?
        $this->InstanceProfile->id = $id;
        if (!$this->InstanceProfile->exists($id) || (AuthComponent::user('role_id') > 2 && $this->InstanceProfile->field('user_id') !== AuthComponent::user('id'))) {
            throw new NotFoundException(__('Invalid instance profile'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->InstanceProfile->save($this->request->data)) {
                $this->setFlash(__('The instance profile has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance profile could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('InstanceProfile.' . $this->InstanceProfile->primaryKey => $id));
            $this->request->data = $this->InstanceProfile->find('first', $options);
        }
        // Set form configuration options
        $this->set($this->SEServer->getConfigOptions('SessionSettings'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->InstanceProfile->id = $id;
        // Check ownership // TODO: Create proper method for this?
        if (!$this->InstanceProfile->exists() || (AuthComponent::user('role_id') > 2 && $this->InstanceProfile->field('user_id') !== AuthComponent::user('id'))) {
            throw new NotFoundException(__('Invalid instance profile'));
        }
        $instanceCount = $this->InstanceProfile->Instance->find('count', array(
            'conditions' => array(
                'Instance.instance_profile_id' => $id
            )
                )
        );
        $this->request->allowMethod('post', 'delete');
        if (!$instanceCount && $this->InstanceProfile->delete()) {
            $this->setFlash(__('The instance profile has been deleted.'));
        } else {
            $this->setFlash(__('The instance profile could not be deleted. Please, try again.'), 'danger');
            if ($instanceCount) {
                $this->setFlash(__('The instance profile could not be deleted because it is currently in use.'), 'danger');
            }
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->InstanceProfile->recursive = 0;
        $this->set('instanceProfiles', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->add();
        $users = $this->InstanceProfile->User->find('list');
        $this->set(compact('users'));
    }

    public function admin_duplicate($id = null) {
        $this->duplicate($id);
        $this->autoRender = false;
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->edit($id);
        $users = $this->InstanceProfile->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->delete($id);
    }

}
