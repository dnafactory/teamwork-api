<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\User;
use DNAFactory\Teamwork\RawEndpoints\Projects\People as RawPeople;

class People extends ProjectsEndpoint
{
    const REF_TYPE_NAME = 'user';

    public function __construct(RawPeople $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): User
    {
        return new User($this, $id);
    }
}
