<?php

namespace DNAFactory\Teamwork\Support;

use DNAFactory\Teamwork\Exceptions\ConnectionException;
use DNAFactory\Teamwork\Exceptions\ItemNotFoundException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

abstract class BaseRawEndpoint
{
    const ENCODING_QUERY = 'query';
    const ENCODING_FORM_URLENCODE = 'form-urlencode';
    const ENCODING_JSON = 'json';

    protected HttpClient $httpClient;
    protected array $httpParams = [];
    protected string $baseUrl;
    protected int $defaultWait = 60;
    protected int $waitMargin = 1;
    protected int $maximumTries = 5;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function setHeader(string $name, $value)
    {
        $this->httpParams['headers'][$name] = $value;
        return $this;
    }

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setWaitMargin(int $waitMargin): BaseRawEndpoint
    {
        $this->waitMargin = $waitMargin;
        return $this;
    }

    public function setDefaultWait(int $defaultWait): BaseRawEndpoint
    {
        $this->defaultWait = $defaultWait;
        return $this;
    }

    public function setMaximumTries(int $maximumTries): BaseRawEndpoint
    {
        $this->maximumTries = $maximumTries;
        return $this;
    }

    protected function call(string $endpoint, array $params = [], $method = 'GET', $encoding = self::ENCODING_QUERY)
    {
        for ($i = 0; $i < $this->maximumTries + 150; $i++) {
            try {
                $response = $this->rawCall($endpoint, $params, $method, $encoding);
            } catch (RequestException $e) {
                //echo $e->getMessage();
                $response = $e->hasResponse() ? $e->getResponse() : null;
                if(!is_null($response) && $response->getStatusCode() == 404){
                    throw new ItemNotFoundException("Endpoint call '$endpoint' gives 404 Not Found.");
                }
                $this->waitRateLimit($response);
                continue;
            }
            return json_decode($response->getBody(), true);
        }
        throw new ConnectionException("Call to endpoint $endpoint failed after {$i} attempts.");
    }

    protected function rawCall(string $endpoint, array $params, string $method, string $encoding)
    {
        $httpParams = $this->httpParams;
        if ($encoding == self::ENCODING_JSON) {
            $httpParams['body'] = json_encode($params);
            $httpParams['headers']['Content-type'] = 'application/json';
        } elseif ($encoding == self::ENCODING_FORM_URLENCODE) {
            $httpParams['body'] = http_build_query($params);
        } elseif ($encoding == self::ENCODING_QUERY) {
            $httpParams['query'] = http_build_query($params);
        }

        $uri = $this->baseUrl . $endpoint;
        $response = $this->httpClient->request($method, $uri, $httpParams);
        return $response;
    }

    protected function waitRateLimit(?ResponseInterface $response)
    {
        $wait = null;
        if (!is_null($response)) {
            $wait = $response->getHeader('X-Rate-Limit-Reset');
        }
        $wait = $wait ? (int)$wait[0] : $this->defaultWait;
        time_sleep_until(time() + $wait + $this->waitMargin);
    }

    protected function extractData(array $rawResponse, string $keyForData)
    {
        $rawData = $rawResponse[$keyForData] ?? [];
        $included = $rawResponse['included'] ?? [];
        $page = $rawResponse['meta']['page'] ?? [];
        return [$rawData, $included, $page];
    }

    public abstract function getById(int $id, array $params);

    public abstract function getMany(array $params);

    public abstract function setToken(string $token): BaseRawEndpoint;
}
