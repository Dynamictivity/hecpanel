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

App::uses('IdbrokerAppController', 'Idbroker.Controller');

class GroupsController extends IdbrokerAppController {

    public $name = 'Groups';
    public $components = array('Idbroker.Ldap');

    public function add() {
        if (!empty($this->request->data)) {

            $this->request->data['Group']['objectclass'] = array('top', 'groupofuniquenames', 'posixgroup');

            if (isset($this->request->data['Group']['description']) && empty($this->request->data['Group']['description'])) {
                unset($this->request->data['Group']['description']);
            }

            if (isset($this->request->data['Group']['members']) && empty($this->request->data['Group']['members'])) {
                unset($this->request->data['Group']['members']);
            } elseif (is_array($this->request->data['Group']['members'])) {
                foreach ($this->request->data['Group']['members'] as $member) {
                    $this->request->data['Group']['uniquemember'] = $member;
                    $memberuid = $this->Ldap->getUser($member);
                    $this->request->data['Group']['memberuid'] = $memberuid['uid'];
                }
            }
            unset($this->request->data['Group']['members']);
            $this->log("Trying to add group:" . print_r($this->request->data, true), 'debug');

            $cn = $this->request->data['Group']['cn'];
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash("Group $cn Was Successfully Created.");
                $id = $this->Group->id;
                $this->redirect(array('action' => 'view', 'id' => $id));
            } else {
                $this->Session->setFlash("Group $cn couldn't be created.");
            }
        }
        $attributes = array('gidnumber', 'description');
        $preset = $this->autoSet($attributes);
        $this->request->data['Group'] = $preset;
        $gusers = $this->Ldap->getUsers();
        foreach ($gusers as $user) {
            if (isset($user['uid']) && !empty($user['uid'])) {
                $users[$user['dn']] = $user['uid'];
            }
        }
        $this->set(compact('users'));
    }

    public function view($id = null) {
        if (!empty($id)) {
            $filter = $this->Group->primaryKey . "=" . $id;
            $Group = $this->Group->find('first', array('conditions' => $filter));
            $this->log("Dump of Group view: " . print_r($Group, true), 'debug');
            $this->set(compact('Group'));
        }
    }

}
