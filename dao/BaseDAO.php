<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 07/08/2017
 * Time: 20:49
 */

namespace siath\dao;


use siath\utils\StringUtil;

abstract class BaseDAO {

    private $username;
    private $password;

    function __construct($username = null, $password = null) {
        $this->username = $username;
        $this->password = StringUtil::trimDbPassword($password);
    }



    protected function getConnection() {
        $user = \is_null($this->username) ? USER : $this->username;
        $pass = \is_null($this->password) ? PASSWORD : $this->password;
        $conn = @\oci_connect($user, $pass, SERVER);
        if (!$conn) {
            return null;
        }
        return $conn;
    }


    /**
     * @param $sql
     * @param array $parameters
     * @param bool $asSysdba
     * @return mixed
     */
    protected function query($sql, $parameters = [], $commit = OCI_COMMIT_ON_SUCCESS) {
        $conn = $this->getConnection();
        if (\is_null($conn)) return null;
        $statement = \oci_parse($conn, $sql);
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                if( count($value) == 2){ //0 = valor, 1 = tipo
                    \oci_bind_by_name($statement, ":$key", $value[0], -1, $value[1]);
                }else if( count($value) == 3){ //0 = valor, 1 = tipo, 2 = long
                    \oci_bind_by_name($statement, ":$key", $value[0], $value[2], $value[1]);
                }
            } else {
                \oci_bind_by_name($statement, ":$key", $value);
            }
        }
        $ok = \oci_execute($statement, $commit);
        \oci_close($conn);
        if ($ok) return $statement;
        \oci_free_statement($statement);
        return false;
    }

    protected function  getArrayFromStatement($statement, &$output){
        if(is_null($statement) || $statement == false){
            $output = null;
            return 0;
        }
        $numRows = \oci_fetch_all($statement, $output, 0, -1, OCI_FETCHSTATEMENT_BY_ROW | OCI_ASSOC);
        if($numRows == false){
            $output = null;
            return 0;
        }
        return $numRows;
    }

    protected function freeStatement(&$statement){
        \oci_free_statement($statement);
    }
}