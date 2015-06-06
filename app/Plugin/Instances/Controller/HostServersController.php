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
 * HostServers Controller
 *
 * @property HostServer $HostServer
 * @property PaginatorComponent $Paginator
 */
class HostServersController extends InstancesAppController {

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->HostServer->recursive = 0;
        $this->set('hostServers', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->HostServer->exists($id)) {
            throw new NotFoundException(__('Invalid host server'));
        }
        $options = array('conditions' => array('HostServer.' . $this->HostServer->primaryKey => $id));
        $this->set('hostServer', $this->HostServer->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->HostServer->create();
            if ($this->HostServer->save($this->request->data)) {
                $this->setFlash(__('The host server has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The host server could not be saved. Please, try again.'), 'danger');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->HostServer->exists($id)) {
            throw new NotFoundException(__('Invalid host server'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->HostServer->save($this->request->data)) {
                $this->setFlash(__('The host server has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The host server could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('HostServer.' . $this->HostServer->primaryKey => $id));
            $this->request->data = $this->HostServer->find('first', $options);
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
        $this->HostServer->id = $id;
        if (!$this->HostServer->exists()) {
            throw new NotFoundException(__('Invalid host server'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->HostServer->delete()) {
            $this->setFlash(__('The host server has been deleted.'));
        } else {
            $this->setFlash(__('The host server could not be deleted. Please, try again.'), 'danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_refresh_counts method
     */
    public function admin_refresh_counts() {
        if ($this->HostServer->updateInstanceCount()) {
            $this->setFlash(__('The host server counts have been updated.'));
        } else {
            $this->setFlash(__('The host server counts could not be updated.'), 'danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

}
