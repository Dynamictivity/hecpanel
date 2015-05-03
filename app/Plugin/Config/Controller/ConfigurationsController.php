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

App::uses('AppController', 'Controller');

/**
 * Configurations Controller
 *
 * @property Configuration $Configuration
 * @property PaginatorComponent $Paginator
 */
class ConfigurationsController extends AppController {

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Configuration->recursive = 0;
        $this->set('configurations', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Configuration->create();
            if ($this->Configuration->save($this->request->data)) {
                $this->setFlash(__('The configuration has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The configuration could not be saved. Please, try again.'), 'danger');
            }
        }
        $roles = $this->Configuration->Role->find('list');
        $this->set(compact('roles'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Configuration->exists($id)) {
            throw new NotFoundException(__('Invalid configuration'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Configuration->save($this->request->data)) {
                $this->setFlash(__('The configuration has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The configuration could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('Configuration.' . $this->Configuration->primaryKey => $id));
            $this->request->data = $this->Configuration->find('first', $options);
        }
        $roles = $this->Configuration->Role->find('list');
        $this->set(compact('roles'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Configuration->id = $id;
        if (!$this->Configuration->exists()) {
            throw new NotFoundException(__('Invalid configuration'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Configuration->delete()) {
            $this->setFlash(__('The configuration has been deleted.'));
        } else {
            $this->setFlash(__('The configuration could not be deleted. Please, try again.'), 'danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

}
