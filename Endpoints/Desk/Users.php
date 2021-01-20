<?php

namespace DNAFactory\Teamwork\Endpoints\Desk;

use DNAFactory\Teamwork\Endpoints\BaseEndpoint;
use DNAFactory\Teamwork\Endpoints\Router;
use DNAFactory\Teamwork\Models\User;
use DNAFactory\Teamwork\RawEndpoints\Desk\Users as RawUsers;

class Users extends BaseEndpoint
{
    const REF_TYPE_NAME = 'users';
    const ARRAY_PATH_FOR_ENTRIES = [
        'getById' => 'user',
        'getAll' => 'users'
    ];

    public function __construct(RawUsers $rawEndpoint, Router $router)
    {
        parent::__construct($rawEndpoint, $router);
    }

    protected function makeOne(int $id): User
    {
        return new User($this, $id, ['id' => $id]);
    }
}
