<?php

namespace Src\QRBook\User;

use Src\Core\BaseModel;

class RoleModel extends BaseModel
{
  public function find($text)
  {
    $statement = "SELECT id, text FROM qr_role WHERE text = :text";
    return $this->getConnector()->select($statement, array($text))[0];
  }
  public function findWithPermissions($id)
  {
    $statement = "
      SELECT
          r.text as name, string_agg(p.text, ',') as permissions
      FROM
          qr_role r
      LEFT JOIN
          qr_role_permission rp ON rp.role_id = r.id
      LEFT JOIN
          qr_permission p ON p.id = rp.permission_id
      WHERE
          r.id = :id
      GROUP BY
          r.id;";
    return $this->getConnector()->select($statement, array($id))[0];
  }
}

