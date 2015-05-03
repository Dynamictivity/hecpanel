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

if (!defined('ELEMENT_PATH')) {
                define('ELEMENT_PATH', APP_DIR.DS.'views'.DS.'elements'.DS);
        }

	//First we try blindly to render an object class.
	$ocResult = $this->element('objectclasses/'.strtolower($objectclass), array('objectclass'=>$objectclass, 'schemas'=>$schemas), true);

	if(!$ocResult){ //If their is no custom element for the objectclass then use this generic one.
                echo "<div id='$objectclass' class='genericOC'>";
                echo $this->Form->create();
                echo $this->Form->input('dn', array('type'=>'hidden'));
                foreach($schemas['objectclasses'][strtolower($objectclass)]['may'] as $attribute){
                        echo $this->Form->input(strtolower($attribute));
                }
                foreach($schemas['objectclasses'][strtolower($objectclass)]['must'] as $attribute){
                        echo $this->Form->input(strtolower($attribute));
                }
                echo $this->Form->end('Update');
                echo "</div>";
	}else{ //If we did find and render a object class with out previous call, lets show it
		print $ocResult;
	}
?>
