<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $logoURL
 *
 */
class Company extends BaseModel
{
    protected function getId(): int
    {
        $rawId = $this->getRawAttribute('id');
        return (int)$rawId;
    }

    protected function getLogoURL(): int
    {
        return $this->getRawAttribute('logo-URL');
    }
}
