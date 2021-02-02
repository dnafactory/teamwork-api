<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Contacts extends BaseRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v2/contacts/{$id}.json", $params);
        return $this->extractData($rawResponse, 'contact');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v2/contacts.json', $params);
        return $this->extractData($rawResponse, 'contacts');
    }
}
