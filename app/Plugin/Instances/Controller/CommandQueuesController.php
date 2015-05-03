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
 * CommandQueues Controller
 *
 * @property CommandQueue $CommandQueue
 * @property PaginatorComponent $Paginator
 */
class CommandQueuesController extends InstancesAppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Instances.SEServer'
    );

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->CommandQueue->recursive = 0;
        $this->set('commandQueues', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->CommandQueue->create();
            if ($this->CommandQueue->save($this->request->data)) {
                $this->setFlash(__('The queued command has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The queued command could not be saved. Please, try again.'));
            }
        }
        $this->set($this->SEServer->getRemoteCommands());
        $hostServers = $this->CommandQueue->HostServer->find('list');
        $this->set(compact('hostServers'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->CommandQueue->exists($id)) {
            throw new NotFoundException(__('Invalid queued command'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CommandQueue->save($this->request->data)) {
                $this->setFlash(__('The queued command has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The queued command could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CommandQueue.' . $this->CommandQueue->primaryKey => $id));
            $this->request->data = $this->CommandQueue->find('first', $options);
        }
        $this->set($this->SEServer->getRemoteCommands());
        $hostServers = $this->CommandQueue->HostServer->find('list');
        $this->set(compact('hostServers'));
    }

    public function admin_reset($id = null) {
        $this->CommandQueue->id = $id;
        if (!$this->CommandQueue->exists()) {
            throw new NotFoundException(__('Invalid queued command'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CommandQueue->reset_last_executed()) {
                $this->setFlash(__('The queued command has been reset.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The queued command could not be reset. Please, try again.'));
            }
        }
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->CommandQueue->id = $id;
        if (!$this->CommandQueue->exists()) {
            throw new NotFoundException(__('Invalid queued command'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->CommandQueue->delete()) {
            $this->setFlash(__('The queued command has been deleted.'));
        } else {
            $this->setFlash(__('The queued command could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
