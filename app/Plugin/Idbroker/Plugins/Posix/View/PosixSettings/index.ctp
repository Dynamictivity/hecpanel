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

echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'PosixSetting',
	        'update'=>'posix_settings',
	        'url' => array(
	            'controller' => 'PosixSettings',
	            'action' => 'index'
	         )
		)
	));
	
	echo $this->Form->input('autouidnumber', array('label'=>'Auto-Generate User Id Number?', 'type'=>'checkbox'));
	echo $this->Form->input('uidnumbermin', array('label'=>'Minimum ID number for user ID'));
	echo $this->Form->input('uidnumbermax', array('label'=>'Maximum ID number for user ID'));
	echo $this->Form->input('syncwithuniquemember', array('label'=>'Keep Unix group members in sync with LDAP Group Members', 'type'=>'checkbox'));
	echo $this->Form->input('autogidnumber', array('label'=>'Auto-Generate Group Id Number?', 'type'=>'checkbox'));
	echo $this->Form->input('gidnumbermin', array('label'=>'Minimum group ID number'));
	echo $this->Form->input('gidnumbermax', array('label'=>'Maximum group ID number'));
	echo $this->Form->end('Update');