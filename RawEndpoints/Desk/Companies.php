<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Companies extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/companies/{$id}.json", $params);
        return $this->extractData($rawResponse, 'company');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/companies.json', $params);
        return $this->extractData($rawResponse, 'companies');
    }
}
