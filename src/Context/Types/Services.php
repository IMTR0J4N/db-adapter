<?php 

namespace DBAdapter\Context\Types;

enum Services: string
{
    case ContractService = 'contract';
    case BillingService = 'billing';
    case CustomerService = 'customer';
    case VehicleService = 'vehicle';
    case UNKNOWN_TEST = '';
}