<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class TodoLists extends ProjectsRawEndpoint
{
    public function getById(int $id, array $params)
    {
        $rawResponse = $this->call("/tasklists/{$id}.json", $params);
        return $this->extractData($rawResponse, 'todo-list');
    }

    public function getMany(array $params)
    {
        $rawResponse = $this->call('/tasklists.json', $params);
        return $this->extractData($rawResponse, 'tasklists');
    }
}
