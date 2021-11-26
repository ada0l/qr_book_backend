<?php

include_once __DIR__ . '/./base_controller_with_user_model.php';
include_once __DIR__ . '/../models/user.php';

class NotFoundController extends BaseControllerWithUserModel
{
  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod, $params);
  }

  public function getResponse() {
    return $this->notFoundResponse();
  }
}
