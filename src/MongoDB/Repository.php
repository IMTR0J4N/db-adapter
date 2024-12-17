<?php

namespace DBConnector\MongoDB;

use DBConnector\Context\Types\Repositories;
use DBConnector\MongoDB\Adapter\MongoDBAdapter;
use MongoDB\Client;

class Repository
{
    private Repositories $repository;
    private Client $database;

    public function __construct(Repositories $repository, array $authOptions)
    {
        $this->repository = $repository;
        $this->database = MongoDBAdapter::getAdapter()->retrieveConnection($authOptions["uri"]);
    }

}