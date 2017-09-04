<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 15/08/2017
 * Time: 20:26
 */

namespace siath\services\users;

require_once "services/BaseService.php";
require_once "dao/users/UserDAO.php";

use siath\dao\users\UserDAO;
use siath\services\BaseService;

final class UserService extends BaseService {

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function getLdapUser($username, $password) {
        if (empty($username) || empty($password)) return false;
        $ldap = \ldap_connect(LDAP_HOST, LDAP_PORT);

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        $success_ldap = (bool) @\ldap_bind($ldap, LDAP_DOMAIN . "\\{$username}", $password);
        if ($success_ldap) {
            \ldap_unbind($ldap);
        }
        $ldap = null;
        return $success_ldap;
    }

    public function getUserByLdapUser($username){
        if (\is_null($username) || empty($username)) return null;
        $dao = new UserDAO();
        return $dao->getUserByLdapUser($username);
    }

    public function checkUserConnection($username, $password){
        if (\is_null($username) || \is_null($password) || empty($username) || empty($password)) return null;
        $dao = new UserDAO($username, $password);
        return $dao->checkUserDatabaseConnection($username, $password);
    }

    public function updateUserPassword($user, $ldapPasswd, $secureLdapPasswd){
        $dao = new UserDAO();
        return $dao->updateUserPassword($user, $ldapPasswd, $secureLdapPasswd);
    }
}