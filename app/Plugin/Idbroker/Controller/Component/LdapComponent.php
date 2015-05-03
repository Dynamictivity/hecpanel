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

App::uses('Component', 'Controller');

class LdapComponent extends Component {

    /**
     * The name of the Model that represents users which will be authenticated.  Defaults to 'User'.
     *
     * @public string
     * @access public
     */
    public $Model = '';
    public $userModel = 'LDAPAuth';
    public $peopleBranch = '';
    public $groupBranch = '';
    public $computerBranch = '';
    public $sudoerBranch = '';

    /**
     * setup the model stuff
     *
     *
     */
    public function initialize(Controller $controller) {
        $model = Configure::read('LDAP.Model');
        $this->userModel = empty($model) ? 'Idbroker.LdapAuth' : $model;
        $this->model = $this->getModel();
    }

    public function startup(Controller $controller) {
        //get Model registered
        $this->basedn = '';
        $this->Model = $this->getModel($this->userModel);
        $ldapSettings = Configure::read('ldap');
        if (isset($ldapSettings['people'])) {
            $this->peopleBranch = $ldapSettings['people'];
        }
        if (isset($ldapSettings['group'])) {
            $this->groupBranch = $ldapSettings['group'];
        }
        if (isset($ldapSettings['computer'])) {
            $this->computerBranch = $ldapSettings['computer'];
        }
        if (isset($ldapSettings['sudo'])) {
            $this->sudoerBranch = $ldapSettings['sudo'];
        }
    }

    public function getUser($dn, $fields = null) {
        $options['targetDn'] = $dn;
        if (!empty($fields)) {
            $options['fields'] = $fields;
        }
        $user = $this->Model->find('first', $options);
        return $user[$this->Model->alias];
    }

    /*
     * This is a quick public function to return a list of computers a user may access
     * @param $fields only return these fields
     * @param $group the dn of a group you want to filter to
     *
     */

    public function getComputers($fields = array('cn', 'uniquemember'), $dn = null) {

        $options['targetDn'] = $this->computerBranch;
        $scope = 'sub';
        $conditions = 'uniquemember=*';


        if (!is_array($fields)) {
            $options['fields'] = array($fields);
        } else {
            $options['fields'] = $fields;
        }


        if (!empty($dn)) {
            $conditions = 'uniquemember=' . $dn;
        }

        $options['conditions'] = $conditions;
        $options['scope'] = $scope;

        $computers = $this->Model->find('all', $options);
        $list = array();

        if (isset($computers)) {
            foreach ($computers as $computer) {
                $list[] = $computer[$this->Model->alias];
            }
            return $list;
        } else {
            return false;
        }
    }

    /*
     * This is a quick public function to return a list of computers a user may access
     * @param $fields only return these fields
     * @param $group the dn of a group you want to filter to
     *
     */

    public function getSudoers($fields = array('cn'), $dn = null) {
        $options['targetDn'] = $this->sudoerBranch;
        $scope = 'sub';
        if (!is_array($fields)) {
            $options['fields'] = array($fields);
        } else {
            $options['fields'] = $fields;
        }
        if (!empty($dn)) {
            $utmp = $this->Model->find('first', array('targetDn' => $dn, 'scop' => 'base', 'fields' => array('uid')));
            $uid = $utmp[$this->Model->alias]['uid'];
            $conds = array('sudouser' => $uid);
            $groups = $this->getGroups(array('cn'), $dn);
            if (count($groups) > 1) {
                $conditions = '(|(sudouser=' . $uid . ')';
                foreach ($groups as $group) {
                    $conditions .= '(sudouser=%' . $group['cn'] . ')';
                }
                $conditions .= ')';
            } else {
                $conditions = 'sudouser=' . $uid;
            }
        } else {
            $conditions = 'sudouser=*';
        }

        $options['conditions'] = $conditions;
        $options['scope'] = $scope;
        $computers = $this->Model->find('all', $options);
        $list = array();
        if (isset($computers)) {
            foreach ($computers as $computer) {
                $list[] = $computer[$this->Model->alias];
            }
            return $list;
        } else {
            return false;
        }
    }

    /*
     * This is a quick public function to return a list of groups a user is in
     * @param $fields only return these fields
     * @param $dn the dn of a user you can filter to
     *
     */

    public function getGroups($fields = array('cn', 'memberuid', 'uniquemember', 'member'), $dn = null, $filter = null) {

        $options['targetDn'] = $this->groupBranch;
        $scope = 'sub';
        $conditions = '(|(|(uniquemember=*)(memberuid=*))(member=*))';


        if (!is_array($fields)) {
            $options['fields'] = array($fields);
        } else {
            $options['fields'] = $fields;
        }


        if (!empty($dn)) {
            $utmp = $this->Model->find('first', array('targetDn' => $dn, 'scop' => 'base', 'fields' => array('uid', 'cn', 'samaccountname')));
            if (isset($utmp[$this->Model->alias]['uid'])) {
                $uid = $utmp[$this->Model->alias]['uid'];
            } elseif (isset($utmp[$this->Model->alias]['samacountname'])) {
                $uid = $utmp[$this->Model->alias]['samacountname'];
            } else {
                $uid = $utmp[$this->Model->alias]['cn'];
            }

            $conditions = '(|(|(uniquemember=' . $dn . ')(memberuid=' . $uid . '))(member=' . $dn . '))';
        }

        if (!empty($filter)) {
            if (preg_match('/posixgroup/i', $filter)) {
                $conditions = 'objectclass=posixgroup';
            } elseif (preg_match('/groupofuniquenames/i', $filter)) {
                $conditions = 'objectclass=groupofuniquenames';
            } elseif (preg_match('/group/i', $filter)) {
                $conditions = 'objectclass=group';
            } else {
                $conditions = $filter;
            }
        }
        $options['conditions'] = $conditions;
        $options['scope'] = $scope;

        $groups = $this->Model->find('all', $options);

        $list = array();

        if (isset($groups)) {
            foreach ($groups as $group) {
                $list[] = $group[$this->Model->alias];
            }
            return $list;
        } else {
            return false;
        }
    }

    /*
     * This is a quick public function to return a list of users in a group
     * @param $fields only return these fields
     * @param $group the dn of a group you want to filter to
     *
     */

    public function getUsers($fields = 'uid', $group = null, $type = null) {
        $options['targetDn'] = $this->peopleBranch;
        $options['conditions'] = 'uid=*';
        $options['scope'] = 'sub';

        if (!is_array($fields)) {
            $fields = array($fields);
        }
        $options['fields'] = $fields;

        if (!empty($group)) {
            $options['targetDn'] = $group;
            $options['scope'] = 'base';
            $options['conditions'] = $type . "=*";
            $options['fields'] = array($type);
            $users = $this->Model->find('first', $options);
        } else {
            $users = $this->Model->find('all', $options);
        }
        $list = array();

        if (isset($group)) {
            $gops['fields'] = $fields;
            $gops['conditions'] = 'uid=*';
            $gops['scope'] = 'sub';
            if (is_array($users[$this->Model->alias][$type])) {
                foreach ($users[$this->Model->alias][$type] as $user) {
                    if (isset($type) && $type == 'memberuid') {
                        $gops['conditions'] = 'uid=' . $user;
                    } elseif (isset($type) && $type == 'uniquemember') {
                        $gops['targetDn'] = $user;
                    }

                    $entrys = $this->Model->find('first', $gops);
                    $list[] = $entrys[$this->Model->alias];
                }
            } else {
                $user = $users[$this->Model->alias][$type];
                if (isset($type) && $type == 'memberuid') {
                    $gops['conditions'] = 'uid=' . $user;
                } elseif (isset($type) && $type == 'uniquemember') {
                    $gops['targetDn'] = $user;
                }

                $entrys = $this->Model->find('first', $gops);
                $list[] = $entrys[$this->Model->alias];
            }
        } else {
            foreach ($users as $user) {
                //Lets Ditch Model info so it doesn't matter
                $list[] = $user[$this->Model->alias];
            }
        }
        return $list;
    }

    /**
     * Checks weather the given object contains any child nodes
     *
     *
     * @param $dn string of the exact dn you want to check
     * @return the number of children or false if none
     * @access public
     */
    public function hasChildren($dn) {
        $options['targetDn'] = $dn;
        $options['scope'] = 'one';
        $results = $this->Model->find('count', $options);
        return $results;
    }

    /**
     * Returns a reference to the Model object specified, and attempts
     * to load it if it is not found.
     *
     * @param string $name Model name (defaults to AuthComponent::$Model->alias)
     * @return object A reference to a Model object
     * @access public
     */
    public function &getModel($name = null) {
        $Model = null;
        if (!$name) {
            $name = $this->userModel;
        }

        $Model = ClassRegistry::init($name);

        if (empty($Model)) {
            trigger_error(__('LDAP::getModel() - Model is not set or could not be found'), E_USER_WARNING);
            return null;
        }

        return $Model;
    }

    public function forcePasswordReset($dn, $password) {
        $this->Model->id = $dn;
        $update[$this->Model->alias]['dn'] = $dn;
        $update[$this->Model->alias]['passwordallowchangetime'] = array();
        $fup = $this->Model->save($update);
        if ($fup) {
            return true;
        }
        return false;
    }

    public function canChangePassword($dn) {
        $options['targetDn'] = $dn;
        $options['scope'] = 'base';
        $passwdtimeattr = 'passwordallowchangetime';
        $shadowtimeattr = 'shadowmin';
        $options['fields'] = array($passwdtimeattr, $shadowtimeattr, 'cn', 'uid');

        $user = $this->Model->find('first', $options);
        $user = $user[$this->Model->alias];
        if (isset($user[$passwdtimeattr]) && !empty($user[$passwdtimeattr]) && ( time() < strtotime($user[$passwdtimeattr]) )) {
            //Password Restriction is from passwordallowchangetime
            $result['allowed'] = false;
            $result['notuntil'] = date('D, j M Y', strtotime($user[$passwdtimeattr]));
            return $result;
        } elseif (isset($user[$shadowtimeattr]) && !empty($user[$shadowtimeattr]) && ( time() < strtotime($user[$shadowtimeattr]) )) {
            //Password Restriction is from shadowmin
            $result['allowed'] = false;
            $result['notuntil'] = date('D, j M Y', strtotime($user[$shadowtimeattr]));
            return $result;
        } else {
            //Currently no password time restrictions let them change it
            $result['allowed'] = true;
            return $result;
        }
    }

}
