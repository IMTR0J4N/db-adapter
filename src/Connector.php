<?php
namespace DBAdapter;

use DBAdapter\MongoDB\MongoDBContext;
use DBAdapter\MySQL\Context as MySQLContext;
use DBAdapter\Context\Types\Adapters;
use InvalidArgumentException;

class Connector
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