<?php

namespace Src\Core;

use Exception;

class BaseModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getConnector()
    {
        return $this->db;
    }

    /**
     * @throws Exception
     */
    public function findAll()
    {
        throw new Exception("Not implemented");
    }

    /**
     * @throws Exception
     */
    public function find($params)
    {
        throw new Exception("Not implemented");
    }

    /**
     * @throws Exception
     */
    public function insert($params)
    {
        throw new Exception("Not implemented");
    }

    /**
     * @throws Exception
     */
    public function delete($params)
    {
        throw new Exception("Not implemented");
    }
}
