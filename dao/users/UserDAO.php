<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 17/08/2017
 * Time: 14:11
 */

namespace siath\dao\users;

require_once "dao/BaseDAO.php";
require_once "model/users/UserModel.php";

use siath\dao\BaseDAO;
use siath\model\users\UserModel;
use lazyLoader\model\ModelHandler;
use siath\utils\StringUtil;

final class UserDAO extends BaseDAO {

    /**
     * @param $username
     * @return UserModel|null
     */
    public function getUserByLdapUser($username) {
        $sql0 = <<<SQL
        SELECT
            S3.*, 
            DU.ACCOUNT_STATUS ACCOUNT_STATUS
        FROM 
            SIS03 S3 LEFT JOIN  DBA_USERS DU ON S3.SIS03LOG = DU.USERNAME 
        WHERE SIS03LDAP = :USERNAME
SQL;
        $parameters = [
            "USERNAME" => $username
        ];
        $resStatement = $this->query($sql0, $parameters);
        $resultRows = [];
        $numRows = $this->getArrayFromStatement($resStatement, $resultRows);
        $this->freeStatement($resStatement);
        if ($numRows != 1) return null;
        return ModelHandler::arrayToObject($resultRows[0], UserModel::class);
    }

    public function checkUserConnection() {
        $conn = $this->getConnection();
        $return = false;
        if (!\is_null($conn)) {
            \oci_close($conn);
            $return = true;
        }
        return $return;
    }


    /**
     * @param UserModel $user
     * @param string $ldapPasswd
     * @return bool
     */
    public function updateUserPassword($user, $ldapPasswd, $secureLdapPasswd) {
        $ldapPasswd = StringUtil::trimDbPassword($ldapPasswd);
        $sql_1 = 'alter user '.$user->getUserName().' identified by "'.$ldapPasswd.'"';
        $alterStmt = $this->query($sql_1);
        if (!$alterStmt) return false;
        $this->freeStatement($alterStmt);

        $sql_2 = "update SIS03 set SIS03PWD = :PWD where SIS03LOG = :LOG";
        return $this->query($sql_2, [
            "PWD" => $secureLdapPasswd,
            "LOG" => $user->getUserName()
        ]);
    }

    public function checkUserDatabaseConnection($ldap_username, $password) {
        if (\is_null($ldap_username) || \is_null($password) || empty($ldap_username) || empty($password)) return false;
        $conn = @\oci_connect($ldap_username, $password, SERVER);
        if (!$conn) {
            return false;
        }
        \oci_close($conn);
        return true;
    }
}