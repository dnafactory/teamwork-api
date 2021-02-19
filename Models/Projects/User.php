<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read string $email
 * @property-read string $firstName
 * @property-read string $lastName
 * @property-read string $fullName
 * @property-read string $avatarUrl
 */
class User extends BaseModel
{
    protected function getId(): int
    {
        $rawId = $this->getRawAttribute('id');
        return (int)$rawId;
    }

    protected function getFirstName(): string
    {
        return $this->getRawAttribute('first-name');
    }

    protected function getLastName(): string
    {
        return $this->getRawAttribute('last-name');
    }

    protected function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    protected function getAvatarUrl(): string
    {
        return $this->getRawAttribute('avatar-url');
    }

    protected function getEmail(): string
    {
        return $this->getRawAttribute('email-address');
    }
}
