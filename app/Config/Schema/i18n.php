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
 * This is i18n Schema file
 *
 * Use it to configure database for i18n
 */

/**
 *
 * Using the Schema command line utility
 *
 * Use it to configure database for i18n
 *
 * cake schema run create i18n
 */
class I18nSchema extends CakeSchema {

    /**
     * The name property
     *
     * @var string
     */
    public $name = 'i18n';

    /**
     * Before event.
     *
     * @param array $event The event data.
     * @return boolean success
     */
    public function before($event = array()) {
        return true;
    }

    /**
     * After event.
     *
     * @param array $event The event data.
     * @return void
     */
    public function after($event = array()) {
        
    }

    /**
     * The i18n table property
     *
     * @var array
     */
    public $i18n = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'locale' => array('type' => 'string', 'null' => false, 'length' => 6, 'key' => 'index'),
        'model' => array('type' => 'string', 'null' => false, 'key' => 'index'),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
        'field' => array('type' => 'string', 'null' => false, 'key' => 'index'),
        'content' => array('type' => 'text', 'null' => true, 'default' => null),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'locale' => array('column' => 'locale', 'unique' => 0), 'model' => array('column' => 'model', 'unique' => 0), 'row_id' => array('column' => 'foreign_key', 'unique' => 0), 'field' => array('column' => 'field', 'unique' => 0))
    );

}
