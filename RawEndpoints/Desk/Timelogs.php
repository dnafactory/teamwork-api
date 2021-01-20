<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\RawEndpoints\Proxy;

class Timelogs extends Proxy
{
    public function getById(int $id, array $params = [])
    {
        return $this->jsonCall("/v2/timelogs/{$id}.json", $params);
    }

    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v2/timelogs.json', $params);
    }
}
