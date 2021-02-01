<?php

namespace DNAFactory\Teamwork\Endpoints;

use DNAFactory\Teamwork\Exceptions\InvalidReferenceException;
use DNAFactory\Teamwork\Exceptions\NoDataExtractedException;
use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\RawEndpoints\Proxy;
use DNAFactory\Teamwork\Support\RequestBuilder;

abstract class BaseEndpoint
{
    // string that identifies the type when other endpoints reference an entry
    const REF_TYPE_NAME = null;

    // array key containing the results for current endpoint
    const ARRAY_KEY_FOR_ENTRIES = null;

    protected Router $router;
    protected Proxy $rawEndpoint;
    protected array $cache = [];
    protected array $instancesById = [];
    protected int $pageSize = 50;

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

    public function makeRequest(): RequestBuilder
    {
        // use a factory
        return new RequestBuilder($this);
    }

    public function fetchAll()
    {
        return $this->makeRequest()->getResults();
    }

    public function allCached(): \Generator
    {
        foreach (array_keys($this->cache) as $id) {
            yield $id => $this->getById($id);
        }
    }

    public function loadRawEntries(array $entries)
    {
        foreach ($entries as $entry) {
            $id = $entry['id'];
            $this->cache[$id] = $entry;
        }
    }

    /**
     * @param array|null $reference
     * @return BaseModel|null
     * @throws InvalidReferenceException
     * @throws \DNAFactory\Teamwork\Exceptions\EndpointNotRegisteredException
     */
    public function retriveReference(?array $reference): ?BaseModel
    {
        $type = $reference['type'] ?? null;
        if (is_null($type)) {
            return null;
        }
        if ($type == static::REF_TYPE_NAME) {
            return $this->getByReference($reference);
        }
        return $this->router->retriveReference($reference);
    }

    public function getRawById($id)
    {
        if (!isset($this->cache[$id])) {
            $this->preload([$id]);
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

    public function executeRawRequest(array $request)
    {
        [$skip, $limit, $params] = $this->requestParams($request);
        $unlimited = is_null($limit);
        $n = 0;
        $pageSize = 50;
        $hasMore = true;
        while ($hasMore && ($unlimited || $n < $limit)) {
            $rawResponse = $this->executeRawSingleRequest($params);
            $rawEntries = $this->extractData($rawResponse ?? []);
            $this->loadRawEntries($rawEntries);
            $cutStart = max($skip - $n, 0);
            $cutEnd = min($limit - $n, $pageSize);
            if ($cutStart != 0 || $cutEnd != $pageSize) {
                $rawResponse = array_slice($rawResponse, $cutStart, $cutEnd);
            }
            //yield from $rawEntries;
            foreach ($rawEntries as $entry) {
                yield $entry;
            }
            $n += count($rawEntries);

            $params = $this->nextPage($rawResponse, $params);
            $hasMore = !is_null($params);
        }
    }

    protected function executeRawSingleRequest(array $params)
    {
        /** @var array $rawResponse */
        $rawResponse = $this->rawEndpoint->getAll($params);
        $this->extractIncluded($rawResponse);
        return $rawResponse;
    }

    protected function extractIncluded(array $rawData)
    {
        $included = $rawData['included'] ?? [];
        foreach ($included as $type => $entries) {
            echo "loading " . count($entries) . " $type\n";
            $this->router->loadEntries($type, $entries);
        }
    }

    protected function extractData(array $rawData)
    {
        $path = static::ARRAY_KEY_FOR_ENTRIES ?? null;
        $entries = $rawData[$path] ?? null;
        if (!isset($path, $entries)) {
            throw new NoDataExtractedException();
        }
        return $entries;
    }

    protected function getByReference($reference)
    {
        $id = $reference['id'] ?? null;
        if (!isset($id)) {
            throw new InvalidReferenceException();
        }
        return $this->getById($id);
    }

    protected function requestParams(array $request)
    {
        $skip = $request['startAt'] ?? 0;
        $limit = $request['endAt'] ?? null;
        $params = ['page' => (int)floor($skip / $this->pageSize) + 1];
        return [$skip, $limit, $params];
    }

    protected function nextPage(array $rawResponse, array $params): ?array
    {
        $hasMore = $rawResponse['meta']['page']['hasMore'] ?? false;
        if (!$hasMore) {
            return null;
        }
        $page = $params['page'] ?? 1;
        $params['page'] = $page + 1;
        return $params;
    }

    // use a factory
    protected abstract function makeOne(int $id): BaseModel;

    public abstract function preload(?array $ids);
}
