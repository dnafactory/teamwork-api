<?php

namespace DNAFactory\Teamwork\Models;

/**
 * @property-read int $id
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 * @property-read string $htmlBody
 * @property-read string $textBody
 * @property-read string $editMethod
 * @property-read string $emailMessageId
 * @property-read string $s3link
 * @property-read string $state
 * @property-read bool $delayed
 * @property-read \Carbon\Carbon $viewedByCustomerAt
 * @property-read Ticket $ticket
 * @property-read array $status
 * @property-read bool $isPinned
 */
class Message extends BaseModel
{
    protected function getViewedByCustomerAt(): ?Carbon
    {
        return $this->convertDate($this->getRawAttribute('viewedByCustomerAt'));
    }

    protected function getTicket(): ?Ticket
    {
        $reference = $this->getRawAttribute('tickets_id');
        return $this->endpoint->retriveReference($reference);
    }
}
