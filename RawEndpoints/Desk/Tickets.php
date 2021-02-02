<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Tickets extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        return $this->call("/v2/tickets/{$id}.json", $params);
    }

    public function getMany(array $params = [])
    {
        return $this->call('/v2/tickets.json', $params);
    }
}
