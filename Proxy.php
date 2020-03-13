<?php

namespace DNAFactory\Teamwork;

use GuzzleHttp\Client;

class Proxy
{
    protected $client;
    protected $auth;
    protected $baseUrl;
    protected $delay;

    public function __construct($baseUrl, $token, $delay = 65, $client = null)
    {
        $this->baseUrl = $baseUrl;
        $this->delay = $delay;

        if ($client === null) {
            $this->client = new Client();
        }

        $this->setAuth($token);
    }

    public function setAuth($token)
    {
        $this->auth = [$token, 'X'];
    }

    public function call($endpoint, $params = array(), $type = 'GET')
    {
        $endpoint = $this->baseUrl . $endpoint;

        if ($type == 'GET') {
            if (!empty($params)) {
                $params['query'] = http_build_query($params);
            }
        } else {
            if (!empty($params)) {
                $params['body'] = json_encode($params);
            }
        }

        $params['auth'] = $this->auth;

        try {
            $response = $this->client->request($type, $endpoint, $params);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), "429 Too Many Requests") !== false) {
                sleep($this->delay);
                $response = $this->client->request($type, $endpoint, $params);
            } else {
                throw new \Exception($e->getMessage());
            }
        }

        $body = $response->getBody();
        $content = json_decode($body->getContents());

        if ($content->STATUS != 'OK') {
            throw new \Exception("Generic error");
        }

        return $content;
    }
}
