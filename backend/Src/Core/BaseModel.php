<?php

namespace Src\Core;

use Exception;

class BaseModel
{
  private $db = null;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getConnector()
  {
    return $this->db;
  }

  public function findAll()
  {
    throw new Exception("Not implemented");
  }

  public function find($params)
  {
    throw new Exception("Not implemented");
  }

  public function insert($params)
  {
    throw new Exception("Not implemented");
  }

  public function delete($params)
  {
    throw new Exception("Not implemented");
  }
}
