<?php

namespace Src\QRBook\QRCode;

use Src\Core\BaseModel;

class ScanModel extends BaseModel
{
    public function insert($params)
    {
        $statement = "
        INSERT INTO qr_scan
            (card_id)
        VALUES
            (:card_id)
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }
}