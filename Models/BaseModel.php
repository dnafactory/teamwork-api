<?php

namespace DNAFactory\Teamwork\Models;

use Carbon\Carbon;
use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

abstract class BaseModel
{
    protected BaseEndpoint $endpoint;
    protected $id;
    protected array $rawData;
    protected bool $loaded;
    protected array $customFields;

    public function __construct(BaseEndpoint $endpoint, $id, array $rawData = [], bool $loaded = false)
    {
        $this->endpoint = $endpoint;
        $this->id = $id;
        $this->rawData = $rawData;
        $this->loaded = $loaded;
        $this->customFields = [];
    }

    public function __get($name)
    {
        if(isset($this->customFields[$name])){
            return $this->extractCustomField($name);
        }
        $getter = 'get' . ucfirst($name);
        if (in_array($getter, get_class_methods($this))) {
            return $this->$getter();
        }
        return $this->getRawAttribute($name);
    }

    public function getRawAttribute($name, $default = null)
    {
        if (!isset($this->rawData[$name]) && !$this->loaded) {
            $this->rawData = $this->endpoint->getRawById($this->id);
            $this->loaded = true;
        }
        return $this->rawData[$name] ?? $default;
    }

    protected function extractRawCustomField(int $id, $default = null): ?string
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

    protected function retriveManyReferences(array $references)
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

    // common getters
    protected function getCreatedAt(): ?Carbon
    {
        $value = $this->getRawAttribute('createdAt');
        return is_null($value) ? null : Carbon::parse($value);
    }

    protected function getCreatedBy(): ?BaseModel
    {
        $reference = $this->getRawAttribute('createdBy');
        return $this->endpoint->retriveReference($reference);
    }

    protected function getUpdatedAt(): ?Carbon
    {
        $value = $this->getRawAttribute('updatedAt');
        return is_null($value) ? null : Carbon::parse($value);
    }

    protected function getUpdatedBy(): ?BaseModel
    {
        $reference = $this->getRawAttribute('updatedBy');
        return $this->endpoint->retriveReference($reference);
    }

}
