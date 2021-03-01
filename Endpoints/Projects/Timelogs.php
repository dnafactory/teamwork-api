<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use Carbon\Carbon;
use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Projects\Timelog;
use DNAFactory\Teamwork\RawEndpoints\Projects\Timelogs as RawTimelogs;
use DNAFactory\Teamwork\Support\RequestBuilder;

class Timelogs extends ProjectsEndpoint
{
    const REF_TYPE_NAME = 'timelogs';

    public function __construct(RawTimelogs $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    public function betweenDates(Carbon $startDate, Carbon $endDate): RequestBuilder
    {
        return $this->makeRequest()
            ->filterBy([
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ]);
    }

    protected function makeOne(int $id): Timelog
    {
        return new Timelog($this, $id);
    }
}
