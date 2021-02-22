<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Projects extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $rawResponse = $this->call("/projects/api/v3/projects/{$id}.json", $params);
        return $this->extractData($rawResponse, 'project');
    }

    public function getMany(array $params)
    {
        $rawResponse = $this->call('/projects/api/v3/projects.json', $params);
        return $this->extractData($rawResponse, 'projects');
    }
}
