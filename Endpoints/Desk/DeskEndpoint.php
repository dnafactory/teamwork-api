<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;

abstract class DeskEndpoint extends BaseEndpoint
{
    public function requestParams(array $request): array
    {
        [$skip, $limit, $params] = parent::requestParams($request);
        if (isset($request['relationships'])) {
            // NOTE: this is not a typo, desk uses includeS while projects use include
            $params['includes'] = implode(',', $request['relationships']);
        }
        if (isset($request['filter'])) {
            $params['filter'] = json_encode($request['filter']);
        }
        return [$skip, $limit, $params];
    }

    protected function preload(int $id)
    {
        $instanced = array_keys($this->instancesById);
        $wanted = array_unique([$id, ...$instanced]);
        $cached = array_keys($this->cache);
        $missing = array_diff($wanted, $cached);
        $missing = array_splice($missing, 0, $this->pageSize);
        //echo "preloading ".static::REF_TYPE_NAME." ".count($missing)." ".json_encode($missing)."\n";
        /*if(count($missing) < 2){
            throw new \Exception(json_encode(debug_backtrace()));
        }*/
        $this->makeRequest()
            ->filterBy(['id' => ['$in' => $missing]])
            ->getArray();
    }
}
