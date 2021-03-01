<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\CustomField;
use DNAFactory\Teamwork\RawEndpoints\Desk\CustomFields as RawCustomFields;

class CustomFields extends DeskEndpoint
{
    const REF_TYPE_NAME = 'customfields';

    public function __construct(RawCustomFields $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): CustomField
    {
        return new CustomField($this, $id);
    }
}