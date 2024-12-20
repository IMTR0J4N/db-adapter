<?php

namespace DBConnector\MongoDB;

use DBConnector\Context\Types\Adapters;
use DBConnector\Context\Types\Services;
use DBConnector\Services\Billing;
use DBConnector\Services\Contract;
use DBConnector\Services\Customer;
use DBConnector\Services\Vehicle;

class MongoDBContext
{
    private $authOptions;

    public function __construct(array $authOptions)
    {
        $this->authOptions = $authOptions;
    }

    public function retrieveService(Services $service): Billing|Contract|Customer|Vehicle
    {
        return match ($service) {
            Services::BillingService => new Billing(Adapters::MongoDB, $this->authOptions),
            Services::ContractService => new Contract(Adapters::MongoDB, $this->authOptions),
            Services::CustomerService => new Customer(Adapters::MongoDB, $this->authOptions),
            Services::VehicleService => new Vehicle(Adapters::MongoDB, $this->authOptions),
            default => throw new \InvalidArgumentException("Service not found"),
        };
    }
}