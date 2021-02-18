<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Inboxes extends DeskRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/desk/api/v2/inboxes/{$id}.json", $params);
        return $this->extractData($rawResponse, 'inbox');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/desk/api/v2/inboxes.json', $params);
        return $this->extractData($rawResponse, 'inboxes');
    }
}
