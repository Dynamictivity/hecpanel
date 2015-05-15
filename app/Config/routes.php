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
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 */
/**
 * Here, we are connecting '/' (base path)
 */
Router::connect('/', array('controller' => 'instances', 'action' => 'index', 'plugin' => 'instances'));
Router::connectNamed(array('node', 'instance', 'apikey'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

// Custom routes
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout', 'plugin' => false, 'admin' => false));
Router::connect('/login', array('controller' => 'users', 'action' => 'login', 'plugin' => false, 'admin' => false));
Router::connect('/signup', array('controller' => 'users', 'action' => 'signup', 'plugin' => false, 'admin' => false));
Router::connect('/account', array('controller' => 'users', 'action' => 'edit', 'plugin' => false, 'admin' => false));
Router::connect('/account/forgot', array('controller' => 'users', 'action' => 'forgot', 'plugin' => false, 'admin' => false));
Router::connect('/account/eula/*', array('controller' => 'users', 'action' => 'eula', 'plugin' => false, 'admin' => false));
Router::connect('/account/reset/*', array('controller' => 'users', 'action' => 'reset', 'plugin' => false, 'admin' => false));
Router::connect('/account/confirm/*', array('controller' => 'users', 'action' => 'confirm', 'plugin' => false, 'admin' => false));

Router::connect('/instances', array('controller' => 'instances', 'action' => 'index', 'plugin' => 'instances', 'admin' => false));
//Router::connect('/instances/add', array('controller' => 'instances', 'action' => 'add', 'plugin' => 'instances', 'admin' => false));

Router::connect('/instance_profiles', array('controller' => 'instance_profiles', 'action' => 'index', 'plugin' => 'instances', 'admin' => false));
Router::connect('/instance_profiles/add', array('controller' => 'instance_profiles', 'action' => 'add', 'plugin' => 'instances', 'admin' => false));
Router::connect('/instance_profiles/add/*', array('controller' => 'instance_profiles', 'action' => 'add', 'plugin' => 'instances', 'admin' => false));
Router::connect('/instance_profiles/edit/*', array('controller' => 'instance_profiles', 'action' => 'edit', 'plugin' => 'instances', 'admin' => false));

Router::connect('/admin', array('controller' => 'instances', 'action' => 'index', 'plugin' => 'instances', 'admin' => true));

//  API Routes
Router::connect('/api_v1/:apikey', array('controller' => 'products', 'action' => 'index', 'plugin' => 'shop', 'api_v1' => true));
Router::connect('/api_v1/:apikey/:plugin/:controller/:action/*', array('api_v1' => true));
Router::connect('/api_v1/:apikey/:plugin/:controller', array('action' => 'index', 'api_v1' => true));
Router::connect('/api_v1/:apikey/:controller/:action/*', array('api_v1' => true));
Router::connect('/api_v1/:apikey/:controller', array('action' => 'index', 'api_v1' => true));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

//  Enable REST
Router::mapResources('products');
Router::parseExtensions('json');

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
