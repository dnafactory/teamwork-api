<?php

namespace DNAFactory\Teamwork\Endpoints;

use DNAFactory\Teamwork\Exceptions\InvalidReferenceException;
use DNAFactory\Teamwork\Exceptions\NoDataExtractedException;
use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\RawEndpoints\Proxy;
use DNAFactory\Teamwork\Support\RequestBuilder;

abstract class BaseEndpoint
{
    const REF_TYPE_NAME = null;
    const ARRAY_PATH_FOR_ENTRIES = [
        'getById' => null,
        'getAll' => null
    ];

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

    public function makeRequest()
    {
        return new RequestBuilder($this);
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
     * @param array $reference
     * @return BaseModel|mixed
     * @throws InvalidReferenceException
     * @throws \DNAFactory\Teamwork\Exceptions\EndpointNotRegisteredException
     */
    public function retriveReference(array $reference)
    {
        $type = $reference['type'] ?? null;
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
            yield $id => $this->makeOne($id);
        }
    }

    public function executeRawRequest(array $request)
    {
        [$skip, $limit, $params] = $this->requestParams($request);
        $unlimited = is_null($limit);
        $method = 'getAll';
        $n = 0;
        while ($hasMore && ($unlimited || $n < $limit)) {
            echo "\$rawResponse = \$this->executeRawSingleRequest($method, $params);\n";
            $rawEntries = $this->extractData($method, $rawResponse ?? []);
            $this->loadRawEntries($rawEntries);
            if ($skip > $n) {
                $rawEntries = array_slice($rawEntries, $skip - $n);
            }
            yield from $rawEntries;
            $n += count($rawEntries);

            $params = $this->nextPage($rawResponse, $params);
            $hasMore = !is_null($params);
        }
    }

    public function executeRawSingleRequest(string $method, array $params)
    {
        /** @var array $rawResponse */
        $rawResponse = $this->rawEndpoint->$method(...$params);
        $this->extractIncluded($rawResponse);
        return $rawResponse;
    }

    protected function extractIncluded(array $rawData)
    {
        $included = $rawData['included'] ?? [];
        foreach ($included as $type => $entries) {
            echo "loading ".count($entries)." $type\n";
            $this->router->loadEntries($type, $entries);
        }
    }

    protected function extractData(string $method, array $rawData)
    {
        $path = static::ARRAY_PATH_FOR_ENTRIES[$method] ?? null;
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

    public function preload(?array $ids)
    {
        $wanted = $ids ?? array_keys($this->instancesById);
        $cached = array_keys($this->cache);
        $missing = array_diff($wanted, $cached);

        $this->makeRequest()
            ->filterBy(['id', 'in', $missing])
            ->toArray();
    }

    public function requestParams(array $request)
    {
        $skip = $request['startAt'] ?? 0;
        $limit = $request['endAt'] ?? null;
        $params = ['page' => (int)floor($skip / $this->pageSize) + 1];
        if (isset($request['relationships'])) {
            $params['includes'] = implode(',', $request['relationships']);
        }
        if (isset($request['filter'])) {
            $params['filter'] = json_encode($request['filter']);
        }
        return [$skip, $limit, $params];
    }

    public function nextPage(array $rawResponse, array $params): ?array
    {
        $hasMore = $rawResponse['meta']['page']['hasMore'] ?? false;
        if (!$hasMore) {
            return null;
        }
        $params['page'] += 1;
        return $params;
    }

    protected abstract function makeOne(int $id): BaseModel;
}
