<?php

namespace DBConnector\Test;

use DBConnector\MongoDB\MongoDBAdapter;
use MongoDB\Client;
use PHPUnit\Framework\TestCase;

class MongoDBAdapterTest extends TestCase
{
    /**
     * Test the createClient method with a valid MongoDB URI.
     */
    public function testCreateClientWithValidUri(): void
    {
        $uri = 'mongodb://localhost:27017';
        $adapter = new MongoDBAdapter();

        $client = $adapter->createClient($uri);

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * Test the createClient method with an invalid MongoDB URI.
     */
    public function testCreateClientWithInvalidUri(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/MongoDB connection error:.*/');

        $uri = 'invalid_uri';
        $adapter = new MongoDBAdapter();

        $adapter->createClient($uri);
    }
}