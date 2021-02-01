<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;
use DNAFactory\Teamwork\Models\BaseModel;

abstract class ProjectsEndpoint extends BaseEndpoint
{
    public function requestParams(array $request): array
    {
        [$skip, $limit, $params] = parent::requestParams($request);
        if (isset($request['relationships'])) {
            $params['include'] = implode(',', $request['relationships']);
        }
        if (isset($request['filter'])) {
            $params = array_merge($params, $request['filter']);
        }
        return [$skip, $limit, $params];
    }

    // dummy method
    public function preload(?array $ids)
    {
        foreach ($ids as $id) {
            if (!isset($this->cache[$id])) {
                continue;
            }
            $this->cache[$id] = ['id' => $id];
        }
    }
}