<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Tickets extends DeskRawEndpoint
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

    public function putById(int $id, array $payload)
    {
        return $this->call("/../v1/tickets/$id.json", $payload, 'PUT', self::ENCODING_JSON);
    }
}
