<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\Tag;
use DNAFactory\Teamwork\RawEndpoints\Projects\Tags as RawTags;

class Tags extends ProjectsEndpoint
{
    const REF_TYPE_NAME = 'tags';

    public function __construct(RawTags $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Tag
    {
        return new Tag($this, $id);
    }
}
