<?php

namespace DNAFactory\Teamwork\Models;

/**
 * @property-read int $id
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 * @property-read string $name
 * @property-read int $displayOrder
 * @property-read string $email
 * @property-read string $iconImage
 * @property-read string $forwardingAddress
 * @property-read array $users
 */

class Inbox extends BaseModel
{
/*
    protected function getTicketStatus(): ?BaseModel
    {
        $reference = $this->getRawAttribute('ticketstatus');
        return $this->endpoint->retriveReference($reference);
    }
*/
    protected function getUsers(): array
    {
        $references = $this->getRawAttribute('users', []);
        return $this->retriveManyReferences($references);
    }
}
