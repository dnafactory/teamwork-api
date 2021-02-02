<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Inboxes extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        return $this->call("/v2/inboxes/{$id}.json", $params);
    }

    public function getMany(array $params = [])
    {
        return $this->call('/v2/inboxes.json', $params);
    }
}
