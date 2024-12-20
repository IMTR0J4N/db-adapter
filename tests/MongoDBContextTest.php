<?php

use PHPUnit\Framework\TestCase;
use DBAdapter\MongoDB\MongoDBContext;
use DBAdapter\Context\Types\Adapters;
use DBAdapter\Context\Types\Services;
use DBAdapter\Services\Billing;
use DBAdapter\Services\Contract;
use DBAdapter\Services\Customer;
use DBAdapter\Services\Vehicle;
use InvalidArgumentException;

class MongoDBContextTest extends TestCase
{
    /**
     * Test la création réussie d'un MongoDBContext avec les options d'authentification correctes.
     */
    public function testConstructorWithValidAuthOptions()
    {
        $authOptions = [
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = new MongoDBContext($authOptions);

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
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = new MongoDBContext($authOptions);
        $service = Services::BillingService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Billing::class, $result);
        $this->assertEquals(Adapters::MongoDB, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec Services::ContractService.
     */
    public function testRetrieveServiceContractService()
    {
        $authOptions = [
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = new MongoDBContext($authOptions);
        $service = Services::ContractService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Contract::class, $result);
        $this->assertEquals(Adapters::MongoDB, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec Services::CustomerService.
     */
    public function testRetrieveServiceCustomerService()
    {
        $authOptions = [
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = new MongoDBContext($authOptions);
        $service = Services::CustomerService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Customer::class, $result);
        $this->assertEquals(Adapters::MongoDB, $result->getAdapter());
        $this->assertEquals($authOptions, $result->getAuthOptions());
    }

    /**
     * Test la méthode retrieveService avec Services::VehicleService.
     */
    public function testRetrieveServiceVehicleService()
    {
        $authOptions = [
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = new MongoDBContext($authOptions);
        $service = Services::VehicleService;

        $result = $context->retrieveService($service);

        $this->assertInstanceOf(Vehicle::class, $result);
        $this->assertEquals(Adapters::MongoDB, $result->getAdapter());
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
            'uri' => 'mongodb+srv://imtr0j4n:tstXCU8hW7mWNo6x@imtr0j4n.qvvcl.mongodb.net/',
            'database' => 'dbadapter',
        ];

        $context = new MongoDBContext($authOptions);

        // Utilisation de l'adaptateur non supporté Services::UNKNOWN_SERVICE
        // Assurez-vous que Services::UNKNOWN_SERVICE est défini dans l'énumération Services
        $service = Services::UNKNOWN_TEST;

        $context->retrieveService($service);
    }
}
