<?php
/**
 * Created by PhpStorm.
 * User: Lisbeth
 * Date: 17/08/2017
 * Time: 11:54
 */

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require_once "config.php";
require_once "routes.php";
require_once "utils/StringUtil.php";
require_once "views/BaseView.php";
require_once "vendor/andresandoval/php-lazy-loader/index.php";
require_once "vendor/autoload.php";

use lazyLoader\controller\ControllerHandler;

ControllerHandler::handleRoute($SIATH_ROUTES);
