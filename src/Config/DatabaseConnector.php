<?php

namespace Src\Config;

class DatabaseConnector
{

    private static $database = null;
    private $connection = null;

    public function __construct()
    {
        $this->createConnection();
    }

    private function createConnection():void
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {
            $this->connection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    static function getInstance(): DatabaseConnector
    {
        if (null == self::$database) {
            self::$database = new DatabaseConnector();
        }
        return self::$database;
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}
