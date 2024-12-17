<?php

namespace DBConnector\MySQL;

use DBConnector\Context\Types\Repositories;
use DBConnector\MySQL\Adapter\MySQLAdapter;
use PDO;

class Repository
{
    private Repositories $repository;
    private PDO $database;

    public function __construct(Repositories $repository, array $authOptions)
    {
        $this->repository = $repository;

        try {
            $this->database = MySQLAdapter::getAdapter()->retrieveConnection(
                $authOptions["host"],
                $authOptions["port"],
                $authOptions["db"],
                $authOptions["username"],
                $authOptions["password"]
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}