<?php

namespace DBConnector\MySQL\Adapter;

use Exception;
use PDO;
use DBConnector\Context\Interface\MySQLAdapterInterface;

class MySQLAdapter implements MySQLAdapterInterface
{
    private PDO $MySQLConnection;
    private static MySQLAdapter $adapterInstance;

    public function retrieveConnection(string $host, string $port, string $db, string $username, string $password): PDO | Exception
    {
        try {
            if(isset($this->MySQLConnection)) {
                return $this->MySQLConnection;
            }

            return $this->MySQLConnection = new PDO("mysql:host=$host:$port;dbname=$db", $username, $password);
        } catch (Exception $e) {
            return new Exception("MySQL connection error: " . $e->getMessage());
        }
    }

    public static function getAdapter(): MySQLAdapter
    {
        if (self::$adapterInstance === null) {
            self::$adapterInstance = new self();
        }
        return self::$adapterInstance;
    }
}