<?php

namespace Src\Core;

use Exception;
use Src\Core\DatabaseConnector;

class BaseModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getConnector(): DatabaseConnector
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
