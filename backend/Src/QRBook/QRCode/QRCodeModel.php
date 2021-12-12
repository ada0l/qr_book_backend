<?php

namespace Src\QRBook\QRCode;

use Src\Core\BaseModel;

class QRCodeModel extends BaseModel
{
    public function findAll($params)
    {
        $statement = "
        SELECT
            c.*, u.email
        FROM
            qr_card c
        LEFT JOIN
            qr_user u ON u.id = c.user_id
        WHERE
            u.email = :email
        ";
        return $this->getConnector()->select($statement, $params);
    }

    public function find($params) {
        $statement = "
        SELECT
            c.*, u.email
        FROM
            qr_card c
        LEFT JOIN
            qr_user u ON u.id = c.user_id
        WHERE
            c.id = :id
        ";
        return $this->getConnector()->select($statement, $params)[0];
    }
}
