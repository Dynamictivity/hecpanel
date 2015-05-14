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

/**
 * Users Controller
 */
class UsersController extends AppController {

    public function login() {
        $this->Auth->logout();
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                // Capture desired product when user logs in (if set)
                if (!empty(CakeSession::check(APP_CONFIG_SCOPE . '.desiredProductId'))) {
                    $this->User->id = AuthComponent::user('id');
                    $this->User->saveField('desired_product_id', CakeSession::read(APP_CONFIG_SCOPE . '.desiredProductId'));
                    CakeSession::delete(APP_CONFIG_SCOPE . '.desiredProductId');
                }
                return $this->redirect($this->Auth->redirect());
            }
            $this->setFlash(__('Invalid username or password, try again'), 'danger');
        }
    }

    public function signup() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->setFlash(__('Account created successfully. Please check your e-mail for the confirmation link.'));
                return $this->redirect('/');
            } else {
                $this->setFlash(__('The account could not be created. Please, try again.'), 'danger');
            }
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
        $this->Render('login');
    }

    public function eula() {
        if ($this->request->is('post')) {
            $eulaUser = $this->User->acceptEula();
            if (!empty($eulaUser) && $this->Auth->login($eulaUser)) {
                $this->setFlash(__('EULA accepted!'));
                return $this->redirect('/');
            }
            $this->setFlash(__('The EULA could not be accepted. Please, try again.'), 'danger');
        }
    }

    public function confirm($token = null) {
        $this->User->primaryKey = 'token';
        if (!$this->User->exists($token)) {
            throw new NotFoundException(__('Invalid token'));
        }
        $this->User->id = $token;
        $this->User->id = $this->User->field('id');
        $this->User->primaryKey = 'id';
        if ($this->User->saveField('role_id', Configure::read(APP_CONFIG_SCOPE . '.Users.confirmedRoleId')) && $this->User->saveField('token', null)) {
            $this->setFlash(__('Account confirmed successfully. Please log in to access your account.'));
            return $this->redirect(array('action' => 'login'));
        }
        $this->setFlash(__('The account could not be confirmed. Please, try again.'), 'danger');
    }

    public function forgot() {
        if ($this->request->is(array(
                    'post',
                    'put'
                ))) {
            if ($this->User->resetAccount($this->request->data) == 'sent') {
                $this->setFlash(__('Your account reset link has been sent to your e-mail address, please check your e-mail.'));
                return $this->redirect('/');
            } else {
                $this->setFlash(__('Your account could not be reset. Please, try again.'), 'danger');
            }
        }
    }

    public function reset($token = null) {
        $this->User->primaryKey = 'token';
        if (!$this->User->exists($token)) {
            throw new NotFoundException(__('Invalid token'));
        }
        if ($this->request->is('post')) {
            $this->User->id = $token;
            $this->request->data['User']['id'] = $this->User->field('id');
            $this->request->data['User']['token'] = null;
            $this->request->data['User']['role_id'] = Configure::read(APP_CONFIG_SCOPE . '.Users.confirmedRoleId');
            $this->User->primaryKey = 'id';
            if ($this->User->save($this->request->data)) {
                $this->setFlash(__('Password updated successfully. Please log in to access your account.'));
                return $this->redirect(array('action' => 'login'));
            }
            $this->setFlash(__('The password could not be updated. Please, try again.'), 'danger');
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @return void
     */
    public function edit() {
        $id = AuthComponent::user('id');
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array(
                    'post',
                    'put'
                ))) {
            // Verify the user knows the current password
            $storedHash = $this->User->getHashedPass();
            $newHash = Security::hash($this->request->data['User']['current_password'], 'blowfish', $storedHash);
            $correctAccountPassword = strcmp($storedHash, $newHash) == 0;
            if (!$correctAccountPassword) {
                $this->setFlash(__('The current account password is incorrect.'), 'danger');
                return;
            }
            if ($this->User->save($this->request->data)) {
                $this->setFlash(__('Your profile has been updated.'));
                return $this->redirect('/');
            } else {
                $this->setFlash(__('Your profile could not be updated. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        unset($this->request->data['User']['password']);
    }

    public function admin_login() {
        return $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false));
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function admin_logout() {
        $this->logout();
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->setFlash(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The user could not be saved. Please, try again.'), 'danger');
            }
        }
        $roles = $this->User->Role->find('list');
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
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array(
                    'post',
                    'put'
                ))) {
            if ($this->User->save($this->request->data)) {
                $this->setFlash(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The user could not be saved. Please, try again.'), 'danger');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        unset($this->request->data['User']['password']);
        $roles = $this->User->Role->find('list');
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
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->setFlash(__('The user has been deleted.'));
        } else {
            $this->setFlash(__('The user could not be deleted. Please, try again.'), 'danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

}
