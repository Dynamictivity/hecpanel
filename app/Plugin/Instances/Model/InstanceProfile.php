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

App::uses('InstancesAppModel', 'Instances.Model');

/**
 * InstanceProfile Model
 *
 * @property Instance $Instance
 * @property Instance $Instance
 */
class InstanceProfile extends InstancesAppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                //'message' => 'Your custom message here',
                'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
//        'game_mode' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'inventory_size_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'assembler_speed_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'assembler_efficiency_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'refinery_speed_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'online_mode' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'max_floating_objects' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'environment_hostility' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'auto_healing' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'enable_copy_paste' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'auto_save' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'weapons_enabled' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'show_player_names_on_hud' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'thruster_damage' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'cargo_ships_enabled' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'enable_spectator' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'remove_trash' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'world_size_km' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'respawn_ship_delete' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'reset_ownership' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'welder_speed_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'grinder_speed_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'realistic_sound' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'client_can_save' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'hack_speed_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'permanent_death' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'spawn_ship_time_multiplier' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'procedural_density' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'procedural_seed' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                'message' => 'Required, set to 0 to disable procedural generation.',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'destructible_blocks' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'enable_ingame_scripts' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'enable_oxygen' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'scenario_subtype_id' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                //'message' => 'Your custom message here',
//                'allowEmpty' => false,
//            //'required' => true,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
    );

	public $actsAs = array(
		'JsonColumn' => array(
			'fields' => array('profile_settings')
		)
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Instance' => array(
			'className' => 'Instance',
			'foreignKey' => 'instance_profile_id',
			'dependent' => true,
		)
	);

	public function generateCloneName($sourceName) {
		$cloneNumber = '0';
		$nameExists = true;
		while ($nameExists) {
			$proposedCloneName = $sourceName . '_Clone' . ++$cloneNumber;
			$nameExists = $this->find('count', array(
				'conditions' => array(
					'InstanceProfile.name' => $proposedCloneName,
					'InstanceProfile.user_id' => AuthComponent::user('id')
				)
			));
		}
		return $proposedCloneName;
	}

}
