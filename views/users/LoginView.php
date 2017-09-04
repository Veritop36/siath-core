<?php

/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 04/09/2017
 * Time: 15:19
 */

namespace siath\views\users;
use siath\model\users\UserModel;

class LoginView extends \siath\views\BaseView {

    private $fullUserName;
    private $token;

    /**
     * LoginView constructor.
     * @param $fullUserName
     * @param $token
     */
    public function __construct($fullUserName, $token) {
        $this->fullUserName = $fullUserName;
        $this->token = $token;
    }

    /**
     * @param UserModel $user
     * @param string $token
     * @return LoginView
     */
    public static function createFromUser($user, $token){
        $fullName = "{$user->getName()} {$user->getLastName()}";
        return new self($fullName, $token);
    }


    /**
     * @return mixed
     */
    public function getFullUserName() {
        return $this->fullUserName;
    }

    /**
     * @return mixed
     */
    public function getToken() {
        return $this->token;
    }

}