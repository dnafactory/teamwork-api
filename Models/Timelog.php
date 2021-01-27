<?php

namespace DNAFactory\Teamwork\Models;

use Carbon\Carbon;

/**
 * @property-read int $id
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 * @property-read bool $billable
 * @property-read Carbon $date
 * @property-read int $seconds
 * @property-read int $timezoneOffset
 * @property-read Ticket $ticket
 * @property-read User $user
 */
class Timelog extends BaseModel
{
    protected function getDate(): ?Carbon
    {
        return $this->convertDate($this->getRawAttribute('date'));
    }

    protected function getTicket(): ?BaseModel
    {
        $reference = $this->getRawAttribute('ticket');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getUser(): ?BaseModel
    {
        $reference = $this->getRawAttribute('user');
        return $this->endpoint->retriveReference($reference);
    }

}
