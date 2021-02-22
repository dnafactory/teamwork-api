<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\Company;
use DNAFactory\Teamwork\RawEndpoints\Projects\Companies as RawCompanies;

class Companies extends ProjectsEndpoint
{
    public const REF_TYPE_NAME = 'companies';

    public function __construct(RawCompanies $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Company
    {
        return new Company($this, $id, ['id' => $id]);
    }
}
