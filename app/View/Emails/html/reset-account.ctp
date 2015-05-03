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

Welcome <?php echo $username; ?>,
<br /><br />
Your have requested that your account be reset, please click this link: <a href="<?php echo Configure::read(APP_CONFIG_SCOPE . '.App.appUrl') . '/account/reset/' . $token; ?>"><?php echo Configure::read(APP_CONFIG_SCOPE . '.App.appUrl') . '/account/reset/' . $token; ?></a>
<br /><br />
Your username is: <?php echo $username; ?>
<br /><br />
If you did not request this, simply ignore this e-mail and your account will remain unchanged.