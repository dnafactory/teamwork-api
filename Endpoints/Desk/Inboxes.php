<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Inbox;
use DNAFactory\Teamwork\RawEndpoints\Desk\Inboxes as RawInboxes;

class Inboxes extends DeskEndpoint
{
    const REF_TYPE_NAME = 'inboxes';

    public function __construct(RawInboxes $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): Inbox
    {
        return new Inbox($this, $id, ['id' => $id]);
    }
}
