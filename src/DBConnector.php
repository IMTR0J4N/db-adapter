<?php
namespace DBConnector;

use DBConnector\Context\Types\Services;
use DBConnector\MongoDB\MongoDBContext;
use DBConnector\MySQL\MySQLContext;
use DBConnector\Context\Types\Adapters;
use InvalidArgumentException;

class DBConnector
{
    static function useAdapter(Adapters $adapter, array $authOptions): MongoDBContext|MySQLContext
    {
        switch ($adapter) {
            case Adapters::MySQL:
                if (!isset($authOptions['host'], $authOptions['port'], $authOptions['username'], $authOptions['password'], $authOptions['database'])) {
                    throw new InvalidArgumentException("Missing authentication options for MySQL adapter");
                }

                return new MySQLContext($authOptions);

            case Adapters::MongoDB:
                if (!isset($authOptions['uri'], $authOptions['database'])) {
                    throw new InvalidArgumentException('Missing authentication options for MongoDB adapter');
                }
                return new MongoDBContext($authOptions);
                
            default:
                throw new InvalidArgumentException("Unsupported adapter type");
        }
    }
}

DBConnector::useAdapter(Adapters::MongoDB, $authOptions)->retrieveService(Services::ContractService);