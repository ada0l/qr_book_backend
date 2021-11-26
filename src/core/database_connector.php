<?php

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

  public function select($statement_ = "", $params = [])
  {
    try {
      $statement = $this->dbConnection->prepare($statement_);
      if (!$statement) {
        return null;
      }
      $statement->execute($params);
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  public function executeStatement($statement_ = "", $params = [])
  {
    try {
      $statement = $this->dbConnection->prepare($statement_);
      $statement->execute($params);
      return $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }
}
