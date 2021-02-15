<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Timelogs extends ProjectsRawEndpoint
{
    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v3/time.json', $params);
        return $this->extractData($rawResponse, 'timelogs');
    }

    public function getManyByProjectId(int $id, array $params = [])
    {
        $rawResponse = $this->call("/v3/projects/$id/time.json", $params);
        return $this->extractData($rawResponse, 'timelogs');
    }
}
