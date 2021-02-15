<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

class RequestBuilder
{
    protected BaseEndpoint $endpoint;
    protected array $relationships;
    protected ?int $limit = null;
    protected int $skip = 0;
    protected array $filter;
    protected array $params;

    public function __construct(BaseEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getArray(): array
    {
        return iterator_to_array($this->getResults());
    }

    public function getResults(): \Generator
    {
        $request = $this->prepareRequest();
        return $this->endpoint->executeRequest($request);
    }

    public function limit(int $limit): RequestBuilder
    {
        $this->limit = $limit;
        return $this;
    }

    public function skip(int $skip): RequestBuilder
    {
        $this->skip = $skip;
        return $this;
    }

    public function filterBy(array $filter): RequestBuilder
    {
        $this->filter = $filter;
        return $this;
    }

    public function preload(array $relationships): RequestBuilder
    {
        $this->relationships = $relationships;
        return $this;
    }

    public function prepareRequest(): array
    {
        $request = [];
        if (isset($this->relationships)) {
            $request['relationships'] = $this->relationships;
        }
        if (isset($this->filter)) {
            $request['filter'] = $this->filter;
        }
        if (isset($this->skip)) {
            $request['startAt'] = $this->skip;
        }
        if (isset($this->limit)) {
            $request['endAt'] = $this->limit;
        }

        return $request;
    }
}
