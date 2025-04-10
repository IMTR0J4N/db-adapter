<?php 

namespace DBAdapter\Context\Types;

enum Repositories: string
{
    case ContractRepository = 'contract';
    case BillingRepository = 'billing';
    case CustomerRepository = 'customer';
    case VehicleRepository = 'vehicle';
}