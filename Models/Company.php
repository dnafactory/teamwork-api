<?php

namespace DNAFactory\Teamwork\Models;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $email
 * @property-read string $details
 * @property-read string $industry
 * @property-read string $website
 * @property-read string $avatarPath
 * @property-read string $permission
 * @property-read string $kind
 * @property-read array $customers
 * @property-read array $domains
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 */
class Company extends BaseModel
{
    protected function getCustomers(): array
    {
        $references = $this->getRawAttribute('customers', []);
        return $this->retriveManyReferences($references);
    }

    protected function getDomains(): array
    {
        $references = $this->getRawAttribute('domains', []);
        return $this->retriveManyReferences($references);
    }
}
