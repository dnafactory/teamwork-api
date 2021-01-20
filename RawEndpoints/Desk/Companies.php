<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\RawEndpoints\Proxy;

class Companies extends Proxy
{
    public function getById(int $id, array $params = [])
    {
        return $this->jsonCall("/v2/companies/{$id}.json", $params);
    }

    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v2/companies.json', $params);
    }
}
