<?php

include_once __DIR__ . '/./base_controller_with_user_model.php';
include_once __DIR__ . '/../models/user.php';

class UserController extends BaseControllerWithUserModel
{
  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod, $params);
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
    $input = (array) json_decode(file_get_contents('php://input'));
    $result = $this->getUserModel()->insert($input);
    if ($result == null) {
      return $this->unprocessableEntityResponse();
    } else {
      return new Response(
        StatusCode::OK_201,
        json_encode(array(
          "data" => 'The user is created'
        ))
      );
    }
  }
}
