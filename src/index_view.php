<?php

include_once __DIR__ . '/core/bootstrap.php';
include_once __DIR__ . '/core/headers.php';

include_once __DIR__ . '/controllers/not_found.php';
include_once __DIR__ . '/controllers/user.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = NotFoundController;

$params = array();

switch ($uri[1]) {
  case 'user':
    $controller = UserController;
    break;
}

if ($controller == null) {
  header(StatusCode::ERROR_404);
} else {
  (new $controller(
    $dbConnector,
    $_SERVER["REQUEST_METHOD"],
    $params
  ))->processRequest();
}
