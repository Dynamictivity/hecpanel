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

<li class="active">
    <?php echo $this->Html->link('<i class="fa fa-rocket"></i>&nbsp;&nbsp;&nbsp;' . __('My Instances'), array('controller' => 'instances', 'action' => 'index', 'admin' => false, 'plugin' => 'instances'), array('escape' => false)); ?></li>
</li>
<li>
    <?php echo $this->Html->link('<i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;' . __('Instance Profiles'), array('controller' => 'instance_profiles', 'action' => 'index', 'admin' => false, 'plugin' => 'instances'), array('escape' => false)); ?></li>
</li>
<li>
    <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('Developer\'s Log'), array('controller' => 'devlogs', 'action' => 'index', 'admin' => false, 'plugin' => false), array('escape' => false)); ?></li>
</li>
<li>
    <?php echo $this->Html->link('<i class="fa fa-heart-o"></i>&nbsp;&nbsp;&nbsp;' . __('Give Feedback'), array('controller' => 'feedback', 'action' => 'add', 'admin' => false, 'plugin' => 'support'), array('escape' => false)); ?></li>
</li>