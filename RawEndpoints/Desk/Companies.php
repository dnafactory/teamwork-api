<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

class Companies extends DeskRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/desk/api/v2/companies/{$id}.json", $params);
        return $this->extractData($rawResponse, 'company');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/desk/api/v2/companies.json', $params);
        return $this->extractData($rawResponse, 'companies');
    }
}
