<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Tags extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $rawResponse = $this->call("/projects/api/v3/tags/{$id}.json", $params);
        return $this->extractData($rawResponse, 'tag');
    }

    public function getMany(array $params)
    {
        $rawResponse = $this->call('/projects/api/v3/tags.json', $params);
        return $this->extractData($rawResponse, 'tags');
    }
}
