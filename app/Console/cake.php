#!/usr/bin/php -q
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
/**
 * Command-line code generation utility to automate programmer chores.
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

$dispatcher = 'Cake' . DS . 'Console' . DS . 'ShellDispatcher.php';

if (function_exists('ini_set')) {
    $root = dirname(dirname(dirname(__FILE__)));

    // the following line differs from its sibling
    // /app/Console/cake.php
	//ini_set('include_path', $root . PATH_SEPARATOR . 'C:' . DS . 'xampp' . DS . 'htdocs' . DS . 'hecpanel' . DS . 'lib' . PATH_SEPARATOR . ini_get('include_path'));
    unset($root);
}

if (!include $dispatcher) {
    trigger_error('Could not locate CakePHP core files.', E_USER_ERROR);
}
unset($dispatcher);

return ShellDispatcher::run($argv);
