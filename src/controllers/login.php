<?php

include_once __DIR__ . '/../core/base_controller.php';
include_once __DIR__ . '/../models/user.php';

class LoginController extends BaseController
{
  private $userModel;
  private $params;

  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod);

    $this->userModel = new UserModel($db);
    $this->params = $params;
  }

  public function post_method()
  {
    $input = (array) json_decode(file_get_contents('php://input'));
    if ($this->userModel->verify($input)) {
      session_start();
      $_SESSION['userEmail'] = $input['email'];
      return new Response(
        StatusCode::OK_200,
        json_encode(array('data' => 'ok'))
      );
    }
    return new Response(
      StatusCode::ERROR_422,
      json_encode("{}")
    );
  }
}
