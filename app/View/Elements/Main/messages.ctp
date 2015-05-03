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

<li class="dropdown">
	<a href="./page-notifications.html" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-envelope"></i>
		<span class="navbar-visible-collapsed">&nbsp;Messages&nbsp;</span>
	</a>
	<ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">                
		<li class="nav-header">
			<div class="pull-left">
				Messages
			</div>
			<div class="pull-right">
				<a href="javascript:;">New Message</a>
			</div>
		</li>
		<li>
			<a href="./page-notifications.html" class="noticebar-item">
				<span class="noticebar-item-image">
					<?php echo $this->Html->image('avatars/avatar-1-md.jpg', array('style' => 'width: 50px')); ?>
				</span>
				<span class="noticebar-item-body">
					<strong class="noticebar-item-title">New Message</strong>
					<span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
					<span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
				</span>
			</a>
		</li>
		<li>
			<a href="./page-notifications.html" class="noticebar-item">
				<span class="noticebar-item-image">
					<?php echo $this->Html->image('avatars/avatar-2-md.jpg', array('style' => 'width: 50px')); ?>
				</span>
				<span class="noticebar-item-body">
					<strong class="noticebar-item-title">New Message</strong>
					<span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
					<span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 5 hours ago</span>
				</span>
			</a>
		</li>
		<li class="noticebar-menu-view-all">
			<a href="./page-notifications.html">View All Messages</a>
		</li>
	</ul>
</li>