<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

class RequestBuilder
{
    protected BaseEndpoint $endpoint;
    protected array $relationships;
    protected int $limit;
    protected int $skip;
    protected array $filter;

    public function __construct(BaseEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function toArray(): array
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


    protected function prepareRequest(): array
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
            $request['endAt'] = $this->skip + $this->limit;
        }
        return $request;
    }
}