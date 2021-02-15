<?php

namespace DNAFactory\Teamwork\RawEndpoints\Desk;

use DNAFactory\Teamwork\Support\BaseRawEndpoint;

abstract class DeskRawEndpoint extends BaseRawEndpoint
{
    public function setToken(string $token): BaseRawEndpoint
    {
        return $this->setHeader('Authorization', 'Bearer ' . $token);
    }
}
