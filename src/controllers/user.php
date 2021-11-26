<?php

include_once __DIR__ . '/../core/base_controller.php';
include_once __DIR__ . '/../models/user.php';

class UserController extends BaseController
{
  private $userModel;
  private $params;

  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod);

    $this->userModel = new UserModel($db);
    $this->params = $params;
  }

  /*
   * Get current user
   */
  public function get_method()
  {
    session_start();
    if ($_SESSION['userEmail']) {
      return new Response(
        StatusCode::OK_200,
        json_encode($this->userModel->find($_SESSION['userEmail']))
      );
    } else {
      return new Response(
        StatusCode::ERROR_401,
        json_encode(array("data" => "You are not loggined"))
      );
    }
  }

  /*
   * Create user
   */
  public function post_method()
  {
    $input = (array) json_decode(file_get_contents('php://input'));
    $result = $this->userModel->insert($input);
    if ($result == null) {
      return new Response(StatusCode::ERROR_422, json_encode("{}"));
    } else {
      return new Response(
        StatusCode::OK_201,
        json_encode(array(
          "id" => $result
        ))
      );
    }
  }
}
