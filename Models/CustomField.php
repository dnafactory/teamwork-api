<?php

namespace DNAFactory\Teamwork\Models;

/**
 * @property-read int $id
 * @property-read string $agentLabel
 * @property-read null|string $customerLabel
 * @property-read string $email
 * @property-read string $kind
 * @property-read string $state
 * @property-read \Carbon\Carbon $createdAt
 * @property-read Customer|User $createdBy
 * @property-read \Carbon\Carbon $updatedAt
 * @property-read Customer|User $updatedBy
 */
class CustomField extends BaseModel
{
    public function convert(array $data)
    {
        $kind = $this->kind;
        switch ($kind) {
            case 'date':
                return $this->convertDate($data['meta']['textValue'] ?? null);
            default:
                return $data['meta']['textValue'] ?? null;
        }
    }
}