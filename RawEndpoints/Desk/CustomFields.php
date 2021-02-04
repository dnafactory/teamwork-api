<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class CustomFields extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/customfields/{$id}.json", $params);
        return $this->extractData($rawResponse, 'customfield');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/customfields.json', $params);
        return $this->extractData($rawResponse, 'customfields');
    }
}
