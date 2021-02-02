<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Contacts extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        return $this->call("/v2/contacts/{$id}.json", $params);
    }

    public function getMany(array $params = [])
    {
        return $this->call('/v2/contacts.json', $params);
    }
}
