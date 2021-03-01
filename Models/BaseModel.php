<?php

namespace DNAFactory\Teamwork\Models;

use Carbon\Carbon;
use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

abstract class BaseModel
{
    protected BaseEndpoint $endpoint;
    protected int $id;
    protected array $rawData;
    protected bool $loaded;
    protected array $customFields;

    public function __construct(BaseEndpoint $endpoint, int $id)
    {
        $this->endpoint = $endpoint;
        $this->id = $id;
        $this->rawData = [];
        $this->loaded = false;
        $this->customFields = [];
    }

    public function __get($name)
    {
        if (isset($this->customFields[$name])) {
            return $this->extractCustomField($name);
        }
        $getter = 'get' . ucfirst($name);
        if (in_array($getter, get_class_methods($this))) {
            return $this->$getter();
        }
        return $this->getRawAttribute($name);
    }

    public function unload()
    {
        $this->rawData = ['id' => $this->id];
        $this->loaded = false;
    }
    
    public function getEndpoint(): BaseEndpoint
    {
        return $this->endpoint;
    }

    protected function getId()
    {
        return $this->id;
    }

    public function getRawData(): array
    {
        if (!$this->loaded) {
            $this->rawData = $this->endpoint->getRawById($this->id);
            $this->loaded = true;
        }
        return $this->rawData;
    }

    public function getRawAttribute($name, $default = null)
    {
        $rawData = $this->getRawData();
        return $rawData[$name] ?? $default;
    }

    public function extractRawCustomField(int $id, $default = null): ?array
    {
        $rawCustomfields = $this->getRawAttribute('customfields');
        foreach ($rawCustomfields as $rawCustomfield) {
            if (!isset($rawCustomfield['meta']) || $rawCustomfield['id'] != $id) {
                continue;
            }
            return $rawCustomfield['meta'] ?? $default;
        }
        return $default;
    }

    public function extractCustomField(string $name, $default = null)
    {
        $id = $this->customFields[$name] ?? null;
        if (!isset($id)) {
            return $default;
        }
        $rawValue = $this->extractRawCustomField($id);
        $definition = $this->endpoint->retriveReference(['id' => $id, 'type' => 'customfields']);
        return $definition->convert($rawValue);
    }

    protected function retriveManyReferences(array $references, ?string $namespace = null)
    {
        $data = [];
        foreach ($references as $reference) {
            $cur = $this->endpoint->retriveReference($reference);
            if (is_null($cur)) {
                continue;
            }
            $data[] = $cur;
        }
        return $data;
    }

    protected function convertDate(?string $date): ?Carbon
    {
        return is_null($date) ? null : Carbon::parse($date);
    }

    // common getters
    protected function getCreatedAt(): ?Carbon
    {
        return $this->convertDate($this->getRawAttribute('createdAt'));
    }

    protected function getCreatedBy(): ?BaseModel
    {
        $reference = $this->getRawAttribute('createdBy');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getUpdatedAt(): ?Carbon
    {
        return $this->convertDate($this->getRawAttribute('updatedAt'));
    }

    protected function getUpdatedBy(): ?BaseModel
    {
        $reference = $this->getRawAttribute('updatedBy');
        return $this->endpoint->retriveReference($reference);
    }

}
