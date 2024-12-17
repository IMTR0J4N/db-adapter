<?php 

namespace DBConnector\Context\Types;

enum Services: string
{
    case ContractService = 'contract';
    case BillingService = 'billing';
    case CustomerService = 'customer';
    case VehicleService = 'vehicle';
}