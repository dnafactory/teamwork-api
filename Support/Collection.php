<?php

namespace DNAFactory\Teamwork\Support;

class Collection
{
    protected $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function toArray()
    {
        return $values;
    }

    public function indexById()
    {
        return $this->indexByPropriety('id');
    }

    public function indexByPropriety(string $field)
    {
        $data = [];
        foreach ($values as $value) {
            $key = $this->object_get($value, $field);
            if (is_null($key)) {
                continue;
            }
            $data[$key] = $value;
        }
        return $data;
    }

    public function groupBy(string $field)
    {
        $data = [];
        foreach ($values as $value) {
            $key = $this->object_get($value, $field);
            if (is_null($key)) {
                continue;
            }
            if (!isset($data[$key])) {
                $data[$key] = [];
            }
            $data[$key][] = $value;
        }
        return $data;
    }

    protected function object_get($object, string $path, $default = null)
    {
        $fields = explode('.', $path);
        foreach ($fields as $field) {
            $object = $object->$field ?? null;
            if (is_null($object)) {
                return $default;
            }
        }
        return $object;
    }
}