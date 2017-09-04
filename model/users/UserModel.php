<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 23/08/2017
 * Time: 16:08
 */

namespace siath\model\users;

require_once "model/BaseModel.php";

use siath\model\BaseModel;

final class UserModel extends BaseModel {

    /**
     * @column SIS03LOG
     * @type string
     */
    private $userName;

    /**
     * @column SIS03NOM
     * @type string
     */
    private $name;

    /**
     * @column SIS03APE
     * @type string
     */
    private $lastName;

    /**
     * @column SIS03DES
     * @type string
     */
    private $fullName;

    /**
     * @column RH00CED
     * @type string
     */
    private $identificationNumber;

    /**
     * @column SIS03LDAP
     * @type string
     */
    private $ldapUserName;

    /**
     * @column SIS03PWD
     * type string
     */
    private $password;

    /**
     * @column SIS03INI
     * @type string
     */
    private $initials;

    /**
     * @column ACCOUNT_STATUS
     * @type string
     */
    private $accountStatus;

    /**
     * @return string
     */
    public function getUserName() {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName) {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getIdentificationNumber() {
        return $this->identificationNumber;
    }

    /**
     * @param string $identificationNumber
     */
    public function setIdentificationNumber($identificationNumber) {
        $this->identificationNumber = $identificationNumber;
    }

    /**
     * @return string
     */
    public function getLdapUserName() {
        return $this->ldapUserName;
    }

    /**
     * @param string $ldapUserName
     */
    public function setLdapUserName($ldapUserName) {
        $this->ldapUserName = $ldapUserName;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getInitials() {
        return $this->initials;
    }

    /**
     * @param string $initials
     */
    public function setInitials($initials) {
        $this->initials = $initials;
    }

    /**
     * @return string
     */
    public function getAccountStatus() {
        return $this->accountStatus;
    }

    /**
     * @param string $accountStatus
     */
    public function setAccountStatus($accountStatus) {
        $this->accountStatus = $accountStatus;
    }


}