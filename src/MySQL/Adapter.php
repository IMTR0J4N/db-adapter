<?php

namespace DBAdapter\MySQL;

use Exception;
use PDO;
use DBAdapter\Context\Interface\MySQLAdapterInterface;

class Adapter implements MySQLAdapterInterface
{
    private PDO $MySQLConnection;
    private static self|null $adapterInstance = null;

    public function retrieveConnection(string $host, string $port, string $db, string $username, string $password): PDO | Exception
    {
        try {
            if(isset($this->MySQLConnection)) {
                return $this->MySQLConnection;
            }
            
            return $this->MySQLConnection = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $username, $password);
        } catch (Exception $e) {
            return new Exception("MySQL connection error: " . $e->getMessage());
        }
    }

    public static function getAdapter(): self
    {
        if (self::$adapterInstance === null) {
            self::$adapterInstance = new self();
        }
        return self::$adapterInstance;
    }
}