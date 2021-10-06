<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\Message;
use DNAFactory\Teamwork\RawEndpoints\Desk\Messages as RawMessages;

class Messages extends DeskEndpoint
{
    const REF_TYPE_NAME = 'messages';

    public function __construct(RawMessages $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    public function loadRawEntries(array $entries)
    {
        parent::loadRawEntries($entries);
    }

    protected function makeOne(int $id): Message
    {
        return new Message($this, $id);
    }
}
