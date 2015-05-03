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

<ul class="nav navbar-nav navbar-right">
	<?php if (AuthComponent::user('id')): ?>
		<li>
			<?php echo $this->Html->link(__('Give Feedback'), array('controller' => 'feedback', 'action' => 'add', 'admin' => false, 'plugin' => 'support')); ?>
		</li>
		<li class="dropdown navbar-profile">
			<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
				<?php echo $this->Html->image('avatars/user-xs.png', array('class' => 'navbar-profile-avatar')); ?>
				<span class="navbar-profile-label"><?php echo AuthComponent::user('email'); ?> &nbsp;</span>
				<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li>
					<?php echo $this->Html->link('<i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;' . __('My Profile'), array('controller' => 'users', 'action' => 'edit', 'admin' => false, 'plugin' => false), array('escape' => false)); ?>
				</li>
	<!--			<li>
					<a href="./page-pricing.html">
						<i class="fa fa-dollar"></i> 
						&nbsp;&nbsp;Plans & Billing
					</a>
				</li>
				<li>
					<a href="./page-settings.html">
						<i class="fa fa-cogs"></i> 
						&nbsp;&nbsp;Settings
					</a>
				</li>-->
				<li class="divider"></li>
				<li>
					<?php echo $this->Html->link('<i class="fa fa-sign-out"></i>&nbsp;&nbsp;&nbsp;' . __('Logout'), array('controller' => 'users', 'action' => 'logout', 'admin' => false, 'plugin' => false), array('escape' => false)); ?>
				</li>
			</ul>
		</li>
	<?php endif; ?>
	<?php if (!AuthComponent::user('id')): ?>
		<li>
			<?php echo $this->Html->link(__('Login / Free Sign-Up'), array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false)); ?>
		</li>
	<?php endif; ?>
</ul>