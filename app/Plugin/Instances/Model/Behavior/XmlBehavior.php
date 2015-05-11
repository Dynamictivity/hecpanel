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

App::uses('ModelBehavior', 'Model');

class XmlBehavior extends ModelBehavior {
    /**
     * Types of relationships available for models
     *
     * @var array
     */
    //public $types = array('belongsTo', 'hasOne', 'hasMany', 'hasAndBelongsToMany');

    /**
     * Initiate behavior for the model using specified settings.
     *
     * @param Model $Model Model using the behavior
     * @param array $settings Settings to override for model.
     * @return void
     */
    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            //$this->settings[$Model->alias] = array('recursive' => true, 'notices' => true, 'autoFields' => true);
        }
        //$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
    }

    /**
     * Runs before a find() operation. 
     *
     * @param Model $Model Model using the behavior
     * @param array $query Query parameters as set by cake
     * @return array
     */
    public function beforeFind(Model $Model, $query) {
        return $query;
    }

    public function afterFind(Model $Model, $results, $primary = false) {
        return $results;
    }

    public function beforeValidate(Model $Model, $options = array()) {
        //You can use beforeValidate to modify a model’s validate array or handle any other pre-validation logic. Returning false from a beforeValidate callback will abort the validation and cause it to fail.
    }

    public function afterValidate(Model $Model) {
        //You can use afterValidate to perform any data cleanup or preparation if needed.
    }

    public function beforeSave(Model $Model, $options = array()) {
        //You can return false from a behavior’s beforeSave to abort the save. Return true to allow it continue.
    }

    public function beforeDelete(Model $Model, $cascade = true) {
        //You can return false from a behavior’s beforeDelete to abort the delete. Return true to allow it continue.
    }

    public function afterDelete(Model $Model) {
        //You can use afterDelete to perform clean up operations related to your behavior.
    }

    public function loadXml(Model $Model, $xmlFilePath, $convertToArray = true) {
        $xmlContents = Xml::build($xmlFilePath);
        if ($convertToArray) {
            $xmlContents = Xml::toArray($xmlContents);
        }
        return $xmlContents;
    }

    public function updateNode(Model $Model, $xmlPath, $updatedNode = array(), $saveFile = true) {
        $xmlFile = $this->loadXml($Model, $xmlPath, false);
        $nodeName = array_keys($updatedNode);
        $nodeName = $nodeName[0];
        unset($xmlFile->{$nodeName});
        $attributes = $xmlFile->addChild($nodeName);
        foreach ($updatedNode[$nodeName] as $attribute => $value) {
            $attributes->addChild($attribute, $value);
        }
        if ($saveFile) {
            $xmlFile = $this->__sxeToDom($xmlFile);
            $xmlFile->save($xmlPath);
        }
        return $xmlFile;
    }

    // Simple XML to DOM
    private function __sxeToDom($sxe) {
        $dom_sxe = dom_import_simplexml($sxe);
        $dom = new DOMDocument('1.0');
        $dom->formatOutput = true;
        $dom_sxe = $dom->importNode($dom_sxe, true);
        $dom_sxe = $dom->appendChild($dom_sxe);
        return $dom;
    }

	//TODO: Why is this debugged and killed?
    public function saveXml(Model $Model, $xmlFilePath, $xmlContents, $convertFromArray = true) {
        if ($convertFromArray) {
            $xmlContents = Xml::fromArray($xmlContents);
        }
        $xmlContents = dom_import_simplexml($xmlContents);
        $xmlDom = new DOMDocument('1.0');
        $xmlDom->formatOutput = true;
        $xmlContents = $xmlDom->importNode($xmlContents, true);
        $xmlContents = $xmlDom->appendChild($xmlContents);
        debug($xmlDom->saveXML());
        die;
        return $xmlContents;
        $xmlContents = $xmlContents->asXML();
        //file_put_contents($xmlFilePath, $xmlContents);
    }

    public function cacheXmlToDb(Model $Model, $xmlFilePath, $field) {
        if (!$Model->id) {
            return false;
        }
        return $Model->saveField($field, file_get_contents($xmlFilePath));
    }

}
