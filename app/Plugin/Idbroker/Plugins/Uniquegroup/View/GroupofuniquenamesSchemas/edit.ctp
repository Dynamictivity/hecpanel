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

<div id="groupofuniquenames">
    <style type="text/css">

        #memberUidSelectBox {
            clear: none;
            text-align: center;
            margin: 10px;
            white-space: nowrap;
        }

    </style>

<?php
        $attr = 'uniquemember';
        $memberid = substr($this->name,0,-1).ucwords($attr);

        echo $ajax->form(array('type' => 'post',
            'options' => array(
                'model'=>'GroupofuniquenamesSchema',
                'update'=>'groupofuniquenames',
				'before'=>'select'.$memberid.'();',
                'url' => array(
                    'controller' => 'GroupofuniquenamesSchemas',
                    'action' => 'edit'
                 )
                )
        ));

        echo $this->Form->input('dn', array('type'=>'hidden'));

        echo $this->Form->input('cn', array('label'=> 'Name', 'div'=> 'required', 'title'=>'A single word name for the description.'));

        echo $this->Form->input('description', array('title'=>'Provides a human-readable description of the purpose of this group.'));
?>
    <div id="memberUidSelectBox"><?php


	$attr = 'uniquemember';
        $model = 'GroupofuniquenamesSchema';
        $nonmemberid = $model.'Non'.$attr;
        $memberid = $model.ucwords($attr);


        $members = $groups['members'];
        $nonmembers = $groups['nonmembers'];
?>
        <script type="text/javascript">

            $().ready(function () {
                $('#<?php echo $attr;?>add').click(function () {
                    return !$('#<?php echo $nonmemberid;?> option:selected').remove().appendTo('#<?php echo $memberid;?>');
                });
                $('#<?php echo $attr;?>remove').click(function () {
                    return !$('#<?php echo $memberid;?> option:selected').remove().appendTo('#<?php echo $nonmemberid;?>');
                });
            });
            function select<?php echo $memberid;?>() {
                $("#<?php echo $memberid;?>").each(function () {
                    $("#<?php echo $memberid;?> option").attr("selected", "selected");
                });
                return true;
            }
        </script>

        <style type="text/css">
            div.memberSelect{
                display: inline;
                clear: none;
                float: left;
            }

            select#<?php echo $nonmemberid;?>, select#<?php echo $memberid;?> {
                width: 250px;
                height: 250px;
            }
        </style>
        <div class="memberSelect">
                <?php echo $this->Form->input($model.'.non'.$attr, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Non-Members', 'options'=>$nonmembers)); ?>
            <a href="#" id="<?php echo $attr;?>add">add &gt;&gt;</a>
        </div>
        <div class="memberSelect">
                <?php echo $this->Form->input($model.'.'.$attr, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Members', 'options'=>$members)); ?>
            <a href="#" id="<?php echo $attr;?>remove">&lt;&lt; remove</a>
        </div>
    </div>
<?php
        echo $this->Form->end('Update');
?>
</div>