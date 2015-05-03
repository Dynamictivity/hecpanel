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
 * InstanceTypes Controller
 *
 * @property InstanceType $InstanceType
 * @property PaginatorComponent $Paginator
 */
class InstanceTypesController extends InstancesAppController {

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
        $this->InstanceType->recursive = 0;
        $this->set('instanceTypes', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->InstanceType->create();
            if ($this->InstanceType->save($this->request->data)) {
                $this->setFlash(__('The instance type has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance type could not be saved. Please, try again.'), 'danger');
            }
        }
        // Set form configuration options
        $this->set($this->SEServer->getConfigOptions('SessionSettings'));
    }

    public function admin_duplicate($id = null) {
        if (!$this->InstanceType->exists($id)) {
            throw new NotFoundException(__('Invalid instance type'));
        }
        $this->request->data['InstanceType'] = $this->InstanceType->findById($id)['InstanceType'];
        unset($this->request->data['InstanceType']['id']);
        $this->request->data['InstanceType']['name'] .= '_Clone';
        $this->InstanceType->create();
        if ($this->request->is(array('post', 'put'))) {
            if ($this->InstanceType->save($this->request->data)) {
                $this->setFlash(__('The instance type has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance type could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('InstanceType.' . $this->InstanceType->primaryKey => $id));
            $this->request->data = $this->InstanceType->find('first', $options);
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
        if (!$this->InstanceType->exists($id)) {
            throw new NotFoundException(__('Invalid instance type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->InstanceType->save($this->request->data)) {
                $this->setFlash(__('The instance type has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The instance type could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('InstanceType.' . $this->InstanceType->primaryKey => $id));
            $this->request->data = $this->InstanceType->find('first', $options);
        }
        // Set form configuration options
        $this->set($this->SEServer->getConfigOptions('SessionSettings'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->InstanceType->id = $id;
        if (!$this->InstanceType->exists()) {
            throw new NotFoundException(__('Invalid instance type'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->InstanceType->delete()) {
            $this->setFlash(__('The instance type has been deleted.'));
        } else {
            $this->setFlash(__('The instance type could not be deleted. Please, try again.'), 'danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

}
