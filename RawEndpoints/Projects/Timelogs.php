<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Timelogs extends BaseRawEndpoint
{
    public function getMany(array $params = [])
    {
        $rawResponse = $this->call('/v3/time.json', $params);
        return $this->extractData($rawResponse, 'timelogs');
    }

    public function setToken(string $token)
    {
        return $this->setHeader('auth', [$token, 'X']);
    }

    public function getManyByProjectId(int $id, array $params = [])
    {
        $rawResponse = $this->call("v3/projects/$id/time.json", $params);
        return $this->extractData($rawResponse, 'timelogs');
    }
}
