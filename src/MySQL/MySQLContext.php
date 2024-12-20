<?php

namespace DBConnector\MySQL;

use DBConnector\Context\Types\Adapters;
use DBConnector\Context\Types\Services;
use DBConnector\Services\Billing;
use DBConnector\Services\Contract;
use DBConnector\Services\Customer;
use DBConnector\Services\Vehicle;

use PDO;
use PDOException;

class MySQLContext
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
    public function retrieveService(Services $service): Billing|Contract|Customer|Vehicle
    {
        return match ($service) {
            Services::BillingService => new Billing(Adapters::MySQL, $this->authOptions),
            Services::ContractService => new Contract(Adapters::MySQL, $this->authOptions),
            Services::CustomerService => new Customer(Adapters::MySQL, $this->authOptions),
            Services::VehicleService => new Vehicle(Adapters::MySQL, $this->authOptions),
            default => throw new \InvalidArgumentException("Service not found"),
        };
    }
}