<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Users extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/users/{$id}.json", $params);
        return $this->extractData($rawResponse, 'user');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/users.json', $params);
        return $this->extractData($rawResponse, 'users');
    }
}
