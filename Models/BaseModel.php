<?php

namespace DNAFactory\Teamwork\Models;

use Carbon\Carbon;
use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

abstract class BaseModel
{
    private BaseEndpoint $endpoint;
    protected $id;
    protected array $rawData;
    protected bool $loaded;

    public function __construct(BaseEndpoint $endpoint, $id, array $rawData = [], bool $loaded = false)
    {
        $this->endpoint = $endpoint;
        $this->id = $id;
        $this->rawData = $rawData;
        $this->loaded = $loaded;
    }

    public function __get($name)
    {
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

    protected function getManyReferences(array $references)
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
        $value = $this->getRawAttribute('updatedBy');
        return $this->endpoint->retriveReference($reference);
    }

}