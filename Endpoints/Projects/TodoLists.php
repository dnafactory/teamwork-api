<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\TodoList;
use DNAFactory\Teamwork\RawEndpoints\Projects\TodoLists as RawTodoLists;

class TodoLists extends ProjectsEndpoint
{
    const REF_TYPE_NAME = 'tasklists';

    public function __construct(RawTodoLists $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): TodoList
    {
        return new TodoList($this, $id, ['id' => $id]);
    }
}
