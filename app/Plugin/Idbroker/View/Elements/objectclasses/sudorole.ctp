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

<script type="text/javascript">

    $().ready(function () {
        var sudoDN = '<?php echo $this->request->data['Browser']['dn'];?>';
        var gUrl = '<?php echo $this->Html->url('/browsers/sudoSelect/');?>' + sudoDN;
        $('#sudoSelectBox').html(geturl(gUrl));

    });
</script>

<style type="text/css">

    #uniqueMemberSelectBox {
        clear: none;
        text-align: center;
        margin: 10px;
        white-space: nowrap;
    }
</style>

<?php
	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay', 'before'=>'submitSelected();'));
	echo $this->Form->input('dn', array('type'=>'hidden'));

	echo $this->Form->input('cn', array('label'=> 'Name', 'div'=>'required', 'title'=>'A single word name for the description.'));

	echo $this->Form->input('description', array('title'=>'Provides a human-readable description of the Sudo Role. For example: These users can reset passwords for other people.'));

	echo $this->Form->input('sudocommand', array('label'=>'Command', 'title'=>'The command that people in this sudo role can run.  For example: /usr/bin/passwd or ALL for all commands'));


	echo $this->Form->input('sudorunasuser', array('label'=> 'Run As User', 'title'=>'A user name or uid (prefixed with \'#\') that commands may be run as or a Unix group (prefixed with a \'%\') or user netgroup (prefixed with a \'+\') that contains a list of users that commands may be run as. The special value ALL will match any user.'));


?>
<div id="sudoSelectBox"></div>
<?php


	echo $this->Form->end('Update');
                echo "</div>";
?>
