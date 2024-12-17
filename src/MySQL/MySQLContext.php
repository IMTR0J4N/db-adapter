<?php

namespace DBConnector\MySQL;

use DBConnector\Context\Types\Services;

class MySQLContext
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