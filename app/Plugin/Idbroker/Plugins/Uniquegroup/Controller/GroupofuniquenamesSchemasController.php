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

class GroupofuniquenamesSchemasController extends UniquegroupAppController {

    var $name = 'GroupofuniquenamesSchemas';
    var $uses = array('Uniquegroup.GroupofuniquenamesSchema');
    var $components = array('RequestHandler', 'Ldap');
    var $helpers = array('Form', 'Html', 'Javascript', 'Ajax');

    function edit($id) {
        if (!empty($this->request->data)) {
            if (isset($this->request->data['GroupofuniquenamesSchema']['dn']) && !empty($this->request->data['GroupofuniquenamesSchema']['dn'])) {
                $id = $this->request->data['GroupofuniquenamesSchema']['dn'];
            }
            $this->GroupofuniquenamesSchema->id = $id;
            unset($this->request->data['GroupofuniquenamesSchema']['nonuniquemember']);
            $result = $this->GroupofuniquenamesSchema->save($this->request->data);
            if ($result != false) {
                $this->Session->setFlash('Your Unique Group has been updated.');
            } else {
                $this->Session->setFlash('Failed to update');
            }
        }

        $options['targetDn'] = $id;
        $options['scope'] = 'base';
        $this->request->data = $this->GroupofuniquenamesSchema->find('first', $options);
        $members = $this->Ldap->getUsers(array('uid', 'cn'), $id, 'uniquemember');
        foreach ($members as $member) {
            $group['members'][$member['dn']] = $member['cn'];
        }
        $nonmembers = $this->Ldap->getUsers(array('uid', 'cn'));
        foreach ($nonmembers as $nonmember) {
            if (!isset($group['members'][$nonmember['dn']])) {
                $group['nonmembers'][$nonmember['dn']] = $nonmember['cn'];
            }
        }
        //Remove Users already in this group role
        $this->set('groups', $group);
        $this->layout = 'ajax';
    }

}
