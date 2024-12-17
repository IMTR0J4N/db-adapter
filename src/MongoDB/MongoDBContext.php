<?php

namespace DBConnector\MongoDB;

use DBConnector\Context\Types\Services;

class MongoDBContext
{
    private $authOptions;

    public function __construct(array $authOptions)
    {
        $this->authOptions = $authOptions;
    }

    public function retrieveService(Services $service): int
    {
        return match ($service) {
            Services::BillingService => print (true),
            Services::ContractService => print (true),
            Services::CustomerService => print (true),
            Services::VehicleService => print (true),
            default => print (false)
        };
    }
}