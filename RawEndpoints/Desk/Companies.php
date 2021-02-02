<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Companies extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        return $this->call("/v2/companies/{$id}.json", $params);
    }

    public function getMany(array $params = [])
    {
        return $this->call('/v2/companies.json', $params);
    }
}
