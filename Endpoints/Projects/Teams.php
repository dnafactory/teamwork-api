<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\Team;
use DNAFactory\Teamwork\RawEndpoints\Projects\Teams as RawTeams;

class Teams extends ProjectsEndpoint
{
    const REF_TYPE_NAME = 'team';

    public function __construct(RawTeams $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Team
    {
        return new Team($this, $id, ['id' => $id]);
    }
}
