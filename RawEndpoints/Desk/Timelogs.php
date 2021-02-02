<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Timelogs extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/timelogs/{$id}.json", $params);
        return $this->extractData($rawResponse, 'timelog');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/timelogs.json', $params);
        return $this->extractData($rawResponse, 'timelogs');
    }
}
