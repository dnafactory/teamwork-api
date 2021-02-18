<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

class Tasks extends ProjectsRawEndpoint
{
    public function getMany(array $params)
    {
        $rawResponse = $this->call('/v1/tasks.json', $params);
        return $this->extractData($rawResponse, 'todo-items');
    }

    protected function extractData(array $rawResponse, string $keyForData)
    {
        [$rawData, $included, $page] = parent::extractData($rawResponse, $keyForData);
        $page = ['hasMore' => count($rawData) > 0];
        return  [$rawData, $included, $page];
    }
}
