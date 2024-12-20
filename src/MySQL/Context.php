<?php

namespace DBAdapter\MySQL;

use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Services;
use DBAdapter\Services\BillingService;
use DBAdapter\Services\ContractService;
use DBAdapter\Services\CustomerService;
use DBAdapter\Services\ServiceInterface;
use DBAdapter\Services\VehicleService;

use PDO;
use PDOException;

class Context
{
    private $authOptions;

    public function __construct(array $authOptions)
    {
        $this->authOptions = $authOptions;

        try {
            $pdo = new PDO(
                "mysql:host={$authOptions['host']};port={$authOptions['port']};charset=utf8",
                $authOptions['username'],
                $authOptions['password']
            );
    
            $sql = file_get_contents('./src/MySQL/migration.sql');
    
            $sql = str_replace('?', $authOptions['database'], $sql);
    
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute();
        } catch (PDOException $e) {
            print(''. $e->getMessage());
        }
    }
    public function retrieveService(Services $service): ServiceInterface
    {
        return match ($service) {
            Services::BillingService => new BillingService(Adapters::MySQL, $this->authOptions),
            Services::ContractService => new ContractService(Adapters::MySQL, $this->authOptions),
            Services::CustomerService => new CustomerService(Adapters::MySQL, $this->authOptions),
            Services::VehicleService => new VehicleService(Adapters::MySQL, $this->authOptions),
            default => throw new \InvalidArgumentException("Service not found"),
        };
    }
}