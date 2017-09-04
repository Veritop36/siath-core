<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 15/08/2017
 * Time: 20:31
 */

namespace siath\controllers\users;

require_once "controllers/BaseController.php";
require_once "services/users/UserService.php";
require_once "views/users/LoginView.php";

use lazyLoader\utils\ResponseUtil;
use siath\controllers\BaseController;
use siath\services\users\UserService;
use lazyLoader\controller\ControllerResponse;
use siath\utils\StringUtil;
use siath\views\users\LoginView;

final class UserController extends BaseController {

    function __construct() {
        $this->userService = new UserService();
    }

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @mapping /login
     * @method POST
     */
    public function login($postValues) {
        $success_ldap = $this->userService->getLdapUser($postValues->username, $postValues->password);
        if (!$success_ldap)
            return ControllerResponse::response202(false, "Error de usuario y/o contraseña");

        $tableUser = $this->userService->getUserByLdapUser($postValues->username);
        if (is_null($tableUser))
            return ControllerResponse::response202(false, "El usuario no tiene cuenta en el sistema");

        if($tableUser->getAccountStatus() != "OPEN")
            return ControllerResponse::response202(false, "El usuario no tiene activa la cuenta");
        $secureLdapPasswd = \md5($postValues->password);

        if($secureLdapPasswd != $tableUser->getPassword()){
            if(!$this->userService->updateUserPassword($tableUser, $postValues->password, $secureLdapPasswd))
                return ControllerResponse::response202(false, "Ocurrio un error al actualizar el usuario");
            $tableUser = $this->userService->getUserByLdapUser($postValues->username);
        }

        if (!$this->userService->checkUserConnection($tableUser->getUserName(), $postValues->password))
            return ControllerResponse::response202(false, "No se puede conectar a la base de datos");

        $loginView = new LoginView($tableUser->getFullName(), "sdhskjdhsjkdhskjdhskjdhjkshdjksdhjkshdk");
        return ControllerResponse::response202(true, "Bienvenido {$tableUser->getFullName()}", $loginView);
    }
}

function __construct() {
        $this->userService = new UserService();
    }
