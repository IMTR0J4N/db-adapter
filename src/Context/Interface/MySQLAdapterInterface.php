<?php

namespace DBAdapter\Context\Interface;

interface MySQLAdapterInterface
{
    public function retrieveConnection(string $host, string $port, string $db, string $username, string $password);
    static function getAdapter();
}