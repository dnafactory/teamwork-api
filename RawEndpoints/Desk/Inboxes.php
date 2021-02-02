<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Inboxes extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/inboxes/{$id}.json", $params);
        return $this->extractData($rawResponse, 'inbox');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/inboxes.json', $params);
        return $this->extractData($rawResponse, 'inboxes');
    }
}
