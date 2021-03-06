<?php

namespace DNAFactory\Teamwork\Endpoints\Projects;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;
use DNAFactory\Teamwork\Models\BaseModel;

abstract class ProjectsEndpoint extends BaseEndpoint
{
    const REF_NAMESPACE = 'projects';

    public function requestParams(array $request): array
    {
        [$skip, $limit, $params] = parent::requestParams($request);
        if (isset($request['relationships'])) {
            // NOTE: this is not a typo, desk uses includeS while projects use include
            $params['include'] = implode(',', $request['relationships']);
        }
        if (isset($request['filter'])) {
            $params = array_merge($params, $request['filter']);
        }
        return [$skip, $limit, $params];
    }
}
