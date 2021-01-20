<?php

namespace DNAFactory\Teamwork\Endpoints;

use DNAFactory\Teamwork\Exceptions\InvalidReferenceException;
use DNAFactory\Teamwork\Factories\BaseFactory;
use DNAFactory\Teamwork\RawEndpoints\Proxy;
use DNAFactory\Teamwork\Support\RequestBuilder;
use DNAFactory\Teamwork\Support\RequestBuilderFactory;

abstract class BaseEndpoint
{
    const TYPE_NAME = null;

    protected Router $router;
    protected Proxy $rawEndpoint;
    protected RequestBuilderFactory $requestBuilderFactory;
    protected array $cache = [];
    protected array $instancesById = [];

    /**
     * BaseEndpoint constructor.
     * @param Proxy $rawEndpoint
     * @param Router $router
     * @throws \DNAFactory\Teamwork\Exceptions\EndpointAlreadyRegisteredException
     */
    public function __construct(Proxy $rawEndpoint, Router $router)
    {
        $this->rawEndpoint = $rawEndpoint;
        $this->router = $router;
        $this->router->registerEndpoint($this);
    }

    public function getById(int $id)
    {
        if (!isset($this->instancesById[$id])) {
            $this->instancesById[$id] = $this->makeOne($id);
        }
        return $this->instancesById[$id];
    }

    public function all()
    {
        return new RequestBuilder($this);
    }

    public function loadRawEntries(array $entries)
    {
        foreach ($entries as $entry) {
            $id = $entry['id'];
            $this->cache[$id] = $entry;
        }
    }

    public function retriveReference(array $reference)
    {
        $type = $reference['type'] ?? null;
        if ($type == static::TYPE_NAME) {
            return $this->getByReference($reference);
        }
        return $this->router->retriveReference($reference);
    }

    public function getRawById($id)
    {
        if (!isset($this->cache[$id])) {
            $this->cache[$id] = $this->rawEndpoint->getById($id);
        }
        return $this->cache[$id];
    }

    public function executeRequest(array $request): array
    {
        $pageSize = 50;
        $pageNumber = 20; // it will be overwritten
        for ($page = 0; $page < $pageNumber && !$hasMore; $i++) {
            $rawData = $this->rawEndpoint->$method();
            $pagination = $rawData['meta']['page'] ?? [];
            $pageNumber = $pagination['count'] ?? 0;
            $hasMore = $pagination['hasMore'] ?? false;
        }
    }

    protected function executeRequest2(string $method, array $params)
    {
        $rawData = $this->rawEndpoint->();
    }

    protected function extractIncluded(array $rawData)
    {
        $included = $rawData['included'] ?? [];
        foreach ($included as $type => $entries) {
            $this->router->loadEntries($type, $entries);
        }
    }

    protected function getByReference($reference)
    {
        $id = $reference['id'] ?? null;
        if (!isset($id)) {
            throw new InvalidReferenceException();
        }
        return $this->getById($id);
    }

    public function preload(?array $ids)
    {
        $wanted = $ids ?? array_keys($this->instancesById);
        $cached = array_keys($this->cache);
        $missing = array_diff($wanted, $cached);

        $this->all()
            ->filterBy('id', 'in', $missing)
            ->toArray();
    }

    protected abstract function makeOne(int $id);
}