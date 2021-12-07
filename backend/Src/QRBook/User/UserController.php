<?php

namespace Src\QRBook\User;

use Src\Core\Response;
use Src\Core\StatusCode;
use Src\QRBook\General\BaseControllerWithUserModel;

class UserController extends BaseControllerWithUserModel
{
  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod, $params);
    $this->addMethodValidator("POST", "Src\QRBook\User\CreateUserValidator");
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
    $result = $this->getUserModel()->find(
      array("email" => $input['email'])
    );
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
