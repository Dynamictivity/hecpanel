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

<div id="person">
<?php
        echo $ajax->form(array('type' => 'post',
            'options' => array(
                'model'=>'PersonSchema',
                'update'=>'person',
                'url' => array(
                    'controller' => 'PersonSchemas',
                    'action' => 'edit'
                 )
                )
        ));
        echo $this->Form->input('dn', array('type'=>'hidden'));
        echo $this->Form->input('cn', array('label'=>'Display Name','div'=>'required'));
        echo $this->Form->input('sn', array('label'=>'Last Name', 'div'=>'required'));
        echo $this->Form->input('description');
        echo $this->Form->end('Update');
?>
</div>