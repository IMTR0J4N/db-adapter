<?php

namespace DBAdapter\MongoDB;

use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Services;
use DBAdapter\Services\BillingService;
use DBAdapter\Services\ContractService;
use DBAdapter\Services\CustomerService;
use DBAdapter\Services\ServiceInterface;
use DBAdapter\Services\VehicleService;

class Context
{
    private $authOptions;

    public function __construct(array $authOptions)
    {
        $this->authOptions = $authOptions;
    }

    public function retrieveService(Services $service): ServiceInterface
    {
        return match ($service) {
            Services::BillingService => new BillingService(Adapters::MongoDB, $this->authOptions),
            Services::ContractService => new ContractService(Adapters::MongoDB, $this->authOptions),
            Services::CustomerService => new CustomerService(Adapters::MongoDB, $this->authOptions),
            Services::VehicleService => new VehicleService(Adapters::MongoDB, $this->authOptions),
            default => throw new \InvalidArgumentException("Service not found"),
        };
    }
}