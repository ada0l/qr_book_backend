<?php

namespace Src\QRBook\QRCode;

use Src\Core\BaseModel;

class QRCodeModel extends BaseModel
{
    public function findAll($params)
    {
        $statement = "
        SELECT
            c.*, COUNT(s) as scans
        FROM
            qr_card c
        LEFT JOIN
            qr_scan s ON s.card_id = c.id
        WHERE
            c.user_id = :user_id
        GROUP BY
            c.id
        ORDER BY
            date_update ${params['order']}
        ";
        unset($params['order']);
        return $this->getConnector()->select($statement, $params);
    }

    public function find($params)
    {
        $statement = "
        SELECT
            c.*, COUNT(s) as scans
        FROM
            qr_card c
        LEFT JOIN
            qr_user u ON u.id = c.user_id
        LEFT JOIN
            qr_scan s ON s.card_id = c.id
        WHERE
            c.id = :id
        GROUP BY
            c.id
        ";
        return $this->getConnector()->select($statement, $params)[0];
    }

    public function findByUUID($params)
    {
        $statement = "
        SELECT
            c.*
        FROM
            qr_card c
        WHERE
            c.uuid = :uuid
        ";
        return $this->getConnector()->select($statement, $params)[0];
    }

    public function insert($params)
    {
        $statement = "
        INSERT INTO qr_card
            (title, text, uuid, user_id, light_color, dark_color, frame_id, frame_text, frame_color,
                frame_text_color, quality)
        VALUES
            (:title, :text, :uuid, :user_id, :light_color, :dark_color, :frame_id, :frame_text, :frame_color,
                :frame_text_color, :quality)
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function update($params)
    {
        $statement = "
        UPDATE 
            qr_card
        SET
            title=:title,
            text=:text,
            light_color=:light_color,
            dark_color=:dark_color,
            frame_id=:frame_id,
            frame_text=:frame_text,
            frame_color=:frame_color,
            frame_text_color=:frame_text_color,
            quality=:quality,
            date_update=(now() at time zone 'utc')
        WHERE
            id=:id
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function delete($params)
    {
        $statement = "
        DELETE FROM
            qr_card
        WHERE
            id=:id
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function getCount()
    {
        $statement = "
        SELECT
            COUNT(*)
        FROM
            qr_card;
        ";

        return $this->getConnector()->select(
            $statement
        )[0]['count'];
    }
}
