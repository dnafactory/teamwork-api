<?php

namespace DNAFactory\Teamwork\Models;

/**
 * @property-read int $id
 * @property-read string $firstName
 * @property-read string $lastName
 * @property-read string $email
 * @property-read string $organization
 * @property-read string $extraData
 * @property-read string $notes
 * @property-read int $numTickets
 * @property-read ?string $jobTitle
 * @property-read string $phone
 * @property-read string $mobile
 * @property-read string $address
 * @property-read string $avatarURL
 * @property-read bool $trusted
 * @property-read array $contacts
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 */
class Customer extends BaseModel
{
    /*
    protected function getContacts(): array
    {
        $references = $this->getRawAttribute('contacts', []);
        return $this->getManyReferences($references);
    }
    */
}
