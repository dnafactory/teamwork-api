<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Exceptions\ConnectionException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class BaseRawEndpoint
{
    protected HttpClient $httpClient;
    protected array $headers = [];
    protected string $baseUrl;
    protected int $limitTimestamp = 0;
    protected int $limitRemaining = 1;
    protected int $waitMargin = 1;
    protected int $maximumTries = 5;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function setHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function setToken(string $token)
    {
        return $this->setHeader('Authorization', 'Bearer ' . $token);
    }

    public function setWaitMargin(int $waitMargin)
    {
        $this->waitMargin = $waitMargin;
        return $this;
    }

    public function setMaximumTries(int $maximumTries)
    {
        $this->maximumTries = $maximumTries;
        return $this;
    }

    protected function call(string $endpoint, array $params = [], $method = 'GET')
    {
        for ($i = 0; $i < $this->maximumTries; $i++) {
            $request = $this->rawCall($endpoint, $params, $method);
            if ($request->getStatusCode() != 429) { // 429 too many requests
                return json_decode($request->getBody(), true);
            }
        }
        throw new ConnectionException("Call to endpoint $endpoint failed after {$i} attempts.");
    }

    protected function rawCall(string $endpoint, array $params, string $method)
    {
        $httpParams = [
            'headers' => $this->headers,
            'query' => http_build_query($params)
        ];

        $uri = $this->baseUrl . $endpoint;
        try {
            $this->waitIfNecessary();
            $request = $this->httpClient->request($method ?? 'GET', $uri, $httpParams);
            $this->updateLimits($request);
            return $request;
        } catch (GuzzleException $e) {
            throw new ConnectionException($e->getMessage());
        }
    }

    protected function waitIfNecessary()
    {
        if ($this->limitTimestamp < time() || $this->limitRemaining > 1) {
            return;
        }
        time_sleep_until($this->limitTimestamp);
    }

    protected function updateLimits(ResponseInterface $request)
    {
        $this->limitRemaining = (int)$request->getHeader('X-Rate-Limit-Remaining')[0];
        $this->limitTimestamp = (int)$request->getHeader('X-Rate-Limit-Reset')[0]+time();
    }

    protected function extractData(array $rawRequest, string $entriesKey)
    {
        $rawData = $rawRequest[$entriesKey];
        $included = $rawRequest['included'];
        $page = array_get_by_path($rawRequest, 'meta.page');
        return [$rawData, $included, $page];
    }

    public abstract function getMany(array $params);
}
