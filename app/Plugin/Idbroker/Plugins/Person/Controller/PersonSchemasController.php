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

class PersonSchemasController extends PersonAppController {

    var $name = 'PersonSchemas';
    var $uses = array('Person.PersonSchema');
    var $components = array('RequestHandler', 'Ldap');
    var $helpers = array('Form', 'Html', 'Javascript', 'Ajax');

    function edit($id) {
        if (!empty($this->request->data)) {
            $this->PersonSchema->id = $dn;
            $this->log("What I'm Going to save" . print_r($this->request->data['PersonSchema'], true) . "\nFor the following ID:" . $this->PersonSchema->id, 'debug');
            $result = $this->PersonSchema->save($this->request->data);
            if ($result != false) {
                $this->Session->setFlash('Your Account info has been updated.');
            } else {
                $this->Session->setFlash('Failed to update');
            }
        } else {
            $options['scope'] = 'base';
            $options['targetDn'] = $id;
            $options['conditions'] = 'objectclass=inetorgperson';
            $this->request->data = $this->PersonSchema->find('first', $options);
        }
        $this->layout = 'ajax';
    }

}
