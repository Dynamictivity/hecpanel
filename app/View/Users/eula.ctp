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

<?php

// Todo: move to config
echo $this->Form->create('User', array(
	'class' => 'well form-horizontal'
));
?>
<fieldset>
    <h1><?php echo __('Hosting Engineers Alpha End User License Agreement'); ?></h1>

    <h2><?php echo __('Terms, Conditions and Privacy Policy'); ?></h2>
    <p>Please thoroughly read all our our terms and conditions. Use of this product indicates that you have read and accepted all the terms of this agreement.</p>

    <p>This site, product and associated content are provided on an "AS IS" basis, without a warranty of any kind, either expressed or implied, including, but not limited to, warranties that any provided information is defect free, merchantable, fit for a particular purpose or non-infringing. No guarantees are expressed or implied.</p>

    <p>In no circumstances and under no legal theory, whether in tort (including negligence), contract, or otherwise, will Dynamictivity LLC D.B.A. Hosting Engineers be liable for any consequential, incidental, indirect, exemplary, liquidated, special, or punitive damages, including, but not limited to, damages resulting in loss of data, profit, revenue, business, or goodwill, computer malfunction or failure, or any and all other commercial losses or damages arising in whole or in part from your access to the product.</p>

    <p>By using this alpha version product you understand and accept that as an alpha Dynamictivity LLC D.B.A. Hosting Engineers has been tested with the Google Chrome web browser only.</p>

    <p>We reserve the right to create limits on access and use of the product at our sole discretion at any time, as well as the right to modify these terms.</p>

    <h2><?php echo __('Third Parties'); ?></h2>
    <p>The Dynamictivity LLC D.B.A. Hosting Engineers product interacts with, and uses data provided from, various third-parties. Because of the variety of cloud hardware and software environments that Dynamictivity LLC D.B.A. Hosting Engineers may interact with, no warranty of reliability is provided. Although we attempt to fully test all components, we cannot assume the risks associated with using this software, and/or any potential damage resulting from/related to its use. In all cases, Dynamictivity LLC D.B.A. Hosting Engineers will attempt to rectify any known faults that may occur. By using our product you understand and agree that when the product is accessing, sending and retrieving account information to and from third party sites, Dynamictivity LLC D.B.A. Hosting Engineers is acting as your agent on your behalf, not as the agent or on the half of any third-party. None of your credentials are stored permanently on Dynamictivity LLC D.B.A. Hosting Engineers's server, and data transfer is happening through an https protocol. Dynamictivity LLC D.B.A. Hosting Engineers will not be responsible if you leave them accessible to others. Make sure you always keep them in a safe place.</p>

    <h2><?php echo __('Privacy Policy'); ?></h2>
    <p>Dynamictivity LLC D.B.A. Hosting Engineers respects your privacy. Information given to us through correspondence, usage or otherwise, will never be disclosed to third-parties. Dynamictivity LLC D.B.A. Hosting Engineers may use anonymous usage analytics on our web site and/or application purely for the purposes of improving the product and your experience. Your privacy is our highest concern and we will not use your data for any unauthorised purposes.</p>

    <p>If you have any questions about these Terms, you can contact us at support@dynamictivity.com or at +1-503-741-9825</p>

    <p><strong>Date of last modifications: 2015-05-02</strong></p>
</fieldset>
<?php if (AuthComponent::user('id') && !AuthComponent::user('eula_accepted')): ?>
<div class="form-group">
    <?php echo $this->Form->submit(__('I Accept and Agree to The Terms and Conditions Outlined Above'), Configure::read('Bootstrap.formButtonStyle')); ?>
</div>
<p><center><?php echo $this->Html->link(__('I don\'t agree, log me out!'), array('controller' => 'users', 'action' => 'logout', 'plugin' => false, 'admin' => false)); ?></center></p>
<?php endif; ?>
<?php echo $this->Form->end(); ?>