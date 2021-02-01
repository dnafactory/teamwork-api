<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

use DNAFactory\Teamwork\RawEndpoints\Proxy;

class Timelogs extends Proxy
{
    public function getAll(array $params = [])
    {
        return $this->jsonCall('/v3/time.json', $params);
    }

    public function getAllByProjectId(int $id, array $params = [])
    {
        return $this->jsonCall("v3/projects/$id/time.json", $params);
    }
}
