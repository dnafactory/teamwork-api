<?php

namespace DNAFactory\Teamwork\RawEndpoints\Projects;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

abstract class ProjectsRawEndpoint extends BaseRawEndpoint
{
    public function setToken(string $token): BaseRawEndpoint
    {
        $this->httpParams['auth'] = [$token, 'whatever'];
        return $this;
    }
}
