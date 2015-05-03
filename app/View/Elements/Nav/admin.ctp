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

<li class="dropdown active">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
        <?php echo __('Instances'); ?>
        <i class="mainnav-caret"></i>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?php echo $this->Html->link('<i class="fa fa-rocket"></i>&nbsp;&nbsp;&nbsp;' . __('List Instances'), array('controller' => 'instances', 'action' => 'index', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;' . __('Instance Profiles'), array('controller' => 'instance_profiles', 'action' => 'index', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('Instance Types'), array('controller' => 'instance_types', 'action' => 'index', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('Host Servers'), array('controller' => 'host_servers', 'action' => 'index', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('Command Queue'), array('controller' => 'command_queues', 'action' => 'index', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('Enable Maintenance'), array('controller' => 'instances', 'action' => 'maintenance', 'start', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('Disable Maintenance'), array('controller' => 'instances', 'action' => 'maintenance', 'admin' => true, 'plugin' => 'instances'), array('escape' => false)); ?></li>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
        <?php echo __('System'); ?>
        <i class="mainnav-caret"></i>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('List Users'), array('controller' => 'users', 'action' => 'index', 'admin' => true, 'plugin' => false), array('escape' => false)); ?></li>
        </li>
        <li>
            <?php echo $this->Html->link('<i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;' . __('List Configurations'), array('controller' => 'configurations', 'action' => 'index', 'admin' => true, 'plugin' => 'config'), array('escape' => false)); ?></li>
        </li>
    </ul>
</li>