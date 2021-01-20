<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\RawEndpoints\Proxy;

class Contacts extends Proxy
{
    public function getById(int $id, array $params = [])
    {
        return $this->jsonCall("/v2/contacts/{$id}.json", $params);
    }

    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v2/contacts.json', $params);
    }
}
