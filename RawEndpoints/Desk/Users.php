<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\RawEndpoints\Proxy;

class Users extends Proxy
{
    public function getById(int $id, array $params = [])
    {
        return $this->jsonCall("/v2/users/{$id}.json", $params);
    }

    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v2/users.json', $params);
    }
}
