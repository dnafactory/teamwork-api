<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\Task;
use DNAFactory\Teamwork\RawEndpoints\Projects\Tasks as RawTasks;

class Tasks extends ProjectsEndpoint
{
    const REF_TYPE_NAME = 'tasks';

    public function __construct(RawTasks $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Task
    {
        return new Task($this, $id, ['id' => $id]);
    }
}
