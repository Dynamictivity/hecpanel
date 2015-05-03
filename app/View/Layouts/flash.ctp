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

/**
 *
 */
?>
<!DOCTYPE html>
<html>
    <head>
<?php echo $this->Html->charset(); ?>
        <title><?php echo $page_title; ?></title>

<?php if (!Configure::read('debug')): ?>
        <meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php endif ?>
        <style><!--
            P { text-align:center; font:bold 1.1em sans-serif }
            A { color:#444; text-decoration:none }
            A:HOVER { text-decoration: underline; color:#44E }
            --></style>
    </head>
    <body>
        <p><a href="<?php echo $url; ?>"><?php echo $message; ?></a></p>
    </body>
</html>
