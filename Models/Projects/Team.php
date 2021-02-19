<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read string $name
 * @property-read string $description
 * @property-read User[] $members
 */
class Team extends BaseModel
{
    protected function getId(): int
    {
        $rawId = $this->getRawAttribute('id');
        return (int)$rawId;
    }

    protected function getMembers(): array
    {
        $references = $this->getRawAttribute('members', []);
        return $this->retriveManyReferences($references);
    }
}
