<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Customer;
use DNAFactory\Teamwork\RawEndpoints\Desk\Customers as RawCustomers;

class Customers extends DeskEndpoint
{
    const REF_TYPE_NAME = 'customers';
    const ARRAY_KEY_FOR_ENTRIES = 'customers';

    public function __construct(RawCustomers $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Customer
    {
        return new Customer($this, $id, ['id' => $id]);
    }
}
