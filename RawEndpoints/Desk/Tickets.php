<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Tickets extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/tickets/{$id}.json", $params);
        return $this->extractData($rawResponse, 'ticket');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/tickets.json', $params);
        return $this->extractData($rawResponse, 'tickets');
    }
}
