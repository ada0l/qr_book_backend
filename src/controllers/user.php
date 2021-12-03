<?php

include_once __DIR__ . '/./base_controller_with_user_model.php';
include_once __DIR__ . '/../models/user.php';
include_once __DIR__ . '/../validators/create_user.php';

class UserController extends BaseControllerWithUserModel
{
  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod, $params);
    $this->addMethodValidator("POST", CreateUserValidator);
  }

  /*
   * Get current user
   */
  public function getMethod()
  {
    $auth = $this->getAuthorization();
    if (is_array($auth)) {
      return new Response(
        StatusCode::SUCCESS_200,
        json_encode($auth)
      );
    }
    return $auth;
  }

  /*
   * Create user
   */
  public function postMethod()
  {
    $input = $this->getData();
    $result = $this->getUserModel()->find($input['email']);
    if ($result != null) {
      return new Response(
        StatusCode::CLIENT_ERROR_400,
        json_encode(array(
          "data" => "email is busy"
        ))
      );
    }
    $result = $this->getUserModel()->insert($input);
    if ($result == null) {
      return $this->unprocessableEntityResponse();
    } else {
      return new Response(
        StatusCode::SUCCESS_201,
        json_encode(array(
          "data" => "The user is created"
        ))
      );
    }
  }
}
