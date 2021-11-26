<?php

include_once __DIR__ . '/./base_controller_with_user_model.php';
include_once __DIR__ . '/../models/user.php';
include_once __DIR__ . '/../core/validator.php';

class TestValidator extends Validator
{

  public function __construct()
  {
    parent::__construct(array(
      'email' => array("isEmail", ["lenInRange", [2, 50]]),
      'number' => array("isInt", ["inRange", [2, 10]])
    ));
  }
}

class TestValidatorContoller extends BaseControllerWithUserModel
{
  public function __construct($db, $requestMethod, $params)
  {
    parent::__construct($db, $requestMethod, $params);
  }

  public function postMethod()
  {
    $data = $this->getData();
    return new Response(
      StatusCode::SUCCESS_200,
      json_encode((new TestValidator())->check($data))
    );
  }
}
