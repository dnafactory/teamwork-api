<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;
use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Ticket;
use DNAFactory\Teamwork\RawEndpoints\Desk\Tickets as RawTickets;

class Tickets extends BaseEndpoint
{
    const REF_TYPE_NAME = 'tickets';
    const ARRAY_PATH_FOR_ENTRIES = [
        'getById' => 'ticket',
        'getAll' => 'tickets'
    ];

    public function __construct(RawTickets $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Ticket
    {
        return new Ticket($this, $id, ['id' => $id]);
    }
}
