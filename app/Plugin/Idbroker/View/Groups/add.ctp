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
	echo $this->Form->create('Group', array('url' => '/groups/add'));

	echo $this->Form->input('cn', array('type' => 'text', 'label' => 'Group Name', 'div' => 'required', 'title' => 'The Name of the Group You Are Creating.'));

	echo $this->Form->input('description', array('type' => 'text', 'label' => 'Description', 'title' => 'Description of the purpose for this Group.'));

	echo $this->Form->input('gidnumber', array('type' => 'text', 'label' => 'Group ID Number', 'div' => 'required', 'title' => 'Unix Style Group ID Number, must be Unique..'));

	echo $this->Form->input('members', array('label' => 'Group Members', 'type' => 'select', 'multiple' => 'true', 'options' => $users, 'div' => 'required', 'title' => 'Users That Should Belong To This Group.'));

	echo $this->Form->end('Create Group');
	echo "</div>";
	?>
</div>