<?php

namespace Src\QRBook\User;

use Src\Core\BaseModel;

class UserModel extends BaseModel
{
    public function find($params)
    {
        $result = $this->findWithPassword(array("email" => $params['email']));
        $result["password"] = null;
        unset($result["password"]);

        return $result;
    }

    public function findWithPassword($params)
    {
        $statement = "
        SELECT
            id, name, email, password, role_id, image_hash
        FROM
            qr_user
        WHERE
            email=:email";
        $result = $this->getConnector()->select(
            $statement,
            $params
        )[0];

        if ($result == null) {
            return null;
        }

        // get permissions as string
        $result["role"] =
            (new RoleModel($this->getConnector()))->findWithPermissions(
                array('id' => $result['role_id']));

        // convert string to array
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
            (new RoleModel($this->getConnector()))->find(array("text" => "common"))['id'];
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function update($params)
    {
        $statement = "
        UPDATE
            qr_user
        SET
            email=:email,
            name=:name,
            date_update=(now() at time zone 'utc')
        WHERE
            email=:email_last
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function setImageHash($params)
    {
        $statement = "
        UPDATE
            qr_user
        SET
            image_hash=:hash,
            date_update=(now() at time zone 'utc')
        WHERE
            id=:id
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function verify($params)
    {
        $user = $this->findWithPassword(array('email' => $params['email']));
        if (!$user) return null;
        if (password_verify($params['password'], $user['password'])) {
            unset($user['password']);
            return $user;
        } else {
            return null;
        }
    }

    public function getCount()
    {
        $statement = "
        SELECT
            COUNT(*)
        FROM
            qr_user;
        ";

        return $this->getConnector()->select(
            $statement
        )[0]['count'];
    }
}
