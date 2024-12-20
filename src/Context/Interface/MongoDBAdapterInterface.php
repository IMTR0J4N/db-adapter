<?php

namespace DBConnector\Context\Interface;

interface MongoDBAdapterInterface
{
    public function retrieveConnection(string $uri);
    static function getAdapter();
}