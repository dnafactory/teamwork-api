<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Customers extends DeskRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/desk/api/v2/customers/{$id}.json", $params);
        return $this->extractData($rawResponse, 'customer');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/desk/api/v2/customers.json', $params);
        return $this->extractData($rawResponse, 'customers');
    }
}
