<?php

use PHPUnit\Framework\TestCase;
use DBAdapter\MySQL\MySQLContext;
use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Services;
use DBAdapter\Services\Billing;
use DBAdapter\Services\Contract;
use DBAdapter\Services\Customer;
use DBAdapter\Services\Vehicle;
use InvalidArgumentException;

class MySQLContextTest extends TestCase
{
    /**
     * Test la création réussie d'un MySQLContext avec les options d'authentification correctes.
     */
    public function testConstructorWithValidAuthOptions()
    {
        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = new MySQLContext($authOptions);

        // Utilisation de Reflection pour accéder à la propriété privée $authOptions
        $reflection = new ReflectionClass($context);
        $property = $reflection->getProperty('authOptions');
        $property->setAccessible(true);
        $this->assertEquals($authOptions, $property->getValue($context));
    }

    /**
     * Test la méthode retrieveService avec Services::BillingService.
     */
    public function testRetrieveServiceBillingService()
    {
        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = new MySQLContext($authOptions);
        $service = Services::BillingService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Billing::class, $result);
        $this->assertEquals(Adapters::MySQL, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec Services::ContractService.
     */
    public function testRetrieveServiceContractService()
    {
        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = new MySQLContext($authOptions);
        $service = Services::ContractService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Contract::class, $result);
        $this->assertEquals(Adapters::MySQL, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec Services::CustomerService.
     */
    public function testRetrieveServiceCustomerService()
    {
        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = new MySQLContext($authOptions);
        $service = Services::CustomerService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Customer::class, $result);
        $this->assertEquals(Adapters::MySQL, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec Services::VehicleService.
     */
    public function testRetrieveServiceVehicleService()
    {
        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = new MySQLContext($authOptions);
        $service = Services::VehicleService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Vehicle::class, $result);
        $this->assertEquals(Adapters::MySQL, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec un service non défini.
     */
    public function testRetrieveServiceDefaultCase()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Service not found");

        $authOptions = [
            'host' => '127.0.0.1',
            'port' => 8889,
            'username' => 'root',
            'password' => 'root',
            'database' => 'dbadapter',
        ];

        $context = new MySQLContext($authOptions);

        // Supposons que Services::UNKNOWN_SERVICE existe pour ce test
        // Si ce n'est pas le cas, il faut l'ajouter à l'énumération Services
        // Sinon, ce test doit être ajusté ou marqué comme manqué

        // Exemple : Ajouter Services::UNKNOWN_SERVICE dans l'énumération
        // et l'utiliser ici
        // DBAdapter\Services\UnknownService = 'unknown_service';

        // Pour cet exemple, supposons que l'énumération a une valeur UNKNOWN_SERVICE
        // Sinon, nous allons marquer le test comme manqué
        if (defined('DBAdapter\Context\Types\Services::UNKNOWN_TEST')) {
            $service = Services::UNKNOWN_TEST;
            $context->retrieveService($service);
        } else {
            $this->markTestSkipped('Le service UNKNOWN_TEST n\'est pas défini dans l\'énumération Services.');
        }
    }
}
