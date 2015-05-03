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

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeSession', 'Model/Datasource');

/**
 * User Model
 *
 * @property Role $Role
 * @property Server $Server
 */
class User extends AppModel {

    public $displayField = 'username';
    public $rawUser = array();
    public $virtualFields = array(
        'name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'first_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'last_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'email' => array(
                'rule' => array('email'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password' => array('notEmpty' => array('rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),),
        'role_id' => array('numeric' => array('rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),),
        'token' => array('notEmpty' => array('rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array('Role' => array(
            'className' => 'Role',
            'foreignKey' => 'role_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
    ));

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array('Instance' => array(
            'className' => 'Instances.Instance',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
    ));

    public function beforeSave($options = array()) {
        $passwordReset = false;
        // If certain conditions are met, set the passwordReset flag
        if (!empty($this->data[$this->alias]['token']) && !empty($this->id)) {
            $passwordReset = true;
        }
        // Force username lowercase
        if (!empty($this->data[$this->alias]['username'])) {
            $this->data[$this->alias]['username'] = strtolower($this->data[$this->alias]['username']);
        }
        $adminUpdate = false;
        // If admin or support is creating/editing account, set admin flag
        if (AuthComponent::user('role_id') <= 2) {
            $adminUpdate = true;
            // If password is not empty, set the password confirmation to match
            if (!empty($this->data[$this->alias]['password'])) {
                $this->data[$this->alias]['password_confirmation'] = $this->data[$this->alias]['password'];
            }
        }
        // Is this a new account?
        if (!isset($this->data[$this->alias]['id']) && !$passwordReset) {
            // Is registration disabled? If we are not an administrator invalidate the e-mail
            if (!$adminUpdate && Configure::read(APP_CONFIG_SCOPE . '.Users.registrationEnabled') != 'true') {
                $this->invalidate('email', __('Registration is currently disabled.'));
                return false;
            }
            // Set user defaults on new accounts
            $this->__setUserDefaults();
        }
        // Are we attempting to update the password?
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            if ($this->data[$this->alias]['password'] !== $this->data[$this->alias]['password_confirmation']) {
                $this->invalidate('password_confirmation', __('Passwords do not match.'));
                return false;
            }
            $this->rawUser['pwd'] = $this->data[$this->alias]['password'];
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
            unset($this->data[$this->alias]['password_confirmation']);
        } else {
            unset($this->data[$this->alias]['password']);
        }
        return true;
    }

    private function __setUserDefaults() {
        if (!empty(CakeSession::check(APP_CONFIG_SCOPE . '.desiredProductId'))) {
            $this->data[$this->alias]['desired_product_id'] = CakeSession::read(APP_CONFIG_SCOPE . '.desiredProductId');
            CakeSession::delete(APP_CONFIG_SCOPE . '.desiredProductId');
        }
        $this->data[$this->alias]['role_id'] = Configure::read(APP_CONFIG_SCOPE . '.Users.defaultRoleId');
        $this->data[$this->alias]['token'] = $this->generateToken();
    }

    public function generateToken() {
        return md5(uniqid(mt_rand(), true));
    }

    public function resetAccount($user = array()) {
        $this->primaryKey = 'email';
        if (!$this->exists($user['User']['email'])) {
            throw new NotFoundException(__('Invalid e-mail'));
        }
        $this->id = $user['User']['email'];
        if ($this->saveField('token', $this->generateToken(), false)) {
            return $this->__sendResetMail();
        }
        return false;
    }

    private function __sendResetMail() {
        $user = $this->read();
        $email = new CakeEmail('mandrill');
        $email->to($user['User']['email']);
        $email->subject(Configure::read(APP_CONFIG_SCOPE . '.Email.resetAccountSubject'));
        $email->template('reset-account');
        $email->viewVars($user['User']);
        $email->addHeaders(array(
            'tags' => array(Configure::read(APP_CONFIG_SCOPE . '.App.environment') . '-reset-account-email'),
        ));
        return $email->send()[0]['status'];
    }

    public function afterSave($created, $options = array()) {
        if ($created) {
            $this->__sendWelcomeMail();
            CakeSession::delete(APP_CONFIG_SCOPE . '.desiredProductId');
        }
        if ($this->id && !empty($this->rawUser['pwd'])) {
            $this->rawUser['uname'] = $this->field('username');
        }
    }

    private function __sendWelcomeMail() {
        if (!isset($this->data['User']['email'])) {
            return;
        }
        $email = new CakeEmail('mandrill');
        $email->to($this->data['User']['email']);
        $email->subject(Configure::read(APP_CONFIG_SCOPE . '.Email.newAccountSubject'));
        $email->template('new-account');
        $email->viewVars($this->data['User']);
        $email->viewVars(array('userCount' => $this->find('count')));
        $email->addHeaders(array(
            'tags' => array(Configure::read(APP_CONFIG_SCOPE . '.App.environment') . '-new-account-email'),
        ));
        $email->send();
    }

    public function acceptEula() {
        // save without callbacks
        $user = array(
            'User' => array(
                'id' => AuthComponent::user('id'),
                'eula_accepted' => true
            )
        );
        if ($this->save($user, array('validate' => false, 'callbacks' => false))) {
            return $this->find('first', array('conditions' => array('User.id' => AuthComponent::user('id'))))['User'];
        }
    }

    public function getHashedPass() {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => AuthComponent::user('id')
            ),
            'fields' => array('password')
        ));
        return $user['User']['password'];
    }

}
