<?php

include_once __DIR__ . '/../core/base_controller.php';
include_once __DIR__ . '/../models/user.php';

class BaseControllerWithUserModel extends BaseController
{
  private $userModel;

  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod, $params);
    $this->userModel = new UserModel($db);
  }

  public function getUserModel()
  {
    return $this->userModel;
  }

  public function getAuthorization()
  {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
      return new Response(
        StatusCode::CLIENT_ERROR_401,
        json_encode(array("data" => "You are not loggined"))
      );
    }

    $user = $this->getUserModel()->verify(array(
      "email" => $_SERVER["PHP_AUTH_USER"],
      "password" => $_SERVER["PHP_AUTH_PW"]
    ));

    if ($user) {
      return $user;
    } else {
      return new Response(
        StatusCode::CLIENT_ERROR_401,
        json_encode(array("data" => "Incorrect email or password"))
      );
    }
  }
}
