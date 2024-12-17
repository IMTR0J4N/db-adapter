<?php

namespace DBConnector\Services;

use DBConnector\Context\Class\Service;
use DBConnector\Context\Types\Adapters;
use DBConnector\Context\Types\Repositories;

class Contract extends Service
{
    public function __construct(Adapters $adapter, array $authOptions)
    {
        parent::__construct($adapter, $authOptions);
    }

    public function findBy(string $field, mixed $value, array|null $options): array
    {
        try {
            $repository = $this->retrieveRepository(Repositories::ContractRepository, $this->authOptions);

            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAll(): array
    {

    }

    public function create(array $data): array
    {

    }

    public function update(ObjectId | uniqid $id, array $data): array
    {

    }

    public function delete(ObjectId | uniqid $id): array
    {

    }
}