<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

class Timelogs extends BaseRawEndpoint
{
    public function getMany(array $params = [])
    {
        return $this->call('/v3/time.json', $params);
    }

    public function getManyByProjectId(int $id, array $params = [])
    {
        return $this->call("v3/projects/$id/time.json", $params);
    }
}
