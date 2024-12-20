<?php

namespace DBConnector\MongoDB\Adapter;

use Exception;
use MongoDB\Client;
use DBConnector\Context\Interface\MongoDBAdapterInterface;

class MongoDBAdapter implements MongoDBAdapterInterface
{
    private Client $MongoDBConnection;
    private static MongoDBAdapter|null $adapterInstance = null;

    public function retrieveConnection(string $uri): Client | Exception
    {
        try {
            if(isset($this->MongoDBConnection)) {
                return $this->MongoDBConnection;
            }
            return $this->MongoDBConnection = new Client($uri);
        } catch (Exception $e) {
            return new Exception("MongoDB connection error: " . $e->getMessage());
        }
    }

    public static function getAdapter(): MongoDBAdapter
    {
        if (self::$adapterInstance === null) {
            self::$adapterInstance = new self();
        }
        return self::$adapterInstance;
    }
}