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

class NullableBehavior extends ModelBehavior {

    /**
     * function beforeSave
     * 
     * Looks for nullable fields in the schema and replaces empty string values for those fields
     * with NULL values. This is helpful as hell when foreign key values are nullable lest you
     * get lots of key constraint errors.
     *
     * @param   model   The model object to be saved.
     * @return  boolean  Success
     */
    function beforeSave(Model $model, $options = array()) {
        $schema = $model->schema();

        foreach ($schema as $field => $metadata) {
            if (isset($model->data[$model->alias][$field]) && !empty($metadata['null'])) {
                if ($model->data[$model->alias][$field] === '') {
                    $model->data[$model->alias][$field] = null;
                }
            }
        }

        return true;
    }

}
