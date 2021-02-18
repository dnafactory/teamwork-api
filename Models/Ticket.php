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
 * @property-read string $subject
 * @property-read string $previewText
 * @property-read string $originalRecipient
 * @property-read int $responseTimeMins
 * @property-read ?int $resolutionTimeMins
 * @property-read bool $imagesHidden
 * @property-read bool $isRead
 * @property-read Customer $customer
 * @property-read Inbox $inbox
 * @property-read User $agent
 * @property-read array $messages
 * @property-read array $timelogs
 * @property-read array $mentions
 * @property-read array $followers
 * @property-read \Carbon\Carbon $expiration
 */
class Ticket extends BaseModel
{
    protected function getCustomer(): ?Customer
    {
        $reference = $this->getRawAttribute('customer');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getInbox(): ?Inbox
    {
        $reference = $this->getRawAttribute('inbox');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getAgent(): ?User
    {
        $reference = $this->getRawAttribute('agent');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getExpiration(): ?Carbon
    {
        $rawValue = $this->extractRawCustomField(63, []);
        $rawValue = $rawValue['textValue'][0] ?? null;
        return $this->convertDate($rawValue ?: null);
    }

    /*
    protected function getContact(): ?BaseModel
    {
        $reference = $this->getRawAttribute('contact');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getType(): ?BaseModel
    {
        $reference = $this->getRawAttribute('type');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getStatus(): ?BaseModel
    {
        $reference = $this->getRawAttribute('status');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getMessages(): array
    {
        $references = $this->getRawAttribute('messages', []);
        return $this->retriveManyReferences($references);
    }
    */

    protected function getTimelogs(): array
    {
        $references = $this->getRawAttribute('timelogs', []);
        return $this->retriveManyReferences($references);
    }

    protected function getMentions(): array
    {
        $references = $this->getRawAttribute('mentions', []);
        return $this->retriveManyReferences($references);
    }

    protected function getFollowers(): array
    {
        $references = $this->getRawAttribute('followers', []);
        return $this->retriveManyReferences($references);
    }

    public function getLink()
    {
        return sprintf('%s/desk/tickets/%d/messages', $this->endpoint->getBaseUrl(), $this->id);
    }
}
