<?php

namespace DBConnector\Context\Class;

use DBConnector\Context\Types\Adapters;
use DBConnector\Context\Types\Repositories;
use MongoDB\BSON\ObjectId;

use DBConnector\MongoDB\Repository as MongoDBRepository;
use DBConnector\MySQL\Repository as MySQLRepository;

abstract class Service {

    private Adapters $adapter;
    protected array $authOptions;

    public function __construct(Adapters $adapter, array $authOptions) {
        $this->adapter = $adapter;
        $this->authOptions = $authOptions;
    }

    abstract public function findBy(string $field, mixed $value, array | null $options): array;

    abstract public function getAll(): array;

    abstract public function create(array $data): array;

    abstract public function update(ObjectId | string $id, array $data): array;

    abstract public function delete(ObjectId | string $id): array;

    private function retrieveRepository(Repositories $repository, array $authOptions): Repositories
    {
        $repository = match ($this->adapter) {
            Adapters::MySQL => MySQLRepository::class,
            Adapters::MongoDB => MongoDBRepository::class,
        };

        return new $repository($repository, $authOptions);
    }
}