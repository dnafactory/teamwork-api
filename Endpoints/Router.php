<?php

namespace DNAFactory\Teamwork\Endpoints;

use DNAFactory\Teamwork\Exceptions\EndpointAlreadyRegisteredException;
use DNAFactory\Teamwork\Exceptions\EndpointNotRegisteredException;
use DNAFactory\Teamwork\Models\BaseModel;

class Router
{
    protected array $endpoints;

    public function __construct()
    {
        $this->endpoints = [];
    }

    /**
     * @param BaseEndpoint $endpoint
     * @throws EndpointAlreadyRegisteredException
     */
    public function registerEndpoint(BaseEndpoint $endpoint)
    {
        $type = $endpoint::REF_TYPE_NAME;
        $namespace = $endpoint::REF_NAMESPACE;
        if (isset($this->endpoints[$namespace][$type])) {
            throw new EndpointAlreadyRegisteredException("endpoint '{$namespace}.{$type}' already registered");
        }
        $this->endpoints[$namespace] ??= [];
        $this->endpoints[$namespace][$type] = $endpoint;
    }

    /**
     * @param array $reference
     * @return BaseModel
     * @throws EndpointNotRegisteredException
     */
    public function retriveReference(array $reference, string $namespace): BaseModel
    {
        $type = $reference['type'] ?? null;
        $endpoint = $this->getEndpoint($type, $namespace);
        return $endpoint->retriveReference($reference);
    }

    /**
     * @param string $type
     * @param array $entries
     * @throws EndpointNotRegisteredException
     */
    public function loadEntries(array $entries, string $type, string $namespace)
    {
        /** @var BaseEndpoint $endpoint */
        $endpoint = $this->getEndpoint($type, $namespace);
        $endpoint->loadRawEntries($entries);
    }

    /**
     * @param string|null $type
     * @return mixed
     * @throws EndpointNotRegisteredException
     */
    public function getEndpoint(string $type, string $namespace): ?BaseEndpoint
    {
        $endpoint = $this->endpoints[$namespace][$type] ?? null;
        if (!isset($endpoint)) {
            throw new EndpointNotRegisteredException("endpoint for '{$namespace}.{$type}' not registered");
        }
        return $endpoint;
    }

    public function flushAllCaches()
    {
        foreach ($this->endpoints as $groupedEndpoints) {
            foreach ($groupedEndpoints as $endpoint) {
                /** @var BaseEndpoint $endpoint */
                $endpoint->flushCache();
            }
        }
    }
}
