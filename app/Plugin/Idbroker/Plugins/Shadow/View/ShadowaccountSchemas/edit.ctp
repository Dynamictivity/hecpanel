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

<div id="shadowaccount">
<?php echo $javascript->link('/js/jquery.phpdate.js')."\n"; ?>
    <script type="text/javascript">

        function getint(v) {
            if (v < 0) {
                return(Math.ceil(v));
            } else {
                return(Math.floor(v));
            }
        }

        function getEpochDay(v) {
            var cEpoch = $.PHPDate("U", new Date(v));
            return getint(cEpoch / 86400);
        }

        function getRealDate(v) {
            var cEpoch = v * 86400;
            return $.PHPDate("m/d/Y", new Date(cEpoch));
        }


        $(document).ready(function () {
            $("#ShadowaccountSchemaShadowexpire").datepicker({
                onSelect: function (dateText, inst) {
                    var cEpoch = $.PHPDate("U", new Date(dateText));
                    var epochDay = getint(cEpoch / 86400);
                    return epochDay;
                }
            });

            $("#ShadowaccountSchemaShadowlastchange").datepicker({
                onSelect: function (dateText, inst) {
                    var cEpoch = $.PHPDate("U", new Date(dateText));
                    var epochDay = getint(cEpoch / 86400);
                    return epochDay;
                }
            });
        });
    </script>
<?php
	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'ShadowaccountSchema',
	        'update'=>'shadowaccount',
	        'url' => array(
	            'controller' => 'ShadowaccountSchemas',
	            'action' => 'edit'
	         )
		)
	));
	echo $this->Form->input('dn', array('type'=>'hidden'));

	if(isset($this->request->data['ShadowaccountSchema']['shadowexpire']) && !empty($this->request->data['ShadowaccountSchema']['shadowexpire'])){
		$expdate = date("m/d/Y", 86400 * $this->request->data['ShadowaccountSchema']['shadowexpire']);
	}
	echo $this->Form->input('shadowexpire', array('label'=>'Password Expire Date', 'value'=>$expdate, 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute contains an absolute date specifying when the login may no longer be used.'));

	echo $this->Form->input('shadowinactive', array('label'=>'Days Inactive', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the number of days of inacitivity allowed for the specified user.'));

	if(isset($this->request->data['ShadowaccountSchema']['shadowlastchange']) && !empty($this->request->data['ShadowaccountSchema']['shadowlastchange'])){
		$lastdate = date("m/d/Y", 86400 * $this->request->data['ShadowaccountSchema']['shadowlastchange']);
	}
	echo $this->Form->input('shadowlastchange', array('label'=>'Password Last Changed', 'value'=>$lastdate, 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies number of days between January 1, 1970, and the date that the password was last modified.'));

	echo $this->Form->input('shadowmax', array('label'=>'Max Days Till Change', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the maximum number of days the password is valid.'));

	echo $this->Form->input('shadowmin', array('label'=>'Min Days Till Change', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the minimum number of days required between password changes.'));

	echo $this->Form->input('shadowwarning', array('label'=>'Days Before Warn', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the number of days before the password expires that the user is warned.'));

	echo $this->Form->end('Update');
?>
</div>