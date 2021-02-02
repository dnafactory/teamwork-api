<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Customers extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/customers/{$id}.json", $params);
        return $this->extractData($rawResponse, 'customer');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call("/v2/customers/{$id}.json", $params);
        return $this->extractData($rawResponse, 'customers');
    }
}
