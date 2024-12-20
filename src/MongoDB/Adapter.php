<?php

namespace DBAdapter\MongoDB;

use Exception;
use MongoDB\Client;
use DBAdapter\Context\Interface\MongoDBAdapterInterface;

class Adapter implements MongoDBAdapterInterface
{
    private Client $MongoDBConnection;
    private static self|null $adapterInstance = null;

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

    public static function getAdapter(): self
    {
        if (self::$adapterInstance === null) {
            self::$adapterInstance = new self();
        }
        return self::$adapterInstance;
    }
}