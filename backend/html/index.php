<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Src\Core\DatabaseConnector;

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Method: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, X-Custom-Header");

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$dbConnector = new DatabaseConnector();
$requestMethod = $_SERVER["REQUEST_METHOD"];
$params = array();

$controller = "Src\QRBook\General\NotFoundController";

switch ($uri[1]) {
  case 'user':
    $controller = "Src\QRBook\User\UserController";
    break;
}

(new $controller(
    $dbConnector,
    $_SERVER["REQUEST_METHOD"],
    $params
))->processRequest();
