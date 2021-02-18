<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Timelogs extends DeskRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/desk/api/v2/timelogs/{$id}.json", $params);
        return $this->extractData($rawResponse, 'timelog');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/desk/api/v2/timelogs.json', $params);
        return $this->extractData($rawResponse, 'timelogs');
    }
}
