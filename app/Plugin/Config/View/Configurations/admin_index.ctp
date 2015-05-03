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

<div class="table-responsive">
    <h2><?php echo __('Configurations'); ?></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('configuration_scope', 'Scope'); ?></th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('value'); ?></th>
                <th><?php echo $this->Paginator->sort('role_id'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
			<?php foreach ($configurations as $configuration): ?>
            <tr>
                <td><?php echo h($configuration['Configuration']['id']); ?>&nbsp;</td>
                <td><?php echo h($configuration['Configuration']['configuration_scope']); ?>&nbsp;</td>
                <td><?php echo h($configuration['Configuration']['name']); ?>&nbsp;</td>
                <td><?php echo h($configuration['Configuration']['value']); ?>&nbsp;</td>
                <td><?php echo h($configuration['Role']['name']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->buttonGroup(
                            array(
                                    $this->Html->button(array('cog', 'default', 'xs'), array('action' => 'edit', $configuration['Configuration']['id']), array('escape' => false, 'title' => __('Edit'))),
                                    $this->Html->postButton(array('trash', 'default', 'xs'), array('action' => 'delete', $configuration['Configuration']['id']), array('escape' => false, 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $configuration['Configuration']['id']))
                            )	
                    ); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <?php echo $this->element('paging'); ?>
    </table>
</div>
<?php echo $this->element('add_button'); ?>