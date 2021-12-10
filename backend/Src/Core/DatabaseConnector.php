<?php

namespace Src\Core;

use PDO;
use PDOException;

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
            $this->dbConnection = new PDO(
                "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$password"
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection(): ?PDO
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
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function executeStatement($statement_ = "", $params = [])
    {
        try {
            $statement = $this->dbConnection->prepare($statement_);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
