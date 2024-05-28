<?php

require_once '../../vendor/autoload.php';

use App\core\Router;

session_start();

$router = new Router();
$router->route();
