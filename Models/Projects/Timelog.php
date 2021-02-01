<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\Models\User;

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
 * @property-read int $userId
 */
class Timelog extends BaseModel
{
    public function getSeconds(): int
    {
        return $this->minutes * 60;
    }

}