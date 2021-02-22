<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Endpoints\Projects\People;
use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $createdAt
 * @property-read User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read User $updatedBy
 * @property-read bool $billable
 * @property-read string $description
 * @property-read int $minutes
 * @property-read int $seconds
 * @property-read \Carbon\Carbon $timeLogged
 * @property-read User $user
 */
class Timelog extends BaseModel
{
    protected function getSeconds(): int
    {
        return $this->minutes * 60;
    }

    protected function getUser(): User
    {
        $reference = ['id' => $this->userId, 'type' => 'user'];
        return $this->endpoint->retriveReference($reference);
    }

}
