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

class ShadowaccountSchemasController extends ShadowAppController {

    var $name = 'ShadowaccountSchemas';
    var $uses = array('Shadow.ShadowaccountSchema');
    var $components = array('RequestHandler', 'Ldap');
    var $helpers = array('Form', 'Html', 'Javascript', 'Ajax');

    function edit($id) {
        if (!empty($this->request->data)) {
            if (isset($this->request->data['ShadowaccountSchema']['dn']) && !empty($this->request->data['ShadowaccountSchema']['dn'])) {
                $this->ShadowaccountSchema->id = $this->request->data['ShadowaccountSchema']['dn'];
            }

            if (isset($this->request->data['ShadowaccountSchema']['shadowlastchange']) && !empty($this->request->data['ShadowaccountSchema']['shadowlastchange'])) {
                $this->request->data['ShadowaccountSchema']['shadowlastchange'] = ceil(strtotime($this->request->data['ShadowaccountSchema']['shadowlastchange']) / 86400);
            }
            if (isset($this->request->data['ShadowaccountSchema']['shadowexpire']) && !empty($this->request->data['ShadowaccountSchema']['shadowexpire'])) {
                $this->request->data['ShadowaccountSchema']['shadowexpire'] = ceil(strtotime($this->request->data['ShadowaccountSchema']['shadowexpire']) / 86400);
            }
            $result = $this->ShadowaccountSchema->save($this->request->data);
            if ($result != false) {
                $this->Session->setFlash('Your shadow settings have been updated.');
            } else {
                $this->Session->setFlash('Failed to update');
            }
        } else {
            $options['scope'] = 'base';
            $options['targetDn'] = $id;
            $options['conditions'] = 'objectclass=Shadowaccount';
            $this->request->data = $this->ShadowaccountSchema->find('first', $options);
        }

        $this->layout = 'ajax';
    }

}
