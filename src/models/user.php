<?php

include_once __DIR__ . '/../core/database_base_model.php';
include_once __DIR__ . '/role.php';

class UserModel extends BaseModel
{
  public function findAll()
  {
    $statement = "SELECT * FROM qr_user";
    return $this->getConnector()->select($statement);
  }

  public function find($email)
  {
    $result = $this->findWithPassword($email);
    $result["password"] = null;
    unset($result["password"]);

    return $result;
  }

  public function findWithPassword($email)
  {
    $statement = "
      SELECT
        id, name, email, password, role_id
      FROM
        qr_user
      WHERE
        email = :email";
    $result = $this->getConnector()->select(
      $statement,
      array("email" => $email)
    )[0];

    if ($result == null) {
      return null;
    }

    // get permissions as string
    $result["role"] =
      (new RoleModel($this->getConnector()))->findWithPermissions($result['role_id']);

    // conver string to array
    $result["role"]["permissions"] =
      explode(',', $result["role"]["permissions"]);

    unset($result["role_id"]);

    return $result;
  }

  public function insert($params)
  {
    $statement = "
      INSERT INTO qr_user
        (email, name, password, role_id)
      VALUES
        (:email, :name, :password, :role_id)";
    $params['password'] = password_hash(
      $params['password'],
      PASSWORD_DEFAULT
    );
    $params['role_id'] =
      (new RoleModel($this->getConnector()))->find("common")['id'];
    return $this->getConnector()->executeStatement(
      $statement,
      $params
    );
  }

  public function verify($params)
  {
    $user = $this->findWithPassword($params['email']);
    if (!$user) {
      return null;
    }
    if (password_verify($params['password'], $user['password'])) {
      unset($user['password']);
      return $user;
    } else {
      return null;
    }
  }
}
