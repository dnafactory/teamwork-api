<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use Carbon\Carbon;
use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Timelog;
use DNAFactory\Teamwork\RawEndpoints\Desk\Inboxes as RawTimelogs;
use DNAFactory\Teamwork\Support\RequestBuilder;

class Timelogs extends DeskEndpoint
{
    const REF_TYPE_NAME = 'timelogs';
    const ARRAY_KEY_FOR_ENTRIES = 'timelogs';

    public function __construct(RawTimelogs $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    public function betweenDates(Carbon $startDate, Carbon $endDate): RequestBuilder
    {
        return $this->makeRequest()->filterBy([
            '$and' => [
                ['date' => ['$gt' => $startDate]],
                ['date' => ['$lt' => $endDate]]
            ]
        ]);
    }

    protected function makeOne(int $id): Timelog
    {
        return new Timelog($this, $id, ['id' => $id]);
    }
}
