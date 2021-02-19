<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class People extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $rawResponse = $this->call("/people/{$id}.json", $params);
        return $this->extractData($rawResponse, 'person');
    }

    public function getMany(array $params)
    {
        $rawResponse = $this->call('/people.json', $params);
        return $this->extractData($rawResponse, 'people');
    }
}
