<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\Project;
use DNAFactory\Teamwork\RawEndpoints\Projects\Projects as RawProjects;

class Projects extends ProjectsEndpoint
{
    public const REF_TYPE_NAME = 'projects';

    public function __construct(RawProjects $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Project
    {
        return new Project($this, $id, ['id' => $id]);
    }
}
