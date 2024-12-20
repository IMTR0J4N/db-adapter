<?php

use PHPUnit\Framework\TestCase;
use DBAdapter\DBAdapter;
use DBAdapter\Context\Types\Adapters;
use DBAdapter\MySQL\MySQLContext;
use DBAdapter\MongoDB\MongoDBContext;

class DBAdapterTest extends TestCase
{
    /**
     * Test la création réussie d'un MySQLContext avec les options d'authentification correctes.
     */
    public function testUseAdapterMySQLSuccess()
    {
        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = DBAdapter::useAdapter(Adapters::MySQL, $authOptions);

        $this->assertInstanceOf(MySQLContext::class, $context);
    }

    /**
     * Test le lancement d'une exception lorsque les options d'authentification MySQL sont manquantes.
     */
    public function testUseAdapterMySQLMissingOptions()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing authentication options for MySQL adapter");

        $authOptions = [
            //'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        DBAdapter::useAdapter(Adapters::MySQL, $authOptions);
    }

    /**
     * Test la création réussie d'un MongoDBContext avec les options d'authentification correctes.
     */
    public function testUseAdapterMongoDBSuccess()
    {
        $authOptions = [
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = DBAdapter::useAdapter(Adapters::MongoDB, $authOptions);

        $this->assertInstanceOf(MongoDBContext::class, $context);
    }

    /**
     * Test le lancement d'une exception lorsque les options d'authentification MongoDB sont manquantes.
     */
    public function testUseAdapterMongoDBMissingOptions()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing authentication options for MongoDB adapter');

        $authOptions = [
            // 'uri' => 'mongodb://localhost:27017', // Manquant
            'database' => 'dbadapter',
        ];

        DBAdapter::useAdapter(Adapters::MongoDB, $authOptions);
    }

    /**
     * Test le lancement d'une exception lorsqu'un adaptateur non supporté est utilisé.
     */
    public function testUseAdapterUnsupportedAdapter()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unsupported adapter type");

        // Utilisation de l'adaptateur non supporté Adapters::UNKNOWN_TEST
        DBAdapter::useAdapter(Adapters::UNKNOWN_TEST, []);
    }

    /**
     * Test de la méthode useAdapter avec des options d'authentification incorrectes pour MongoDB.
     */
    public function testUseAdapterMongoDBMissingDatabaseOption()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing authentication options for MongoDB adapter');

        $authOptions = [
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            // 'database' => 'test_db', // Manquant
        ];

        DBAdapter::useAdapter(Adapters::MongoDB, $authOptions);
    }

    /**
     * Test de la méthode useAdapter avec des options d'authentification incorrectes pour MySQL.
     */
    public function testUseAdapterMySQLMissingDatabaseOption()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing authentication options for MySQL adapter");

        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            //'database' => 'dbadapter',
        ];

        DBAdapter::useAdapter(Adapters::MySQL, $authOptions);
    }
}
