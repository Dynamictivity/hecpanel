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
 * SettingsHandler component is a wrapper a way to read and more importantly
 * write to the config/settings.php file.  Designed to work with plugins also
 *
 * @author Analogrithems
 * @version 1.0
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @category Components
 */
//define('PLUGINS', APP_PATH.DS.'plugins');
class SettingsHandlerComponent extends Component {

    /**
     * Reference to the controller
     *
     * @public object
     * @access private
     */
    public $__controller = null;
    public $settingsFile;
    public $_settingsName = 'ldap';
    public $_settings = array();

    public function initialize(Controller $controller) {
        $this->__controller = $controller;
        $this->settingsFile = ROOT . DS . APP_DIR . DS . 'config' . DS . 'settings.php';
        Configure::load($this->_settingsName);
        $this->_settings = Configure::read($this->_settingsName);
    }

    public function getSettings() {
        return $this->_settings;
    }

    public function setSettings($data) {
        $data = array_merge($this->_settings[$this->_settingsName], $data);
        $configs = $this->expandArray($data, "['" . $this->_settingsName . "']");
        $this->log("Settings Data:" . print_r($configs, true) . "\nfrom:" . print_r($data, true), 'debug');
        foreach ($configs as $config) {
            $content .= $config;
        }

        if (!class_exists('File')) {
            require CAKE . 'file.php';
        }

        $fileClass = new File($this->settingsFile, true, '0744');
        $content = "<?php\n" . $content . "\n?>";
        if ($fileClass->writable()) {
            $fileClass->write($content);
        }
    }

    public function expandArray($options, $prefix = null) {
        $results = array();
        foreach ($options as $key => $value) {
            $key = $prefix . "['$key']";
            if (is_array($value)) {
                $tres = $this->expandArray($value, $key);
                foreach ($tres as $res) {
                    $results[] = $res;
                }
                $this->log("Expanding Array again :" . print_r($results, true), 'debug');
            } else {
                $results[] = "\t\$config" . $key . " = '$value';\n";
            }
        }

        return $results;
    }

    public function setAutoSet($attribute, $function, $options = null) {
        if ($options) {
            $this->_settings[$this->_settingsName]['auto'][$attribute][][$function] = $options;
        } else {
            $this->_settings[$this->_settingsName]['auto'][$attribute][] = $function;
        }
    }

    public function autoSet($attribute) {
        $nauto = '';
        if ($this->isAutoSet($attribute)) {
            //Force this to zero, can only have one auto set..
            $path = $this->_settings['auto'][$attribute][0];
            $nauto = $this->requestAction($path, array('return' => true));
            $this->log("Getting auto for $attribute " . print_r($path, true) . "Result is:" . print_r($nauto, true), 'debug');
            return($nauto);
        }
        return false;
    }

    public function isAutoSet($attribute, $function = null) {
        $found = false;
        if ($function == null && isset($this->_settings['auto'][$attribute])) {
            foreach ($this->_settings['auto'][$attribute] as $key => $value) {
                if ($function == $key) {
                    $found = true;
                }
            }
        } else {
            if (isset($this->_settings['auto'][$attribute])) {
                $found = true;
            }
        }
        return($found);
    }

    public function SyncWith($attribute, $function, $options = null) {
        if ($options) {
            $this->_settings[$this->_settingsName]['sync'][$attribute][][$function] = $options;
        } else {
            $this->_settings[$this->_settingsName]['sync'][$attribute][] = $function;
        }
    }

    public function isSyncWith($attribute, $function) {
        $found = in_array($function, $this->_settings['sync'][$attribute]);
        if ($found == false) {
            foreach ($this->_settings['sync'][$attribute] as $key => $value) {
                if ($function == $key) {
                    $found = true;
                }
            }
        }
        return($found);
    }

}
