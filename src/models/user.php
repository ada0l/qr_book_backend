<?php

include_once __DIR__ . '/../core/database_base_model.php';

class UserModel extends BaseModel
{
  public function findAll()
  {
    $statement = "SELECT * FROM qr_user";
    return $this->getConnector()->select($statement);
  }

  public function find($email)
  {
    $statement = "SELECT name, email, password FROM qr_user WHERE email = :email";
    $result = $this->getConnector()->select(
      $statement,
      array("email" => $email)
    );
    if ($result != []) {
      return $result[0];
    }
    return null;
  }

  public function insert($params)
  {
    $statement = "
      INSERT INTO qr_user
        (email, name, password)
      VALUES
        (:email, :name, :password)";
    $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
    return $this->getConnector()->executeStatement($statement, $params);
  }

  public function verify($params)
  {
    $user = $this->find($params['email']);
    if (!$user) {
      echo ("Not found");
      return false;
    }
    return password_verify($params['password'], $user['password']);
  }
}
