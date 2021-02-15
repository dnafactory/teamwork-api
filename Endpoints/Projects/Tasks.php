<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Models\Projects\Task;

class Tasks extends ProjectsEndpoint
{

    protected function makeOne(int $id): Task
    {
        return new Task($this, $id, ['id' => $id]);
    }
}
