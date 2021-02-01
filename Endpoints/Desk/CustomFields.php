<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\Models\CustomField;

class CustomFields extends DeskEndpoint
{
    const REF_TYPE_NAME = 'customfields';
    const ARRAY_KEY_FOR_ENTRIES = 'customfields';

    protected function makeOne(int $id): BaseModel
    {
        return new CustomField($this, $id, ['id' => $id]);
    }
}