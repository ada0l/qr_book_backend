<?php

namespace Src\Core;

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
}
