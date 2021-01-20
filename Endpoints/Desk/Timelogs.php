<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;
use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Timelog;
use DNAFactory\Teamwork\RawEndpoints\Desk\Inboxes as RawTimelogs;

class Timelogs extends BaseEndpoint
{
    const REF_TYPE_NAME = 'timelogs';
    const ARRAY_PATH_FOR_ENTRIES = [
        'getById' => 'timelog',
        'getAll' => 'timelogs'
    ];

    public function __construct(RawTimelogs $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Timelog
    {
        return new Timelog($this, $id, ['id' => $id]);
    }
}
