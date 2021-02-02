<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Users extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        return $this->call("/v2/users/{$id}.json", $params);
    }

    public function getMany(array $params = [])
    {
        return $this->call('/v2/users.json', $params);
    }
}
