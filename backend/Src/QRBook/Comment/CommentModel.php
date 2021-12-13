<?php

namespace Src\QRBook\Comment;

use Src\Core\BaseModel;

class CommentModel extends BaseModel
{
    public function findAll($params)
    {
        $statement = "
        SELECT *
        FROM qr_comment
        ORDER BY
            date_update ${params['order']}
        ";
        unset($params['order']);
        return $this->getConnector()->select(
            $statement
        );
    }
    public function find($params)
    {
        $statement = "
        SELECT *
        FROM qr_comment
        WHERE id=:id
        ";
        return $this->getConnector()->select(
            $statement,
            $params
        )[0];
    }

    public function findByUserId($params)
    {
        $statement = "
        SELECT *
        FROM qr_comment
        WHERE user_id=:user_id
        ";
        return $this->getConnector()->select(
            $statement,
            $params
        )[0];
    }

    public function insert($params)
    {
        $statement = "
        INSERT INTO qr_comment
            (text, mark, user_id)
        VALUES
            (:text, :mark, :user_id)
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

    public function update($params) {
        $statement = "
        UPDATE
            qr_comment
        SET
            text=:text,
            mark=:mark,
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
            qr_comment
        WHERE
            id=:id
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }

}