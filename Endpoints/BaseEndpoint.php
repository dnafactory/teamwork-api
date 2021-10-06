<?php

namespace DNAFactory\Teamwork\Endpoints;

use DNAFactory\Teamwork\Exceptions\InvalidReferenceException;
use DNAFactory\Teamwork\Exceptions\ItemNotFoundException;
use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\Support\BaseRawEndpoint;
use DNAFactory\Teamwork\Support\RequestBuilder;

abstract class BaseEndpoint
{
    // string that identifies the type when other endpoints reference an entry
    const REF_TYPE_NAME = null;
    const REF_NAMESPACE = null;

    protected Router $router;
    protected BaseRawEndpoint $rawEndpoint;
    protected array $cache = [];
    protected array $instancesById = [];
    protected int $pageSize = 50;

    /**
     * BaseEndpoint constructor.
     * @param BaseRawEndpoint $rawEndpoint
     * @param Router $router
     * @throws \DNAFactory\Teamwork\Exceptions\EndpointAlreadyRegisteredException
     */
    public function __construct(BaseRawEndpoint $rawEndpoint, Router $router)
    {
        $this->rawEndpoint = $rawEndpoint;
        $this->router = $router;
        //$this->router->registerEndpoint($this);
    }

    public function getBaseUrl()
    {
        return $this->rawEndpoint->getBaseUrl();
    }

    public function setPageSize(int $pageSize): BaseEndpoint
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    public function flushCache(): BaseEndpoint
    {
        $this->cache = [];
        foreach ($this->instancesById as $instance) {
            /** @var BaseModel $instance */
            $instance->unload();
        }
        return $this;
    }

    public function getById(int $id)
    {
        if (!isset($this->instancesById[$id])) {
            $this->instancesById[$id] = $this->makeOne($id);
        }
        return $this->instancesById[$id];
    }

    public function makeRequest(): RequestBuilder
    {
        // use a factory
        return new RequestBuilder($this);
    }

    public function fetchAll()
    {
        return $this->makeRequest()->getResults();
    }

    public function loadRawEntries(array $entries)
    {
        foreach ($entries as $entry) {
            $id = (int)$entry['id'];
            $this->cache[$id] = $entry;
            if (isset($this->instancesById[$id])) {
                $this->instancesById[$id]->unload();
            }
        }
    }

    /**
     * @param array|null $reference
     * @return BaseModel|null
     * @throws InvalidReferenceException
     * @throws \DNAFactory\Teamwork\Exceptions\EndpointNotRegisteredException
     */
    public function retriveReference(?array $reference, ?string $namespace = null): ?BaseModel
    {
        $namespace ??= static::REF_NAMESPACE;
        $type = $reference['type'] ?? null;
        $id = $reference['id'] ?? null;
        if (is_null($type) || is_null($id)) {
            return null;
        }
        if ($type == static::REF_TYPE_NAME) {
            return $this->getById($id);
        }
        return $this->router->retriveReference($reference, $namespace);
    }

    public function getRawById(int $id)
    {
        $this->preload($id);
        if (!isset($this->cache[$id])) {
            throw new ItemNotFoundException("Item " . static::REF_TYPE_NAME . "<{$id}> was not found.");
        }
        return $this->cache[$id];
    }

    public function executeRequest(array $request)
    {
        $results = $this->executeRawRequest($request);
        foreach ($results as $result) {
            $id = $result['id'] ?? null;
            if (!isset($id)) {
                continue;
            }
            yield $id => $this->getById($id);
        }
    }

    protected function executeRawRequest(array $request)
    {
        [$skip, $limit, $params] = $this->requestParams($request);
        $unlimited = is_null($limit);
        $n = 0;
        $pageSize = 50;
        $hasMore = true;
        while ($hasMore && ($unlimited || $n < $limit)) {
            [$entries, $included, $page] = $this->rawEndpoint->getMany($params);
            $this->loadIncluded($included);
            $this->loadRawEntries($entries);
            $cutStart = $n > 0 ? 0 : $skip;
            $cutEnd = $unlimited ? $pageSize : $limit - $n;
            if ($cutStart != 0 || $cutEnd != $pageSize) {
                $entries = array_slice($entries, $cutStart, $cutEnd);
            }
            //yield from $entries;
            foreach ($entries as $entry) {
                yield $entry;
            }
            $n += count($entries);

            $params = $this->nextPage($page, $params);
            $hasMore = !is_null($params);
        }
    }

    protected function loadIncluded(array $rawData)
    {
        foreach ($rawData as $type => $entries) {
            $this->router->loadEntries($entries, $type, static::REF_NAMESPACE);
        }
    }

    protected function requestParams(array $request)
    {
        $skip = $request['startAt'] ?? 0;
        $limit = $request['endAt'] ?? null;
        $params = $request['params'] ?? [];
        $params['page'] = intdiv($skip, $this->pageSize) + 1;
        $skip %= $this->pageSize;
        return [$skip, $limit, $params];
    }

    protected function nextPage(array $pagination, array $params): ?array
    {
        $hasMore = $pagination['hasMore'] ?? false;
        if (!$hasMore) {
            return null;
        }
        $page = $params['page'] ?? 1;
        $params['page'] = $page + 1;
        return $params;
    }

    protected function preload(int $id)
    {
        if (isset($this->cache[$id])) {
            return;
        }
        [$rawEntries, $included, $page] = $this->rawEndpoint->getById($id, []);
        $this->loadRawEntries([$rawEntries]);
    }

    // use a factory
    protected abstract function makeOne(int $id): BaseModel;
}
