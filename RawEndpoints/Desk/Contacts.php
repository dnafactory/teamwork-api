<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Contacts extends DeskRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/desk/api/v2/contacts/{$id}.json", $params);
        return $this->extractData($rawResponse, 'contact');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/desk/api/v2/contacts.json', $params);
        return $this->extractData($rawResponse, 'contacts');
    }
}
