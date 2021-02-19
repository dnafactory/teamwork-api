<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Timelogs extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params = [])
    {
        $rawResponse = $this->call("/time_entries/{$id}.json", $params);
        return $this->extractData($rawResponse, 'time-entry');
    }

    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/projects/api/v3/time.json', $params);
        return $this->extractData($rawResponse, 'timelogs');
    }

    public function getManyByProjectId(int $id, array $params = [])
    {
        $rawResponse = $this->call("/projects/api/v3/projects/$id/time.json", $params);
        return $this->extractData($rawResponse, 'timelogs');
    }
}
