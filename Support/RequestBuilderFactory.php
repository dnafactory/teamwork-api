<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

class RequestBuilderFactory
{
    public $endpoint;

    public function makeOne()
    {
        return new RequestBuilder($this->endpoint);
    }
}