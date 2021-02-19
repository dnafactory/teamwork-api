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
        if (isset($this->endpoints[$type])) {
            throw new EndpointAlreadyRegisteredException("endpoint of type '$type' already registered");
        }
        $this->endpoints[$type] = $endpoint;
    }

    /**
     * @param array $reference
     * @return BaseModel
     * @throws EndpointNotRegisteredException
     */
    public function retriveReference(array $reference): BaseModel
    {
        $type = $reference['type'] ?? null;
        $endpoint = $this->getEndpointByType($type);
        return $endpoint->retriveReference($reference);
    }

    /**
     * @param string $type
     * @param array $entries
     * @throws EndpointNotRegisteredException
     */
    public function loadEntries(string $type, array $entries)
    {
        /** @var BaseEndpoint $endpoint */
        $endpoint = $this->getEndpointByType($type);
        $endpoint->loadRawEntries($entries);
    }

    /**
     * @param string|null $type
     * @return mixed
     * @throws EndpointNotRegisteredException
     */
    public function getEndpointByType(string $type): ?BaseEndpoint
    {
        $endpoint = $this->endpoints[$type] ?? null;
        if (!isset($endpoint)) {
            throw new EndpointNotRegisteredException("endpoint for type '$type' not registered");
        }
        return $endpoint;
    }
}
