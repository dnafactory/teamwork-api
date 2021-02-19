<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Teams extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $rawResponse = $this->call("/teams/{$id}.json", $params);
        return $this->extractData($rawResponse, 'team');
    }

    public function getMany(array $params)
    {
        $rawResponse = $this->call('/teams.json', $params);
        return $this->extractData($rawResponse, 'teams');
    }
}
