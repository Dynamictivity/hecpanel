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

<div id="Forms">
<?php
	$shells = array('/bin/bash'=>'Bash', '/bin/csh'=>'Csh', '/bin/tcsh'=>'Tcsh', '/bin/sh'=>'Sh', '/bin/ksh'=>'Ksh', '/usr/lib/sftp-server'=>'Sftp-only');
	echo $this->Form->create('Person',array('action'=>'add'))."\n";

	echo $this->Form->input('cn', array('label'=> 'Display Name', 'div'=> 'required', 'title'=>'A single word name for the description.'))."\n";

	echo $this->Form->input('givenname', array('label'=>'First Name', 'title'=> 'The account Holders first name.'))."\n";

	echo $this->Form->input('sn', array('label'=>'Last Name', 'div'=> 'required', 'title'=> 'The account Holders last/family name.'))."\n";

	echo $this->Form->input('uid', array('label'=>'User Name', 'div'=> 'required',  'title'=>'Account login name, ex: jdoe'))."\n";

	echo $this->Form->input('mail', array('label'=>'Email Address', 'div'=> 'required',  'title'=>'Peoples contact email address.'))."\n";

	echo $this->Form->input('uidnumber', array('label'=>'User ID Number', 'div'=> 'required',  'title'=>'Unix Style People ID Number.'))."\n";

	echo $this->Form->input('gidnumber', array('label'=>'Default Group', 'div'=> 'required', 'options'=>$groups, 'title'=>'Unix Style Group ID Number.'))."\n";
        
	echo $this->Form->input('loginshell', array('label'=>'Login Shell', 'div'=> 'required', 'options'=>$shells, 'title'=>'Unix Shell You Are Most Comfortable With.'))."\n";

	echo $this->Form->input('password', array('label'=>'Password',  'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret People Password'))."\n";

	echo $this->Form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret People Password'))."\n";
	echo $this->Form->end('Create User')."\n";
?>
</div>
