<?php
require_once '../vendor/autoload.php';

phpinfo();

use Core\Router;
use App\app\controllers\WebController;

$router = new Router();
$router->route();
?>

