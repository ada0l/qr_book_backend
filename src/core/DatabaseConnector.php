<?php

namespace Database;

class DatabaseConnector
{
  private $dbConnection = null;

  public function __construct()
  {
    $host = getenv("POSTGRES_DB_HOST");
    $db = getenv("POSTGRES_DB_NAME");
    $port = getenv("POSTGRES_DB_PORT");
    $user = getenv("POSTGRES_DB_USER");
    $password = getenv("POSTGRES_DB_PASSWORD");
    try {
      $this->dbConnection = new \PDO(
        "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$password"
      );
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  public function getConnection()
  {
    return $this->dbConnection;
  }
}
