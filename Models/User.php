<?php

namespace DNAFactory\Teamwork\Models;

/**
 * @property-read int $id
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 * @property-read string $email
 * @property-read string $firstName
 * @property-read string $lastName
 * @property-read string $fullName
 * @property-read string $avatarUrl
 * @property-read string $role
 */
class User extends BaseModel
{
    protected function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
