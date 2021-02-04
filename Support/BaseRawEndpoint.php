<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Exceptions\ConnectionException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
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
        for ($i = 0; $i < $this->maximumTries+150; $i++) {
            try {
                $response = $this->rawCall($endpoint, $params, $method);
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $this->updateLimits($e->getResponse());
                }
                continue;
            }
            return json_decode($response->getBody(), true);
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

        $this->waitIfNecessary();
        $response = $this->httpClient->request($method ?? 'GET', $uri, $httpParams);
        $this->updateLimits($response);
        return $response;
    }

    protected function waitIfNecessary()
    {
        if ($this->limitTimestamp < time() || $this->limitRemaining > 0) {
            return;
        }
        time_sleep_until($this->limitTimestamp);
    }

    protected function updateLimits(ResponseInterface $response)
    {
        $this->limitRemaining = (int)$response->getHeader('X-Rate-Limit-Remaining')[0];
        $this->limitTimestamp = (int)$response->getHeader('X-Rate-Limit-Reset')[0]+time();
    }

    protected function extractData(array $rawResponse, string $keyForData)
    {
        $rawData = $rawResponse[$keyForData] ?? [];
        $included = $rawResponse['included'] ?? [];
        $page = $rawResponse['meta']['page'] ?? [];
        return [$rawData, $included, $page];
    }

    public abstract function getMany(array $params);
}
