<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

abstract class DeskEndpoint extends BaseEndpoint
{
    public function requestParams(array $request): array
    {
        [$skip, $limit, $params] = parent::requestParams($request);
        if (isset($request['relationships'])) {
            $params['includes'] = implode(',', $request['relationships']);
        }
        if (isset($request['filter'])) {
            $params['filter'] = json_encode($request['filter']);
        }
        return [$skip, $limit, $params];
    }

    public function preload(array $ids = [])
    {
        $wanted = $ids ?? array_keys($this->instancesById);
        //$wanted = array_slice(array_unique(array_merge($ids, array_keys($this->instancesById))), 0, $this->pageSize);
        $cached = array_keys($this->cache);
        $missing = array_diff($wanted, $cached);

        $this->makeRequest()
            ->filterBy(['id' => ['$in' => $missing]])
            ->getArray();
    }
}