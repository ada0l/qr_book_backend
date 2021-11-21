<?php
require 'vendor/autoload.php';

use Database\DatabaseConnector;

$dbConnection = (new DatabaseConnector())->getConnection();
$statement = "
            SELECT 
*
            FROM
                qr_user
";

$statement = $dbConnection->query($statement);
$result = $statement->fetchAll(\PDO::FETCH_ASSOC);

var_dump($result);

