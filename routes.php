<?php

/*
	Define la ruta de los controladores que responden a las peticiones desde el cliente
*/

$SIATH_ROUTES = [
	"/users" => ["controllers/users/UserController.php", \siath\controllers\users\UserController::class]
];