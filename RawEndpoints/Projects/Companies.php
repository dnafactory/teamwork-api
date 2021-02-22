<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Companies extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $rawResponse = $this->call("/companies/{$id}.json", $params);
        return $this->extractData($rawResponse, 'company');
    }

    public function getMany(array $params)
    {
        $rawResponse = $this->call('/companies.json', $params);
        return $this->extractData($rawResponse, 'companies');
    }
}
