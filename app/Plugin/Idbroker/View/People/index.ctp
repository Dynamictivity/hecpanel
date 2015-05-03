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

echo $this->Html->css('style');?>


<div id="cabledbManage">
    <ul id="tabmenu">
		<?php echo $this->element('userMenu');?>
    </ul>
<?php
/*
	<ul id="tabmenu">
		<li> <?php echo $this->Html->link('My Profile', '/users/myprofile', array('class'=>'active')); ?>
		<li> <?php echo $this->Html->link('Cables',  '/cables/index', array('class'=>'button')); ?>
		<li> <?php echo $this->Html->link('System',  '/systems/index', array('class'=>'button')); ?>
                <li> <?php echo $this->Html->link('Subsystem',  '/subsystems/index', array('class'=>'button')); ?>
		<li> <?php echo $this->Html->link('Types',   '/types/index', array('class'=>'button')); ?>
	</ul>
*/
?>


    <div id="UserPaging" class="Paging">
		<?php echo $this->element('users/myprofile');?>
    </div>
    <div>
