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
        var groupDN = '<?php echo $this->request->data['Browser']['dn'];?>';
        var gUrl = '<?php echo $this->Html->url('/browsers/groupSelect/');?>' + groupDN + '/posixgroup';
        ;
        $('#memberUidSelectBox').html(geturl(gUrl));

    });

</script>

<style type="text/css">

    #memberUidSelectBox {
        clear: none; 
        text-align: center;  
        margin: 10px;  
        white-space: nowrap;
    }  

</style>

<?php 
        $attr = 'memberuid';
        $memberid = substr($this->name,0,-1).ucwords($attr);

	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay', 'before'=>'select'.$memberid.'();'));
	echo $this->Form->input('dn', array('type'=>'hidden'));

	echo $this->Form->input('cn', array('label'=> 'Name', 'div'=> 'required', 'title'=>'A single word name for the description.'));

	echo $this->Form->input('description', array('title'=>'Provides a human-readable description of the purpose of this group.'));

	echo $this->Form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required',  'title'=>'Unix Style Group ID Number.'));
?>
<div id="memberUidSelectBox"></div>
<?php
	echo $this->Form->end('Update');
                echo "</div>";
?>
