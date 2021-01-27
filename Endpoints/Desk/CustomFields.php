<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\Models\CustomField;

class CustomFields extends \DNAFactory\Teamwork\Endpoints\BaseEndpoint
{
    const REF_TYPE_NAME = 'customfields';
    const ARRAY_PATH_FOR_ENTRIES = [
        'getById' => 'customfield',
        'getAll' => 'customfields'
    ];

    protected function makeOne(int $id): BaseModel
    {
        return new CustomField($this, $id, ['id' => $id]);
    }
}