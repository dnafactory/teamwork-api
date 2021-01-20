<?php

namespace DNAFactory\Teamwork\Support;

class CacheManager
{
    protected $cache;

    public function __construct()
    {
        $this->flushAll();
    }

    public function flush(string $name)
    {
        $this->cache[$name] = [];
    }

    public function flushAll()
    {
        $this->cache = [];
    }

    public function loadRawEntries($entries)
    {
        if (!isset($this->cache[$name])) {
            $this->cache[$name] = [];
        }
        foreach ($entries as $entry) {
            $id = $entry['id'];
            $this->cache[$name][$id] = $entry;
        }
    }

    public function getEntry($name, $id)
    {
        return $this->cache[$name][$id] ?? null;
    }
}