<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\Proxy;

class Tickets extends Proxy
{
    public function getById(int $id, array $params = [])
    {
        return $this->jsonCall("/v2/tickets/{$id}.json", $params);
    }

    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v2/tickets.json', $params);
    }
}